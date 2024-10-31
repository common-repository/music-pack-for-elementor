<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}
/**
 * Elementor video widget.
 *
 * Elementor widget that displays a video player.
 *
 * @since 1.0.0
 */
class MPACK_Widget_Videos extends Widget_Base {
    /**
     * Get widget name.
     *
     * Retrieve video widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'mp-videos';
    }

    /**
     * Get widget title.
     *
     * Retrieve video widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Videos', 'music-pack' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve video widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-play mpack-widget-icon';
    }

    public function get_script_depends() {
        return ['mpack-front'];
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the video widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
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
        return [
            'music pack',
            'videos',
            'player',
            'embed',
            'youtube',
            'vimeo',
            'dailymotion'
        ];
    }

    /**
     * Register video widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section( 'section_video', [
            'label' => __( 'Videos', 'music-pack' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'count', [
            'label'   => __( 'Videos Number', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 100,
            'step'    => 1,
            'default' => 4,
        ] );
        $this->add_control( 'video_category', [
            'label'   => __( 'Video Category', 'lucille-music-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '0',
            'options' => $this->get_videos_cat_as_array(),
        ] );
        $this->add_control( 'separator_panel_0', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'link_to', [
            'label'   => __( 'On Click', 'music-pack' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'link_to_post' => __( 'Link To Video Post', 'music-pack' ),
                'play_video'   => __( 'Play Video', 'music-pack' ),
            ],
            'default' => 'link_to_post',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_video_style', [
            'label' => __( 'Videos', 'music-pack' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'text_align', [
            'label'     => __( 'Text Align', 'music-pack' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [
                    'title' => __( 'Left', 'music-pack' ),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __( 'Center', 'music-pack' ),
                    'icon'  => 'eicon-text-align-center',
                ],
                'right'  => [
                    'title' => __( 'Right', 'music-pack' ),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .single_video_details' => 'text-align: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'separator_panel_1', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'vibrant_col', [
            'label'     => __( 'Vibrant Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '#fb3a64',
            'selectors' => [
                '{{WRAPPER}} .single_video_item:hover i' => 'border-color: {{VALUE}} !important; background-color: {{VALUE}};',
            ],
        ] );
        /*get pro controls*/
        $this->add_control( 'separator_panel_2_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Category Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_control( 'cat_col_get_pro', [
            'label'     => __( 'Category Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'cat_col_hov_get_pro', [
            'label'     => __( 'Category Hover Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'cat_bottom_margin_get_pro', [
            'label'     => __( 'Category Bottom Margin', 'music-pack' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_3_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Title Typography', 'music-pack' ),
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_control( 'title_col_get_pro', [
            'label'     => __( 'Title Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'title_col_hov_get_pro', [
            'label'     => __( 'Title Hover Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->end_controls_section();
    }

    /**
     * Render video widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $video_query_args = $this->get_videos_args( $settings );
        $videos_query = new WP_Query($video_query_args);
        if ( !$videos_query->have_posts() ) {
            return;
        }
        $link_to_post = ( 'link_to_post' == $settings['link_to'] ? true : false );
        $container_class = 'swp-videos-widget-container';
        $items_on_row = 2;
        $item_count = 0;
        ?>

		<div class="<?php 
        echo esc_attr( $container_class );
        ?>">
			<div class="videos_container clearfix">
				<?php 
        while ( $videos_query->have_posts() ) {
            $videos_query->the_post();
            $item_count++;
            /*single item display*/
            $has_right_padding = ( 0 == $item_count % $items_on_row ? '' : ' has_right_padding' );
            $bg_img_url = ( has_post_thumbnail() ? get_the_post_thumbnail_url( '', 'full' ) : "" );
            $album_youtube = get_post_meta( get_the_ID(), 'video_youtube_url', true );
            $album_vimeo = get_post_meta( get_the_ID(), 'video_vimeo_url', true );
            $video_source = $vid = "";
            if ( strlen( $album_youtube ) ) {
                $vid = $this->get_video_id_from_url( $album_youtube );
                $video_source = "youtube";
            }
            if ( strlen( $album_vimeo ) ) {
                $vid = $this->get_video_id_from_url( $album_vimeo );
                $video_source = "vimeo";
            }
            $single_css_class = 'single_video_item ' . $has_right_padding;
            if ( !$link_to_post ) {
                $single_css_class .= " mp_play_lightbox_video";
            }
            ?>

					<div class="<?php 
            echo esc_attr( $single_css_class );
            ?>" data-vsource="<?php 
            echo esc_attr( $video_source );
            ?>" data-vid="<?php 
            echo esc_attr( $vid );
            ?>">
						<?php 
            if ( $link_to_post ) {
                ?>
						<a href="<?php 
                the_permalink();
                ?>">
						<?php 
            }
            ?>
							<div class="video_image_container lc_swp_background_image" data-bgimage="<?php 
            echo esc_url( $bg_img_url );
            ?>">
								<i class="fas fa-play lc_icon_play_video" aria-hidden="true"></i>
							</div>
						<?php 
            if ( $link_to_post ) {
                ?>	
						</a>
						<?php 
            }
            ?>

						<div class="single_video_details">
							<div class="video_cat_list">
								<?php 
            if ( has_term( '', "video_category" ) ) {
                the_terms(
                    "",
                    "video_category",
                    '',
                    ' ',
                    ''
                );
            }
            ?>
							</div>

							<?php 
            if ( $link_to_post ) {
                ?>
							<a href="<?php 
                the_permalink();
                ?>">
							<?php 
            }
            ?>
								<h3 class="video_title transition3"> <?php 
            the_title();
            ?> </h3>
							<?php 
            if ( $link_to_post ) {
                ?>	
							</a>
							<?php 
            }
            ?>
						</div>
					</div>
				<?php 
        }
        ?>	
			</div>
		</div>
	<?php 
    }

    private function get_videos_cat_as_array() {
        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 'false',
        );
        $event_categories = get_terms( 'video_category', $cat_args );
        $cat_arr = array(
            0 => esc_html__( "All", 'music-pack' ),
        );
        if ( empty( $event_categories ) ) {
            return $cat_arr;
        }
        foreach ( $event_categories as $cat ) {
            $cat_arr[$cat->term_id] = $cat->name;
        }
        return $cat_arr;
    }

    private function get_videos_args( $settings ) {
        $args = array(
            'numberposts'      => $settings['count'],
            'posts_per_page'   => $settings['count'],
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'js_videos',
            'post_status'      => 'publish',
            'suppress_filters' => false,
        );
        if ( '0' != $settings['video_category'] && strlen( $settings['video_category'] ) ) {
            $args["tax_query"] = array(array(
                'taxonomy' => 'video_category',
                'field'    => 'term_id',
                'terms'    => $settings['video_category'],
            ));
        }
        return $args;
    }

    private function get_video_id_from_url( $short_url ) {
        $elements = explode( "/", $short_url );
        $dim = count( $elements );
        if ( $dim == 0 ) {
            return "";
        } else {
            return $elements[$dim - 1];
        }
    }

}
