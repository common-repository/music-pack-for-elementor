<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor MPack Artist Creative Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Artist_Creative extends Widget_Base {
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
        return 'mp-artist-creative';
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
        return __( 'Artist Creative', 'music-pack' );
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
            'music-pack',
            'music',
            'single artist',
            'band member',
            'artist creative'
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
            'label' => __( 'Artist Creative', 'music-pack' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'artist_name', [
            'label'       => __( 'Artist Name', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Jordan Paul', 'music-pack' ),
            'placeholder' => __( 'Enter artist name', 'music-pack' ),
        ] );
        $this->add_control( 'artist_position', [
            'label'       => __( 'Artist Position', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Lead Guitar', 'music-pack' ),
            'placeholder' => __( 'Enter artist position', 'music-pack' ),
        ] );
        $this->add_control( 'hr_1', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ] );
        $this->add_control( 'main_image', [
            'label'       => __( 'Main Artist Image', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'default'     => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'dynamic'     => [
                'active' => true,
            ],
            'show_label'  => true,
            'description' => __( 'Upload or select the main image for the artist.', 'music-pack' ),
        ] );
        $this->add_control( 'background_position', [
            'label'     => __( 'Background Position', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'center center',
            'options'   => [
                'left top'      => __( 'Left Top', 'music-pack' ),
                'left center'   => __( 'Left Center', 'music-pack' ),
                'left bottom'   => __( 'Left Bottom', 'music-pack' ),
                'center top'    => __( 'Center Top', 'music-pack' ),
                'center center' => __( 'Center Center', 'music-pack' ),
                'center bottom' => __( 'Center Bottom', 'music-pack' ),
                'right top'     => __( 'Right Top', 'music-pack' ),
                'right center'  => __( 'Right Center', 'music-pack' ),
                'right bottom'  => __( 'Right Bottom', 'music-pack' ),
            ],
            'selectors' => [
                '{{WRAPPER}} .artist_img_container' => 'background-position: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'hr_2', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ] );
        $this->add_control( 'second_image', [
            'label'       => __( 'Second Artist Image', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'default'     => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'dynamic'     => [
                'active' => true,
            ],
            'show_label'  => true,
            'description' => __( 'Upload or select the second image for the artist.', 'music-pack' ),
        ] );
        $this->add_control( 'hr_3', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ] );
        $this->add_control( 'artist_page_url', [
            'label'         => __( 'Artist Page URL', 'music-pack' ),
            'type'          => \Elementor\Controls_Manager::URL,
            'placeholder'   => __( 'https://your-link.com', 'music-pack' ),
            'show_external' => true,
            'default'       => [
                'url'         => '',
                'is_external' => true,
                'nofollow'    => true,
            ],
        ] );
        $this->add_control( 'hr_4', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ] );
        // Social Networks Repeater Control
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'social_network_url', [
            'label'         => __( 'Social Network URL', 'music-pack' ),
            'type'          => \Elementor\Controls_Manager::URL,
            'placeholder'   => __( 'https://your-link.com', 'music-pack' ),
            'show_external' => true,
            'default'       => [
                'url'         => '',
                'is_external' => true,
                'nofollow'    => true,
            ],
        ] );
        $repeater->add_control( 'social_network_icon', [
            'label'            => __( 'Social Network Icon', 'music-pack' ),
            'type'             => \Elementor\Controls_Manager::ICONS,
            'fa4compatibility' => 'icon',
            'default'          => [
                'value'   => 'fa fa-facebook',
                'library' => 'fa-solid',
            ],
        ] );
        $this->add_control( 'social_links', [
            'label'       => __( 'Social Networks', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ social_network_url.url }}}',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Artist Creative', 'music-pack' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'aspect_ratio', [
            'label'   => esc_html__( 'Aspect Ratio', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'default_ar',
            'options' => [
                'default_ar'   => esc_html__( 'Default - Portrait', 'music-pack' ),
                'at_ar_square' => esc_html__( 'Square', 'music-pack' ),
                'at_9_16'      => esc_html__( 'Portrait 9:16', 'music-pack' ),
                'at_3_4'       => esc_html__( 'Portrait 3:4', 'music-pack' ),
                'at_2_3'       => esc_html__( 'Portrait 2:3', 'music-pack' ),
            ],
        ] );
        $this->add_control( 'overlay_color_pro', [
            'label'     => __( 'Overlay Color', 'slide-music-core' ),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => [
                'type'  => Color::get_type(),
                'value' => Color::COLOR_1,
            ],
            'default'   => '#151515',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'add_img_border_radius', [
            'label'      => __( 'Additional Image Border Radius', 'slide-music-core' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'unit'   => '%',
                'top'    => '50',
                'right'  => '50',
                'bottom' => '50',
                'left'   => '50',
            ],
            'selectors'  => [
                '{{WRAPPER}} img.artist_add_img_inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Title Typography', 'music-pack' ),
            'name'     => 'title_typo_get_pro',
            'scheme'   => Typography::TYPOGRAPHY_1,
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Subtitle Typography', 'music-pack' ),
            'name'     => 'subtitle_typo_get_pro',
            'scheme'   => Typography::TYPOGRAPHY_1,
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_responsive_control( 'icon_size', [
            'label'      => __( 'Icon Size', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 17,
            ],
            'selectors'  => [
                '{{WRAPPER}} .artist_social_profile' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'separator'  => 'before',
        ] );
        $this->start_controls_tabs( 'elt_style_tabs' );
        $this->start_controls_tab( 'elt_style_normal_tab', [
            'label' => __( 'Normal', 'music-pack' ),
        ] );
        $this->add_control( 'title_col_get_pro', [
            'label'     => __( 'Title Color', 'music-player-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => [
                'type'  => Color::get_type(),
                'value' => Color::COLOR_1,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'subtitle_col_get_pro', [
            'label'     => __( 'Subtitle Color', 'music-player-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => [
                'type'  => Color::get_type(),
                'value' => Color::COLOR_1,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icon_col', [
            'label'     => __( 'Icon Color', 'music-player-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => [
                'type'  => Color::get_type(),
                'value' => Color::COLOR_1,
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .artist_social_profile i' => 'color: {{VALUE}};',
            ],
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'elt_style_hover_tab', [
            'label' => __( 'Hover', 'music-pack' ),
        ] );
        $this->add_control( 'title_hovcol_get_pro', [
            'label'     => __( 'Title Color', 'music-player-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => [
                'type'  => Color::get_type(),
                'value' => Color::COLOR_1,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'subtitle_hovcol_get_pro', [
            'label'     => __( 'Subtitle Color', 'music-player-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => [
                'type'  => Color::get_type(),
                'value' => Color::COLOR_1,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icon_hovcol', [
            'label'     => __( 'Icon Color', 'music-player-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => [
                'type'  => Color::get_type(),
                'value' => Color::COLOR_1,
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .swp_single_artist:hover .artist_social_profile i' => 'color: {{VALUE}};',
            ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
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
        // Extract data into separate variables
        $artist_name = ( !empty( $settings['artist_name'] ) ? esc_html( $settings['artist_name'] ) : '' );
        $artist_position = ( !empty( $settings['artist_position'] ) ? esc_html( $settings['artist_position'] ) : '' );
        $main_image_url = ( !empty( $settings['main_image']['url'] ) ? esc_url( $settings['main_image']['url'] ) : \Elementor\Utils::get_placeholder_image_src() );
        $second_image_url = ( !empty( $settings['second_image']['url'] ) ? esc_url( $settings['second_image']['url'] ) : \Elementor\Utils::get_placeholder_image_src() );
        $container_class = "swp_single_artist element_width_full";
        $artist_link_target = ( $settings['artist_page_url']['is_external'] ? "_blank" : "_self" );
        $aspect_ratio = $settings['aspect_ratio'];
        $overlay_color = "#151515";
        ?>
		<div class="<?php 
        echo esc_attr( $container_class );
        ?>">
			<a href="<?php 
        echo esc_url( $settings['artist_page_url']['url'] );
        ?>" target="<?php 
        echo esc_attr( $artist_link_target );
        ?>">
				<div class="artist_img_container lc_swp_background_image <?php 
        echo esc_attr( $aspect_ratio );
        ?>" data-bgimage="<?php 
        echo esc_attr( esc_html( $main_image_url ) );
        ?>">
				</div>
				<div class="artist_overlay transition3 lc_swp_bg_color" data-color="<?php 
        echo esc_attr( $overlay_color );
        ?>"></div>
				<?php 
        if ( !empty( $second_image_url ) ) {
            ?>
					<div class="artist_add_img transition4">
						<img class="artist_add_img_inner" src="<?php 
            echo esc_attr( esc_html( $second_image_url ) );
            ?>">
					</div>
				<?php 
        }
        ?>
				<div class="artist_details transition4">
					<div class="artist_name transition4"> <?php 
        echo esc_html( $artist_name );
        ?> </div>
					<?php 
        if ( !empty( $artist_position ) ) {
            ?>
						<div class="artist_nickname"> <?php 
            echo esc_html( $artist_position );
            ?> </div>
					<?php 
        }
        ?>

					<?php 
        if ( $settings['social_links'] ) {
            ?>
					<div class="artist_social">
						<?php 
            $this->render_social_links( $settings['social_links'] );
            ?>
					</div>
					<?php 
        }
        ?>
				</div>	
			</a>
		</div>
		<?php 
    }

    private function render_social_links( $social_links ) {
        foreach ( $social_links as $item ) {
            $social_link_target = ( $item['social_network_url']['is_external'] ? "_blank" : "_self" );
            ?>
			<div class="artist_social_profile">
				<a href="<?php 
            echo esc_url( $item['social_network_url']['url'] );
            ?>" target="<?php 
            echo esc_attr( $social_link_target );
            ?>">
					<?php 
            \Elementor\Icons_Manager::render_icon( $item['social_network_icon'], [
                'aria-hidden' => 'true',
            ] );
            ?>
				</a>
			</div>
			<?php 
        }
    }

}
