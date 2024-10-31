<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor Artists Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Artists extends Widget_Base {
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
        return 'mp-artists';
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
        return __( 'Artists', 'music-pack' );
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
        return ['music pack', 'artist', 'member'];
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
            'label' => __( 'Artists', 'music-pack' ),
        ] );
        $this->add_control( 'artists_no', [
            'label'   => __( 'Artists No', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 100,
            'step'    => 1,
            'default' => 4,
        ] );
        $this->add_control( 'artists_cat', [
            'label'   => __( 'Artists Category:', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '0',
            'options' => $this->get_artist_cat_as_array(),
        ] );
        $this->add_control( 'link_to_single', [
            'label'        => __( 'Link to Single Artist', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'music-pack' ),
            'label_off'    => __( 'No', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_style', [
            'label' => __( 'Artists', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'items_on_row', [
            'label'        => __( 'Items On Row', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::NUMBER,
            'min'          => 1,
            'max'          => 5,
            'step'         => 1,
            'default'      => 4,
            'prefix_class' => 'artists-on-row-%s',
            'selectors'    => [
                '{{WRAPPER}} .single_artist_item' => '--gaps: calc({{VALUE}} - 1); width:  calc((100% - var(--gaps) *  {{gap.SIZE}}{{gap.UNIT}})/{{VALUE}});',
            ],
        ] );
        $this->add_control( 'gap', [
            'label'      => __( 'Gap', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 50,
                    'step' => 1,
                ],
                '%'  => [
                    'min'  => 0,
                    'max'  => 5,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => '%',
                'size' => 2,
            ],
            'selectors'  => [
                '{{WRAPPER}} .single_artist_item' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
        ] );
        /*get pro controls [[[*/
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
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_2_get_pro', [
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
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Subtitle Typography', 'music-pack' ),
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        /*get pro controls ]]]*/
        $this->add_control( 'separator_panel_3', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'icons_col', [
            'label'     => __( 'Icons Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .artist_social_profile a' => 'color: {{VALUE}};',
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
        $args = MPACK_Utils::get_artists_args( $settings['artists_no'], $settings['artists_cat'] );
        $artists_elt_query = new WP_Query();
        $artists_elt_query->query( $args );
        /*initial layout settings*/
        $items_on_row = $settings['items_on_row'];
        $item_count = 0;
        $link_to_single = ( "yes" == $settings['link_to_single'] ? true : false );
        if ( !$artists_elt_query->have_posts() ) {
            return;
        }
        ?>

		<div class="artists_container swp-elt-artists-container clearfix">
			<?php 
        while ( $artists_elt_query->have_posts() ) {
            $artists_elt_query->the_post();
            $item_count++;
            $artist_id = get_the_ID();
            $bg_img_url = "";
            if ( has_post_thumbnail() ) {
                $bg_img_url = get_the_post_thumbnail_url( '', 'full' );
            }
            $custom_css_class = ' artists_' . $items_on_row . "_on_row";
            $artist_nickname = esc_html( get_post_meta( $artist_id, 'artist_nickname', true ) );
            /*social options*/
            $available_profiles = array(
                'facebook-f' => 'artist_facebook',
                'twitter'    => 'artist_twitter',
                'instagram'  => 'artist_instagram',
                'soundcloud' => 'artist_soundcloud',
                'youtube'    => 'artist_youtube',
                'spotify'    => 'artist_spotify',
                'apple'      => 'artist_apple',
                'tiktok'     => 'artist_tiktok',
            );
            $artist_profiles = array();
            foreach ( $available_profiles as $key => $profile ) {
                $profile_url = esc_url( get_post_meta( $artist_id, $profile, true ) );
                if ( !empty( $profile_url ) ) {
                    $single_profile = array();
                    $single_profile['url'] = $profile_url;
                    $single_profile['icon'] = $key;
                    $artist_profiles[] = $single_profile;
                }
            }
            $term_list = strip_tags( get_the_term_list(
                "",
                "artist_category",
                '',
                ' ',
                ''
            ) );
            $overlay_classes = ( $link_to_single ? "album_overlay artist_overlay lc_swp_overlay transition3 lc_js_link" : "album_overlay artist_overlay lc_swp_overlay transition3" );
            ?>

				<div class="single_artist_item swp-elt-artists <?php 
            echo esc_attr( $custom_css_class );
            ?>" data-category="<?php 
            echo esc_attr( $term_list );
            ?>">
						<div class="artist_img_container swp-elt-widget ar_square_css lc_swp_background_image" data-bgimage="<?php 
            echo esc_url( $bg_img_url );
            ?>">
							<div class="<?php 
            echo esc_attr( $overlay_classes );
            ?>" data-href="<?php 
            the_permalink();
            ?>" data-target="_self"></div>
							<div class="artist_item_socials">
								<?php 
            foreach ( $artist_profiles as $social_profile ) {
                ?>
									<div class="artist_social_profile">
										<a href="<?php 
                echo esc_url( $social_profile['url'] );
                ?>" target="_blank" class="artist_social_link">
											<i class="fab fa-<?php 
                echo esc_attr( $social_profile['icon'] );
                ?>"></i>
										</a>
									</div>
								<?php 
            }
            ?>		
							</div>
						</div>
						<?php 
            if ( $link_to_single ) {
                ?>
						<a href="<?php 
                the_permalink();
                ?>">
						<?php 
            }
            ?>	
							<h3 class="artist_title album_heading transition4"> <?php 
            the_title();
            ?> </h3>
						<?php 
            if ( $link_to_single ) {
                ?>
						</a>
						<?php 
            }
            ?>
						<div class="artist_nickname"> <?php 
            echo esc_html( $artist_nickname );
            ?> </div>
				</div>					

			<?php 
        }
        wp_reset_postdata();
        ?>
		</div>

	<?php 
    }

    /**
     * Get js_artist categories as array 'id' => 'cat_name'
     *
     * @access private
     */
    private function get_artist_cat_as_array() {
        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 'false',
        );
        $artist_categories = get_terms( 'artist_category', $cat_args );
        /*default*/
        $cat_arr = array(
            0 => esc_html__( "All", 'music-pack' ),
        );
        if ( empty( $artist_categories ) ) {
            return $cat_arr;
        }
        foreach ( $artist_categories as $cat ) {
            $cat_arr[$cat->term_id] = $cat->name;
        }
        return $cat_arr;
    }

}
