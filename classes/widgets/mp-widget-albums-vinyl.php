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
 * Elementor Music Albums Vinyl.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Albums_Vinyl extends Widget_Base {
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
        return 'mp-music-albums-vinyl';
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
        return __( 'Music Albums (Vinyl)', 'music-pack' );
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
            'discography',
            'vinyl'
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
            'label' => __( 'Music Albums Vinyl', 'music-pack' ),
        ] );
        $this->add_control( 'albums_no', [
            'label'   => __( 'Albums to show', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 100,
            'step'    => 1,
            'default' => 3,
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
        $this->add_control( 'show_cat_or_artist', [
            'label'   => esc_html__( 'Subtitle', 'shop-maker' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'album_cat',
            'options' => [
                'album_cat' => esc_html__( 'Default - Album Category', 'shop-maker' ),
                'artist'    => esc_html__( 'Artist', 'shop-maker' ),
            ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Music Albums - Vinyl', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
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
                '{{WRAPPER}} .album_details' => 'text-align: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'separator_panel_0', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        /*get pro controls [[[*/
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
        $this->add_control( 'subtitle_col_get_pro', [
            'label'     => __( 'Subtitle Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Subtitle Typography', 'music-pack' ),
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
        /*get pro controls ]]]*/
        $this->add_responsive_control( 'rows_gap', [
            'label'      => __( 'Rows Gap', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                '%' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 80,
            ],
            'selectors'  => [
                '{{WRAPPER}} .single_album_item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
        $artist_subtitle = ( "artist" == $settings['show_cat_or_artist'] ? true : false );
        $args = MPACK_Utils::get_albums_args( $settings['albums_no'], $settings['album_cat'], $settings['artist_id'] );
        $lat_albums_vinyl_query = new WP_Query();
        $lat_albums_vinyl_query->query( $args );
        if ( !$lat_albums_vinyl_query->have_posts() ) {
            return;
        }
        $container_class = 'slide-music-albums-vinyl-container discography_template_container ';
        $items_on_row = 3;
        $vinyl_src = MPACK_DIR_URL . "/img/slide_record.png";
        $item_count = 0;
        ?>

		<div class="<?php 
        echo esc_attr( $container_class );
        ?>">
			<div class="albums_container swp-elt-widget clearfix">
				<?php 
        while ( $lat_albums_vinyl_query->have_posts() ) {
            $lat_albums_vinyl_query->the_post();
            $item_count++;
            $has_right_padding = ( 0 == $item_count % $items_on_row ? '' : ' has_right_padding' );
            $bg_img_url = ( has_post_thumbnail() ? get_the_post_thumbnail_url( '', 'full' ) : "" );
            $custom_css_class = ' albums_' . $items_on_row . "_on_row";
            ?>

					<div class="single_album_item swp_vc_element <?php 
            echo esc_attr( $has_right_padding ) . esc_attr( $custom_css_class );
            ?>">
						<a href="<?php 
            the_permalink();
            ?>" class="mp-vinyl-link-to-album">
							<div class="image_vinyl_container">
								<div class="album_image_container lc_swp_background_image" data-bgimage="<?php 
            echo esc_url( $bg_img_url );
            ?>">
								</div>
								<div class="slide_vinyl transition4">
									<img alt="<?php 
            the_title();
            ?>" src="<?php 
            echo esc_url( $vinyl_src );
            ?>">
									<img src="<?php 
            echo esc_url( $bg_img_url );
            ?>" class="image_on_vinyl">
								</div>
							</div>
							
							<div class="album_details">
								<h3 class="album_title_vinyl album_heading transition4"> <?php 
            the_title();
            ?> </h3>
								<div class="album_cat_list">
									<?php 
            if ( $artist_subtitle ) {
                $album_artist = get_post_meta( get_the_ID(), 'album_artist', true );
                echo esc_html( $album_artist );
            } else {
                if ( has_term( '', "album_category" ) ) {
                    the_terms(
                        "",
                        "album_category",
                        '',
                        ' ',
                        ''
                    );
                }
            }
            ?>
								</div>			
							</div>
						</a>
					</div>
				<?php 
        }
        ?>
			</div>
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
