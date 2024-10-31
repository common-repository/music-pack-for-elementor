<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor Gallery Post Preview Widget.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Single_Gallery extends Widget_Base {
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
        return 'mp-single-gallery';
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
        return __( 'Gallery Post Promo', 'music-pack' );
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
        return ['music pack', 'gallery', 'image'];
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
            'label' => __( 'Gallery Post Preview', 'music-pack' ),
        ] );
        $this->add_control( 'image', [
            'label'     => __( 'Choose Image', 'music-pack' ),
            'type'      => Controls_Manager::MEDIA,
            'dynamic'   => [
                'active' => true,
            ],
            'default'   => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'selectors' => [
                '{{WRAPPER}} .smc_elementor_gallery_single' => 'background-image: url("{{URL}}");
													background-position: {{bg_pos.VALUE}};
													background-repeat: no-repeat;
													background-size: cover;',
            ],
        ] );
        $this->add_control( 'bg_pos', [
            'label'     => __( 'Background Position', 'artemis-core' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
                'center center' => esc_html__( 'Center Center', 'Background Control', 'music-pack' ),
                'center left'   => esc_html__( 'Center Left', 'Background Control', 'music-pack' ),
                'center right'  => esc_html__( 'Center Right', 'Background Control', 'music-pack' ),
                'top center'    => esc_html__( 'Top Center', 'Background Control', 'music-pack' ),
                'top left'      => esc_html__( 'Top Left', 'Background Control', 'music-pack' ),
                'top right'     => esc_html__( 'Top Right', 'Background Control', 'music-pack' ),
                'bottom center' => esc_html__( 'Bottom Center', 'Background Control', 'music-pack' ),
                'bottom left'   => esc_html__( 'Bottom Left', 'Background Control', 'music-pack' ),
                'bottom right'  => esc_html__( 'Bottom Right', 'Background Control', 'music-pack' ),
            ],
            'default'   => 'center center',
            'selectors' => [
                '{{WRAPPER}} .smc_elementor_gallery_single' => 'background-position: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'title', [
            'label'       => __( 'Title', 'music-pack' ),
            'type'        => Controls_Manager::TEXTAREA,
            'dynamic'     => [
                'active' => true,
            ],
            'placeholder' => __( 'Enter title', 'music-pack' ),
            'default'     => __( 'Toronto Concert', 'music-pack' ),
        ] );
        $this->add_control( 'subtitle', [
            'label'       => __( 'Subtitle', 'music-pack' ),
            'type'        => Controls_Manager::TEXTAREA,
            'dynamic'     => [
                'active' => true,
            ],
            'placeholder' => __( 'Enter subtitle', 'music-pack' ),
            'default'     => __( 'January 2021', 'music-pack' ),
        ] );
        $this->add_control( 'link', [
            'label'     => __( 'Link', 'music-pack' ),
            'type'      => Controls_Manager::URL,
            'dynamic'   => [
                'active' => true,
            ],
            'default'   => [
                'url' => '',
            ],
            'separator' => 'before',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_style', [
            'label' => __( 'Gallery Post Preview', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        /*get pro controls*/
        $this->add_control( 'aspect_ratio_get_pro', [
            'label'   => __( 'Aspect Ratio', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'ar_square_css',
            'options' => [
                'ar_16_9_css'   => __( 'Landscape - 16:9', 'music-pack' ),
                'ar_4_3_css'    => __( 'Landscape - 4:3', 'music-pack' ),
                'ar_square_css' => __( 'Square - 1:1', 'music-pack' ),
                'ar_2_3_css'    => __( 'Portrait - 2:3', 'music-pack' ),
                'ar_10_16_css'  => __( 'Portrait - 10:16', 'music-pack' ),
            ],
            'classes' => 'mpfe-get-pro',
        ] );
        $this->add_responsive_control( 'width', [
            'label'          => __( 'Width', 'music-pack' ),
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
                'unit' => '%',
            ],
            'tablet_default' => [
                'unit' => '%',
            ],
            'mobile_default' => [
                'unit' => '%',
            ],
            'size_units'     => ['%', 'px', 'vw'],
            'range'          => [
                '%'  => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors'      => [
                '{{WRAPPER}} .smc_elementor_gallery_single' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'align', [
            'label'   => __( 'Align', 'music-pack' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
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
            'default' => 'left',
        ] );
        $this->add_control( 'border_radius', [
            'label'      => __( 'Border Radius', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'default'    => [
                'unit' => 'px',
                'size' => 3,
            ],
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min' => 1,
                    'max' => 5,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .smc_elementor_gallery_single, {{WRAPPER}} .gallery_single_image_overlay' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel_1', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'title_color_get_pro', [
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
        $this->add_control( 'separator_panel_2_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'subtitle_color_get_pro', [
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
        ] );
        $this->add_control( 'separator_panel_3_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'label'    => __( 'Overlay Background', 'music-pack' ),
            'name'     => 'background_hover_free',
            'types'    => ['classic'],
            'selector' => '{{WRAPPER}} .smc_elementor_gallery_single:hover .gallery_single_image_overlay',
        ] );
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
        $settings = $this->get_settings_for_display();
        $has_url = ( strlen( $settings['link']['url'] ) ? true : false );
        $container_css = 'smc_elementor_gallery_single align_' . esc_attr( $settings['align'] );
        $aspect_ratio_val = "ar_square_css";
        ?>
		<div class="<?php 
        echo esc_attr( $container_css );
        ?>">
			<?php 
        if ( $has_url ) {
            ?>
			<a href="<?php 
            echo esc_url( $settings['link']['url'] );
            ?>">
			<?php 
        }
        ?>
				<div class="smc_elt_gallery_img_container <?php 
        echo esc_attr( $aspect_ratio_val );
        ?>"></div>	
				<div class="gallery_single_image_overlay transition4"></div>
				<div class="smc_elt_gallery_single_details transition4">
					<h3 class="smc_elt_gallery_title"> <?php 
        echo esc_html( $settings['title'] );
        ?> </h3>
					<h4 class="smc_elt_gallery_subtitle"> <?php 
        echo esc_html( $settings['subtitle'] );
        ?> </h4>
				</div>
			<?php 
        if ( $has_url ) {
            ?>
			</a>
			<?php 
        }
        ?>
		</div>
		<?php 
    }

}
