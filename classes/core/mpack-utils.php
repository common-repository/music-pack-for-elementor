<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class MPACK_Utils {
    public static function render_select_options( $options, $selected ) {
        foreach ( $options as $key => $value ) {
            if ( $value == $selected ) {
                ?>
				<option value="<?php 
                echo esc_attr( $value );
                ?>" selected="selected"> <?php 
                echo esc_attr( $key );
                ?> </option>
				<?php 
            } else {
                ?>
				<option value="<?php 
                echo esc_attr( $value );
                ?>"> <?php 
                echo esc_attr( $key );
                ?> </option>
				<?php 
            }
        }
    }

    public static function get_albums_args( $albums_no, $album_cat, $artist_id ) {
        $args = array(
            'numberposts'      => $albums_no,
            'posts_per_page'   => $albums_no,
            'orderby'          => 'meta_value',
            'meta_key'         => 'album_release_date',
            'order'            => 'DESC',
            'post_type'        => 'js_albums',
            'post_status'      => 'publish',
            'suppress_filters' => false,
        );
        if ( "0" != $artist_id ) {
            $args['meta_query'] = array(array(
                'key'     => 'swp_artist_selection',
                'value'   => $artist_id,
                'compare' => 'LIKE',
            ));
        }
        if ( '0' != $album_cat && strlen( $album_cat ) ) {
            $args["tax_query"] = array(array(
                'taxonomy' => 'album_category',
                'field'    => 'term_id',
                'terms'    => $album_cat,
            ));
        }
        return $args;
    }

    public static function get_events_args_for_query( $widget_settings ) {
        /*default - next events*/
        $meta_query_event = array(
            'relation'   => 'AND',
            'event_date' => array(
                'key'     => 'event_date',
                'value'   => date( 'Y/m/d', current_time( 'timestamp' ) ),
                'compare' => '>=',
            ),
            'event_time' => array(
                'key' => 'event_time',
            ),
        );
        /*shows past events*/
        if ( "past" == $widget_settings['past_next'] ) {
            $meta_query_event = array(
                'relation'   => 'AND',
                'event_date' => array(
                    'key'     => 'event_date',
                    'value'   => date( 'Y/m/d', current_time( 'timestamp' ) ),
                    'compare' => '<',
                ),
                'event_time' => array(
                    'key' => 'event_time',
                ),
            );
        }
        if ( "all" == $widget_settings['past_next'] ) {
            $meta_query_event = '';
        }
        $order_events_by = array(
            'event_date' => $widget_settings['sort_events'],
            'event_time' => $widget_settings['sort_events'],
        );
        $args = array(
            'numberposts'      => $widget_settings['count'],
            'posts_per_page'   => $widget_settings['count'],
            'offset'           => 0,
            'category'         => '',
            'orderby'          => $order_events_by,
            'order'            => $widget_settings['sort_events'],
            'meta_key'         => 'event_date',
            'post_type'        => 'js_events',
            'post_status'      => 'publish',
            'suppress_filters' => false,
            'meta_query'       => $meta_query_event,
        );
        /*filter by artist*/
        if ( "0" != $widget_settings['artist_id'] ) {
            $args['meta_query'][] = array(
                'key'     => 'swp_artist_selection',
                'value'   => $widget_settings['artist_id'],
                'compare' => 'LIKE',
            );
        }
        if ( '0' != $widget_settings['event_category'] && strlen( $widget_settings['event_category'] ) ) {
            $args["tax_query"] = array(array(
                'taxonomy' => 'event_category',
                'field'    => 'term_id',
                'terms'    => $widget_settings['event_category'],
            ));
        }
        return $args;
    }

    public static function get_artists_args( $artistsnumber, $artist_category ) {
        $args = array(
            'numberposts'      => $artistsnumber,
            'posts_per_page'   => $artistsnumber,
            'offset'           => 0,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'js_artist',
            'post_status'      => 'publish',
            'suppress_filters' => false,
        );
        if ( '0' != $artist_category && strlen( $artist_category ) ) {
            $args["tax_query"] = array(array(
                'taxonomy' => 'artist_category',
                'field'    => 'term_id',
                'terms'    => $artist_category,
            ));
        }
        return $args;
    }

    public static function get_posts_args( $postsno, $post_cat ) {
        $args = array(
            'numberposts'      => $postsno,
            'posts_per_page'   => $postsno,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => false,
        );
        if ( '0' != $post_cat ) {
            $args['cat'] = $post_cat;
        }
        return $args;
    }

    public static function get_event_data( $post_id ) {
        $event_obj = array();
        $event_obj['event_title'] = get_the_title( $post_id );
        $event_obj['event_venue'] = get_post_meta( $post_id, 'event_venue', true );
        $event_obj['event_buy_tickets_message'] = esc_html( get_post_meta( $post_id, 'event_buy_tickets_message', true ) );
        $event_obj['event_buy_tickets_url'] = esc_html( get_post_meta( $post_id, 'event_buy_tickets_url', true ) );
        $event_obj['event_buy_tickets_target'] = esc_html( get_post_meta( $post_id, 'event_buy_tickets_target', true ) );
        $event_canceled = esc_html( get_post_meta( $post_id, 'event_canceled', true ) );
        $event_obj['event_canceled'] = ( empty( $event_canceled ) ? false : true );
        $event_sold_out = esc_html( get_post_meta( $post_id, 'event_sold_out', true ) );
        $event_obj['event_sold_out'] = ( empty( $event_sold_out ) ? false : true );
        $event_obj['post_thumbnail'] = ( has_post_thumbnail( $post_id ) ? get_the_post_thumbnail_url( '', 'full' ) : "" );
        $event_date = esc_html( get_post_meta( $post_id, 'event_date', true ) );
        if ( $event_date != "" ) {
            @($event_date = str_replace( "/", "-", $event_date ));
            @($dateObject = new DateTime($event_date));
        }
        $event_obj['el_day'] = $dateObject->format( 'd' );
        $el_month = $dateObject->format( 'M' );
        $event_obj['el_month'] = self::get_translated_month( $el_month );
        return $event_obj;
    }

    public static function slide_get_event_data_for_list( $post_id ) {
        $event_obj = array();
        $event_obj['event_title'] = get_the_title( $post_id );
        $event_obj['event_location'] = get_post_meta( get_the_ID(), 'event_location', true );
        $event_obj['event_venue'] = get_post_meta( get_the_ID(), 'event_venue', true );
        $event_obj['event_buy_tickets_target'] = esc_html( get_post_meta( $post_id, 'event_buy_tickets_target', true ) );
        if ( empty( $event_obj['event_buy_tickets_target'] ) ) {
            $event_obj['event_buy_tickets_target'] = "_blank";
        }
        $event_obj['event_buy_tickets_url'] = esc_html( get_post_meta( $post_id, 'event_buy_tickets_url', true ) );
        if ( empty( $event_obj['event_buy_tickets_url'] ) ) {
            $event_obj['event_buy_tickets_url'] = get_the_permalink( $post_id );
            $event_obj['event_buy_tickets_target'] = "_self";
        }
        $event_obj['event_buy_tickets_message'] = esc_html( get_post_meta( $post_id, 'event_buy_tickets_message', true ) );
        $event_canceled = esc_html( get_post_meta( $post_id, 'event_canceled', true ) );
        $event_obj['event_canceled'] = ( empty( $event_canceled ) ? false : true );
        $event_sold_out = esc_html( get_post_meta( $post_id, 'event_sold_out', true ) );
        $event_obj['event_sold_out'] = ( empty( $event_sold_out ) ? false : true );
        /*compute event date first*/
        $event_date = esc_html( get_post_meta( $post_id, 'event_date', true ) );
        if ( $event_date != "" ) {
            @($event_date = str_replace( "/", "-", $event_date ));
            @($dateObject = new DateTime($event_date));
        }
        $el_month = $dateObject->format( 'M' );
        $event_obj['el_day'] = $dateObject->format( 'd' );
        $event_obj['el_month'] = self::get_translated_month( $el_month );
        $event_obj['el_year'] = $dateObject->format( 'Y' );
        $event_obj['event_multiday'] = ( empty( get_post_meta( $post_id, 'event_multiday', true ) ) ? false : true );
        $event_obj['endDateObj'] = "";
        $event_obj['el_end_day'] = "";
        $have_multiday_date = false;
        if ( $event_obj['event_multiday'] ) {
            $event_end_date = esc_html( get_post_meta( $post_id, 'event_end_date', true ) );
            if ( $event_end_date != "" ) {
                $event_end_date = str_replace( "/", "-", $event_end_date );
                $event_obj['endDateObj'] = new DateTime($event_end_date);
                $event_obj['el_end_day'] = $event_obj['endDateObj']->format( 'd' );
                $have_multiday_date = true;
            }
        }
        $event_obj['have_multiday_date'] = $have_multiday_date;
        /*default schema time stamp - if time is not specified*/
        $event_obj['event_time'] = esc_html( get_post_meta( $post_id, 'event_time', true ) );
        $dateObjectNow = new DateTime('NOW');
        $output_time = '';
        if ( $event_obj['event_time'] != '' ) {
            $build_time = $event_date . " " . $event_obj['event_time'] . ":00";
            if ( strtotime( $build_time ) ) {
                $time_obj = new DateTime($build_time);
                $output_time = $time_obj->format( get_option( 'time_format' ) );
            } else {
                $output_time = $event_obj['event_time'];
            }
        }
        $event_obj['output_time'] = $output_time;
        $dateObjectTomorrow = new DateTime('tomorrow');
        $event_obj['is_event_today'] = ( $dateObjectNow->format( 'Y-m-d' ) == $dateObject->format( 'Y-m-d' ) ? true : false );
        $event_obj['is_event_tomorrow'] = ( $dateObjectTomorrow->format( 'Y-m-d' ) == $dateObject->format( 'Y-m-d' ) ? true : false );
        /*buy tickets button*/
        $button_class = "event_buy_btn ";
        $button_text = "";
        if ( $event_canceled ) {
            $button_class .= "event_canceled event_btn_inactive";
            $button_text = esc_html__( "Canceled", 'music-pack' );
        } elseif ( $event_sold_out ) {
            $button_class .= "event_sold_out event_btn_inactive";
            $button_text = esc_html__( "Sold Out", 'music-pack' );
        } else {
            $button_class .= "lc_js_link";
            $button_text = $event_obj['event_buy_tickets_message'];
        }
        $event_obj['tickets_btn_class'] = $button_class;
        $event_obj['tickets_btn_text'] = $button_text;
        return $event_obj;
    }

    public static function get_translated_month( $english_month_name ) {
        switch ( strtolower( $english_month_name ) ) {
            case "jan":
                return esc_html__( "jan", 'slide' );
            case "feb":
                return esc_html__( "feb", 'slide' );
            case "mar":
                return esc_html__( "mar", 'slide' );
            case "apr":
                return esc_html__( "apr", 'slide' );
            case "may":
                return esc_html__( "may", 'slide' );
            case "jun":
                return esc_html__( "jun", 'slide' );
            case "jul":
                return esc_html__( "jul", 'slide' );
            case "aug":
                return esc_html__( "aug", 'slide' );
            case "sep":
                return esc_html__( "sep", 'slide' );
            case "oct":
                return esc_html__( "oct", 'slide' );
            case "nov":
                return esc_html__( "nov", 'slide' );
            case "dec":
                return esc_html__( "dec", 'slide' );
        }
        return $english_month_name;
    }

    public static function get_tax_name_by_post_type( $post_type ) {
        switch ( $post_type ) {
            case "js_albums":
                return 'album_category';
            case 'js_events':
                return 'event_category';
            case 'js_photo_albums':
                return 'photo_album_category';
            case 'js_videos':
                return 'video_category';
            case 'js_artist':
                return 'artist_category';
            default:
                return 'category';
        }
    }

    public static function create_photo_album_gallery_from_ids( $post_id ) {
        $images = esc_html( get_post_meta( $post_id, 'js_swp_gallery_images_id', true ) );
        $id_array = explode( ',', $images );
        $id_array = array_filter( $id_array );
        if ( empty( $id_array ) ) {
            return array();
        }
        $galleryImages = array();
        foreach ( $id_array as $imgId ) {
            $singleObj = array();
            $attachObj = get_post( $imgId );
            if ( has_excerpt( $imgId ) ) {
                /*on single gallery might throw error*/
                $singleObj['caption'] = $attachObj->post_excerpt;
            } else {
                $singleObj['caption'] = '';
            }
            if ( $imageSrc = wp_get_attachment_image_src( $imgId, 'full' ) ) {
                $singleObj['href'] = $imageSrc[0];
            } else {
                $singleObj['href'] = '';
            }
            $singleObj['image'] = wp_get_attachment_image(
                $imgId,
                'medium_large',
                false,
                [
                    'class' => 'transition4',
                ]
            );
            $galleryImages[] = $singleObj;
        }
        return $galleryImages;
    }

    public static function get_template( $template ) {
        require_once MPACK_TEMPLATE_PATH . $template;
    }

    public static function render_embedded_video( $youtube_url, $vimeo_url ) {
        if ( $youtube_url != "" ) {
            echo $GLOBALS['wp_embed']->run_shortcode( '[embed]' . esc_url( $youtube_url ) . '[/embed]' );
            return;
        }
        if ( $vimeo_url != "" ) {
            echo $GLOBALS['wp_embed']->run_shortcode( '[embed]' . esc_url( $vimeo_url ) . '[/embed]' );
        }
    }

    public static function sanitize_date( $dateString, $outputFormat = 'Y-m-d' ) {
        $timestamp = strtotime( $dateString );
        if ( $timestamp === false ) {
            return date( "Y-m-d", strtotime( "today" ) );
        }
        /*ok*/
        return $dateString;
    }

    public static function sanitize_time( $timeString, $outputFormat = 'H:i' ) {
        if ( preg_match( '/^(\\d{1,2}):(\\d{2})$/', $timeString, $matches ) ) {
            $hours = intval( $matches[1] );
            $minutes = intval( $matches[2] );
            if ( $hours >= 0 && $hours <= 23 && $minutes >= 0 && $minutes <= 59 ) {
                /*ok*/
                return $timeString;
            }
        }
        return '00:00';
    }

    public static function sanitize_array_values( $value, $allowedValues ) {
        if ( empty( $allowedValues ) ) {
            return '';
        }
        if ( in_array( $value, $allowedValues, true ) ) {
            return $value;
        }
        return $allowedValues[0];
    }

    public static function sanitize_ids_array( $postIDs ) {
        $sanitizedIDs = array();
        foreach ( $postIDs as $postID ) {
            if ( is_numeric( $postID ) && intval( $postID ) > 0 ) {
                $sanitizedIDs[] = intval( $postID );
            }
        }
        return $sanitizedIDs;
    }

    public static function is_post_type( $post_id, $post_type ) {
        $current_post_type = get_post_type( $post_id );
        if ( $post_type != $current_post_type ) {
            return false;
        }
        return true;
    }

    public static function get_available_templates() {
        return '[{"img":"About Section With Artist Image.jpg","file":"","available":"0","name":"About Section With Artist Image","tags":"about, bright"},{"img":"About Section With Video.jpg","file":"","available":"0","name":"About Section With Video","tags":"dark, about"},{"img":"Artist.jpg","file":"","available":"0","name":"Artist","tags":"dark, artist"},{"img":"Blog Posts With Images.jpg","file":"","available":"0","name":"Blog Posts With Images","tags":"dark, blog"},{"img":"Blog Posts Without Images Dark.jpg","file":"","available":"0","name":"Blog Posts Without Images Dark","tags":"dark, blog"},{"img":"Blog Posts Without Images.jpg","file":"","available":"0","name":"Blog Posts Without Images","tags":"bright, blog"},{"img":"Contact Form and Details.jpg","file":"","available":"0","name":"Contact Form and Details","tags":"dark, contact"},{"img":"Contact Form Creative.jpg","file":"","available":"0","name":"Contact Form Creative","tags":"dark, contact, creative"},{"img":"Creative Gallery.jpg","file":"","available":"0","name":"Creative Gallery","tags":"dark, gallery, creative"},{"img":"Discography Creative.jpg","file":"","available":"0","name":"Discography Creative","tags":"dark, discography, creative"},{"img":"Discography Grid.jpg","file":"","available":"0","name":"Discography Grid","tags":"dark, discography"},{"img":"Discography Vinyl Style Bright.jpg","file":"","available":"0","name":"Discography Vinyl Style Bright","tags":"bright, discography, vinyl"},{"img":"Discography Vinyl Style.jpg","file":"","available":"0","name":"Discography Vinyl Style","tags":"dark, discography, vinyl"},{"img":"Event Countdown Timer Bright.jpg","file":"","available":"0","name":"Event Countdown Timer Bright","tags":"bright, events, timer"},{"img":"Event Countdown Timer.jpg","file":"","available":"0","name":"Event Countdown Timer","tags":"vibrant, events, timer"},{"img":"Events Cards.jpg","file":"","available":"0","name":"Events Cards","tags":"dark, events"},{"img":"Events List Bright.jpg","file":"","available":"0","name":"Events List Bright","tags":"bright, events"},{"img":"Events List Dark.jpg","file":"","available":"0","name":"Events List Dark","tags":"dark, events"},{"img":"Events List Navy.jpg","file":"","available":"0","name":"Events List Navy","tags":"dark, events"},{"img":"Footer v1.jpg","file":"","available":"0","name":"Footer v1","tags":"footer"},{"img":"Footer v2.jpg","file":"","available":"0","name":"Footer v2","tags":"footer"},{"img":"Footer v3.jpg","file":"","available":"0","name":"Footer v3","tags":"footer"},{"img":"Footer v4.jpg","file":"","available":"0","name":"Footer v4","tags":"footer"},{"img":"Gallery Promo.jpg","file":"","available":"0","name":"Gallery Promo","tags":"gallery"},{"img":"Hero Section v1.jpg","file":"","available":"0","name":"Hero Section v1","tags":"hero"},{"img":"Hero Section v2.jpg","file":"","available":"0","name":"Hero Section v2","tags":"hero"},{"img":"Hero Section v3.jpg","file":"","available":"0","name":"Hero Section v3","tags":"hero"},{"img":"Hero Section v4.jpg","file":"","available":"0","name":"Hero Section v4","tags":"hero"},{"img":"Home Page v1.jpg","file":"","available":"0","name":"Home Page v1","tags":"landing"},{"img":"Home Page v2.jpg","file":"","available":"0","name":"Home Page v2","tags":"landing"},{"img":"Home Page v3.jpg","file":"","available":"0","name":"Home Page v3","tags":"landing"},{"img":"Home Page v4.jpg","file":"","available":"0","name":"Home Page v4","tags":"landing"},{"img":"MailChimp Newsletter Form.jpg","file":"","available":"0","name":"MailChimp Newsletter Form","tags":"dark, newsletter"},{"img":"MailChimp Subscription Form Vertical.jpg","file":"","available":"0","name":"MailChimp Subscription Form Vertical","tags":"bright, newsletter"},{"img":"Music Player Album Promo With Playlist.jpg","file":"","available":"0","name":"Music Player Album Promo With Playlist","tags":"player"},{"img":"Music Player Album Style.jpg","file":"","available":"0","name":"Music Player Album Style","tags":"player"},{"img":"Music Player Playlist Style.jpg","file":"","available":"0","name":"Music Player Playlist Style","tags":"player"},{"img":"QuoteTestimonial Section.jpg","file":"","available":"0","name":"Quote/Testimonial Section","tags":"testimonial"},{"img":"ReviewsTestimonials Section.jpg","file":"","available":"0","name":"Reviews/Testimonials Section","tags":"testimonial"},{"img":"Video Button Section v2.jpg","file":"","available":"0","name":"Video Button Section v2","tags":"video"},{"img":"Video Button Section.jpg","file":"","available":"0","name":"Video Button Section","tags":"video"}]';
    }

}
