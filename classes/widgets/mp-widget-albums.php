<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor Music Albums Widget.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Albums extends Widget_Base {
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
        return 'mp-music-albums';
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
        return __( 'Music Albums', 'music-pack' );
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

    public function get_script_depends() {
        return ['mpack-front'];
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
        return [
            'music pack',
            'music',
            'albums',
            'discography'
        ];
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
        $this->start_controls_section( 'section_general', [
            'label' => __( 'Music Albums Widget', 'music-pack' ),
        ] );
        $this->add_control( 'albums_no', [
            'label'   => __( 'Albums to show', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 100,
            'step'    => 1,
            'default' => 5,
        ] );
        $this->add_control( 'album_cat', [
            'label'   => __( 'Albums Category:', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '0',
            'options' => $this->get_album_cat_as_array(),
        ] );
        $this->add_control( 'artist_id', [
            'label'   => __( 'Albums By Artist:', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '0',
            'options' => $this->get_artist_as_array(),
        ] );
        /*get pro controls*/
        $this->add_control( 'emphasize_first_get_pro', [
            'label'        => __( 'Emphasize First', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'music-pack' ),
            'label_off'    => __( 'No', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'classes'      => 'mpfe-get-pro',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_typo', [
            'label' => __( 'Text', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'date_col_get_pro', [
            'label'     => __( 'Date Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Date Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_1_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
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
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Title Typography', 'music-pack' ),
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_2_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'link_col_get_pro', [
            'label'     => __( 'Link Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Link Typography', 'music-pack' ),
            'name'     => 'typography3_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        /*get pro controls ]]]*/
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_overlay', [
            'label' => __( 'Overlay', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'overlay_opacity', [
            'label'      => __( 'Opacity', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range'      => [
                '%' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => '%',
                'size' => 90,
            ],
            'selectors'  => [
                '{{WRAPPER}} .latest_albums_single:hover .latest_albums_overlay' => 'opacity: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), [
            'name'           => 'overlay_background_free',
            'label'          => __( 'Overlay Background', 'music-pack' ),
            'types'          => ['classic'],
            'fields_options' => [
                'background' => [
                    'default' => 'classic',
                ],
                'color'      => [
                    'default' => '#fb3a64',
                ],
            ],
            'selector'       => '{{WRAPPER}} .latest_albums_overlay',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_shape', [
            'label' => __( 'Shape', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'border_radius', [
            'label'      => __( 'Border Radius', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
                '%'  => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 5,
            ],
            'selectors'  => [
                '{{WRAPPER}} .latest_albums_single, {{WRAPPER}} .latest_albums_overlay' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
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
        $settings = $this->get_settings_for_display();
        $args = MPACK_Utils::get_albums_args( $settings['albums_no'], $settings['album_cat'], $settings['artist_id'] );
        $lat_albums_query = new WP_Query();
        $lat_albums_query->query( $args );
        if ( !$lat_albums_query->have_posts() ) {
            return;
        }
        $emphasize_first_opts = "no";
        $emphasize_first = ( "yes" == $emphasize_first_opts ? true : false );
        $container_class = 'slide-music-albums-container clearfix';
        if ( $emphasize_first ) {
            $container_class .= " emphasize_first_album";
        }
        $items_on_row = 4;
        $item_count = 0;
        ?>

		<div class="<?php 
        echo esc_attr( $container_class );
        ?>">
			<?php 
        while ( $lat_albums_query->have_posts() ) {
            $lat_albums_query->the_post();
            $item_count++;
            $item_class = "latest_albums_single swp_custom_ar ar_square lc_swp_background_image";
            if ( $emphasize_first && $item_count <= 5 ) {
                $has_right_padding = ( in_array( $item_count, array(3, 5) ) ? '' : ' has_right_padding' );
            } else {
                $has_right_padding = ( 0 == $item_count % $items_on_row ? '' : ' has_right_padding' );
            }
            if ( strlen( $has_right_padding ) ) {
                $item_class .= " has_right_padding";
            }
            $bg_img_url = "";
            if ( has_post_thumbnail() ) {
                $bg_img_url = get_the_post_thumbnail_url( '', 'full' );
            }
            $album_buy_message1 = esc_html( get_post_meta( get_the_ID(), 'album_buy_message1', true ) );
            $album_buy_link1 = esc_html( get_post_meta( get_the_ID(), 'album_buy_link1', true ) );
            $album_release_date = esc_html( get_post_meta( get_the_ID(), 'album_release_date', true ) );
            @($album_release_date = str_replace( "/", "-", $album_release_date ));
            try {
                @($output_date = new DateTime($album_release_date));
            } catch ( Exception $e ) {
                @($output_date = new DateTime('NOW'));
            }
            $album_title = get_the_title();
            ?>

				<div class="<?php 
            echo esc_attr( $item_class );
            ?>" data-bgimage="<?php 
            echo esc_url( $bg_img_url );
            ?>">
					<div class="latest_albums_overlay transition3"></div>

					<div class="latest_albums_scd_content transition3">
						<div class="album_scd_date">
							<?php 
            echo date_i18n( "M Y", $output_date->format( 'U' ) );
            ?>
						</div>
						<h3 class="album_scd_title">
							<a href="<?php 
            the_permalink();
            ?>" class="album_scd_link">
								<?php 
            echo esc_html( $album_title );
            ?>
							</a>	
						</h3>
						<div class="album_scd_buy_container">
							<a href="<?php 
            echo esc_url( $album_buy_link1 );
            ?>" target="_blank" class="album_scd_link album_elt_buy">
								<?php 
            echo esc_html( $album_buy_message1 );
            ?>
							</a>
						</div>						
					</div>
				</div>

			<?php 
        }
        ?>
		</div>
		<?php 
    }

    private function get_album_cat_as_array() {
        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 'false',
        );
        $album_categories = get_terms( 'album_category', $cat_args );
        /*default*/
        $cat_arr = array(
            0 => esc_html__( "All", 'music-pack' ),
        );
        if ( empty( $album_categories ) ) {
            return $cat_arr;
        }
        foreach ( $album_categories as $cat ) {
            $cat_arr[$cat->term_id] = $cat->name;
        }
        return $cat_arr;
    }

    private function get_artist_as_array() {
        $args = array(
            'numberposts'      => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => 'js_artist',
            'post_status'      => 'publish',
            'suppress_filters' => false,
        );
        $result_posts = get_posts( $args );
        $artist_arr = array(
            0 => esc_html__( "All", 'music-pack' ),
        );
        foreach ( $result_posts as $single_post ) {
            $artist_arr[$single_post->ID] = $single_post->post_title;
        }
        return $artist_arr;
    }

}
