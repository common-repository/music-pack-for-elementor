<?php

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class MPACK_Event_Single_Details extends Widget_Base {
    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'sm-event-single-details';
    }

    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Event Single: Details', 'music-pack' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve oEmbed widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-play mpack-widget-icon';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['mpack-widgets'];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['music pack', 'event single', 'event details'];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'music-pack' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'icon_color_get_pro', [
            'label'     => esc_html__( 'Icon Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icon_size_get_pro', [
            'label'     => esc_html__( 'Icon Size', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 30,
                    'min'  => 10,
                    'step' => 1,
                ],
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icon_space_get_pro', [
            'label'     => esc_html__( 'Icon Space', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 30,
                    'min'  => 5,
                    'step' => 1,
                ],
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_1_get_pro', [
            'type'  => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'text_color_get_pro', [
            'label'     => esc_html__( 'Text Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->start_controls_tabs( 'link_colors_get_pro' );
        $this->start_controls_tab( 'normal_get_pro', [
            'label' => esc_html__( 'Normal', 'music-pack' ),
        ] );
        $this->add_control( 'link_color_get_pro', [
            'label'     => esc_html__( 'Link Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'hover_get_pro', [
            'label' => esc_html__( 'Hover', 'music-pack' ),
        ] );
        $this->add_control( 'link_color_hov_get_pro', [
            'label'     => esc_html__( 'Link Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        /*get pro controls ]]]*/
        $this->end_controls_section();
    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        if ( !is_singular( "js_events" ) ) {
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo esc_html__( "This widget should be used in single events.", 'music-pack' );
            }
            return;
        }
        global $post;
        $event_id = $post->ID;
        $event_multiday = get_post_meta( $event_id, 'event_multiday', true );
        $output_date = $output_time = '';
        $this->get_output_date_time(
            $event_id,
            $event_multiday,
            $output_date,
            $output_time,
            $schema_time
        );
        ?>

		<div class="event_short_details">
			<div class="lc_event_entry" itemprop="startDate" content="<?php 
        echo esc_html( $schema_time );
        ?>">
				<i class="far fa-calendar-alt" aria-hidden="true"></i>
				<span class="event_single_detail">
				<?php 
        echo esc_html( $output_date );
        if ( !empty( $event_multiday ) ) {
            echo esc_html( "&#32;&#45;&#32;" . $output_end_date );
        }
        ?>
				</span>
			</div>

			<?php 
        if ( $output_time != '' ) {
            ?>
			<div class="lc_event_entry">
				<i class="far fa-clock" aria-hidden="true"></i>
				<span class="event_single_detail">
					<?php 
            echo esc_html( $output_time );
            ?>
				</span>
			</div>
			<?php 
        }
        ?>

			<?php 
        $event_location = get_post_meta( $event_id, 'event_location', true );
        ?>
			<div class="swp_ev_location_venue" itemprop="location" itemscope itemtype="http://schema.org/Place">
				<?php 
        if ( $event_location != '' ) {
            ?>
				<div class="lc_event_entry">
					<i class="fas fa-map-marker-alt" aria-hidden="true"></i>
	    			<span itemprop="address" class="event_single_detail"> <?php 
            echo esc_html( $event_location );
            ?> </span>
				</div>
				<?php 
        }
        ?>

				<?php 
        $event_venue = get_post_meta( $event_id, 'event_venue', true );
        $event_venue_url = get_post_meta( $event_id, 'event_venue_url', true );
        $have_venue_url = ( strlen( $event_venue_url ) ? true : false );
        $venue_target = get_post_meta( $event_id, 'event_venue_target', true );
        if ( empty( $venue_target ) ) {
            $venue_target = "_blank";
        }
        ?>

				<?php 
        if ( $event_venue ) {
            ?>
				<div class="lc_event_entry">
					<i class="fas fa-map-pin" aria-hidden="true"></i>
					<span class="event_single_detail">
						<?php 
            if ( $have_venue_url ) {
                ?>
						<a href="<?php 
                echo esc_url( $event_venue_url );
                ?>" target="<?php 
                echo esc_attr( $venue_target );
                ?>">
						<?php 
            }
            ?>
							<span itemprop="name"><?php 
            echo esc_html( $event_venue );
            ?></span>
						<?php 
            if ( $have_venue_url ) {
                ?>
						</a>
						<?php 
            }
            ?>
					</span>
				</div>
				<?php 
        }
        ?>
			</div>

			<div class="display_none" itemprop="performer" itemscope="" itemtype="http://schema.org/MusicGroup">
				<span itemprop="name"><?php 
        bloginfo( 'name' );
        ?></span>
			</div>

			<?php 
        $event_artists = get_post_meta( $event_id, 'swp_artist_selection', true );
        if ( !empty( $event_artists ) ) {
            $artists_array = explode( ',', $event_artists );
        }
        ?>

			<?php 
        if ( !empty( $event_artists ) ) {
            ?>
			<div class="lc_event_entry">
				<i class="far fa-user"></i>
				<span class="event_single_detail">
					<?php 
            foreach ( $artists_array as $single_artist ) {
                ?>
						<a class="artist_name_in_event" href="<?php 
                echo esc_url( get_the_permalink( $single_artist ) );
                ?>"> <?php 
                echo esc_html( get_the_title( $single_artist ) );
                ?></a>
					<?php 
            }
            ?>
				</span>
			</div>
			<?php 
        }
        ?>

			<div class="lc_event_entry display_none" itemprop="name">
				<?php 
        the_title();
        ?>
			</div>
			<a itemprop="url" href="<?php 
        the_permalink();
        ?>" class="display_none">Event</a>
		</div>
		<?php 
    }

    private function get_output_date_time(
        $event_id,
        $event_multiday,
        &$output_date,
        &$output_time,
        &$schema_time
    ) {
        $event_date = get_post_meta( $event_id, 'event_date', true );
        $event_time = get_post_meta( $event_id, 'event_time', true );
        /*data processing*/
        $event_date = str_replace( "/", "-", $event_date );
        try {
            $dateObject = new DateTime($event_date);
        } catch ( Exception $e ) {
            $dateObject = new DateTime('NOW');
        }
        $output_date = date_i18n( get_option( 'date_format' ), $dateObject->format( 'U' ) );
        /*default schema time stamp - if time is not specified*/
        $schema_time = $dateObject->format( DateTime::ATOM );
        $output_time = '';
        if ( $event_time != '' ) {
            $build_time = $event_date . " " . $event_time . ":00";
            if ( strtotime( $build_time ) ) {
                $time_obj = new DateTime($build_time);
                $output_time = $time_obj->format( get_option( 'time_format' ) );
                $schema_time = $time_obj->format( DateTime::ATOM );
            } else {
                $output_time = $event_time;
            }
        }
        /*multiday & end date*/
        if ( !empty( $event_multiday ) ) {
            $event_end_date = get_post_meta( $event_id, 'event_end_date', true );
            if ( $event_end_date != "" ) {
                $event_end_date = str_replace( "/", "-", $event_end_date );
                try {
                    $endDateObject = new DateTime($event_end_date);
                } catch ( Exception $e ) {
                    $endDateObject = new DateTime('NOW');
                }
                $output_end_date = date_i18n( get_option( 'date_format' ), $endDateObject->format( 'U' ) );
            }
        }
    }

}
