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
 * Elementor Music PackSingle Music Album Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Single_Music_Album extends Widget_Base {
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
        return 'single-music-album';
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
        return __( 'Music Album Promo', 'music-pack' );
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
        return ['music pack', 'album', 'vinyl'];
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
        /*GENERAL SECTION*/
        $this->start_controls_section( 'section_general', [
            'label' => __( 'Single Music Album', 'music-pack' ),
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
                '{{WRAPPER}} .album_image_container' => 'background-image: url("{{URL}}");
													background-position: center center;
													background-repeat: no-repeat;
													background-size: cover;',
            ],
        ] );
        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'      => 'image',
            'default'   => 'large',
            'separator' => 'none',
        ] );
        $this->add_control( 'text', [
            'label'       => __( 'Album Title', 'music-pack' ),
            'type'        => Controls_Manager::TEXTAREA,
            'dynamic'     => [
                'active' => true,
            ],
            'placeholder' => __( 'Enter text content', 'music-pack' ),
            'default'     => __( 'Say You Do', 'music-pack' ),
        ] );
        $this->add_control( 'text2', [
            'label'       => __( 'Album Subtitle', 'music-pack' ),
            'type'        => Controls_Manager::TEXTAREA,
            'dynamic'     => [
                'active' => true,
            ],
            'placeholder' => __( 'Enter text content', 'music-pack' ),
            'default'     => __( 'Romantic', 'music-pack' ),
        ] );
        $this->add_control( 'link', [
            'label'     => __( 'Link To Album', 'music-pack' ),
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
            'label' => __( 'Single Music Album', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
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
                '{{WRAPPER}} .smc_elementor_album' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'album_align', [
            'label'   => __( 'Album Align', 'music-pack' ),
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
                '{{WRAPPER}} .album_image_container, {{WRAPPER}} .album_image_overlay' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel_style', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'hover_effect_type_get_pro', [
            'label'   => __( 'Hover Effect', 'music-pack' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'vinyl',
            'options' => [
                'vinyl'   => __( 'Vinyl Style', 'music-pack' ),
                'overlay' => __( 'Overlay', 'music-pack' ),
            ],
            'classes' => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_style_1', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Album Title Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_control( 'album_title_color', [
            'label'     => __( 'Album Title Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .album_title' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'album_subtitle_color', [
            'label'     => __( 'Album Subtitle Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .album_subtitle' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'     => __( 'Album Subtitle Typography', 'music-pack' ),
            'name'      => 'typography2_get_pro',
            'global'    => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector'  => '',
            'classes'   => 'mpfe-get-pro',
            'separator' => 'before',
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
        $text = $settings['text'];
        $text2 = $settings['text2'];
        $has_url = ( strlen( $settings['link']['url'] ) ? true : false );
        $image_src = $settings['image']['url'];
        $elt_align = $settings['album_align'];
        $hover_effect_val = 'overlay';
        ?>
		<div class="smc_elementor_album <?php 
        echo "align_" . esc_attr( $elt_align );
        ?>" >
			<?php 
        if ( $has_url ) {
            ?>
			<a href="<?php 
            echo esc_url( $settings['link']['url'] );
            ?>">
			<?php 
        }
        ?>	
				<div class="image_vinyl_container">
					<div class="album_image_container smc_ar_11"></div>

					<?php 
        if ( "vinyl" == $hover_effect_val ) {
            ?>
					<div class="slide_vinyl transition4">
						<?php 
            $vinyl_src = MPACK_DIR_URL . "/img/slide_record.png";
            ?>
						<img alt="<?php 
            echo esc_attr( $text );
            ?>" src="<?php 
            echo esc_url( $vinyl_src );
            ?>">
						<img src="<?php 
            echo esc_url( $image_src );
            ?>" class="image_on_vinyl">
					</div>
					<?php 
        }
        ?>
				</div>

				<?php 
        if ( "overlay" == $hover_effect_val ) {
            ?>
				<div class="album_image_overlay transition4"></div>
				<div class="smc_elementor_album_details transition4">
					<h3 class="album_title album_heading mo_elt_album_text"> <?php 
            echo esc_html( $text );
            ?> </h3>
					<h4 class="album_subtitle album_subheading mo_elt_album_text"> <?php 
            echo esc_html( $text2 );
            ?> </h4>
				</div>
				<?php 
        }
        ?>
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
