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
 * Elementor Slide Gallery.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Gallery extends Widget_Base {
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
        return 'mp-gallery';
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
        return __( 'Image Gallery', 'slide-music-core' );
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
        $this->start_controls_section( 'section_gallery', [
            'label' => __( 'Gallery', 'slide-music-core' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'separator_panel1', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'gap_width_get_pro', [
            'label'   => __( 'Gap Width', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 30,
            'step'    => 1,
            'default' => 0,
            'classes' => 'mpfe-get-pro',
        ] );
        $this->add_control( 'items_on_row', [
            'label'   => __( 'Items On Row', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                '3' => __( '3', 'music-pack' ),
                '4' => __( '4', 'music-pack' ),
            ],
        ] );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'image', [
            'label'   => __( 'Image', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ] );
        $repeater->add_control( 'aspect_ratio_get_pro', [
            'label'   => __( 'Aspect Ratio', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'square',
            'options' => [
                'square'    => __( 'square', 'music-pack' ),
                'portrait'  => __( 'portrait', 'music-pack' ),
                'landscape' => __( 'landscape', 'music-pack' ),
            ],
            'classes' => 'mpfe-get-pro',
        ] );
        $repeater->add_control( 'caption', [
            'label'   => __( 'Caption', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '',
        ] );
        $this->add_control( 'gallery', [
            'label'       => __( 'Reviews', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [[
                'image'      => \Elementor\Utils::get_placeholder_image_src(),
                'img_height' => 'square',
                'caption'    => 'Image Caption',
            ]],
            'title_field' => '{{{ caption }}}',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Slide Gallery', 'slide-music-core' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'caption_color', [
            'label'     => __( 'Caption Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .swp_img_caption' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Caption Typography', 'music-pack' ),
            'name'     => 'caption_typo',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '{{WRAPPER}} .swp_img_caption',
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
        if ( empty( $settings['gallery'] ) ) {
            return;
        }
        $gap_width = 0;
        ?>
		<div class="lc_masonry_container gallery_single_img_container mp_widget" data-gapwidth="<?php 
        echo esc_attr( $gap_width );
        ?>" data-bricksonrow="<?php 
        echo esc_attr( $settings['items_on_row'] );
        ?>">
			<div class="brick-size"></div>

			<?php 
        foreach ( $settings['gallery'] as $image ) {
            ?>
				<?php 
            $aspect_ratio = "square";
            $css_class = "brick_" . $aspect_ratio;
            ?>
				<div class="lc_masonry_brick lc_single_gallery_brick <?php 
            echo esc_attr( $css_class );
            ?>">
						<div class="gallery_brick_overlay"></div>
						<a href="<?php 
            echo esc_url( $image['image']['url'] );
            ?>" data-lightbox="photo_album">

							<?php 
            /* echo wp_get_attachment_image($image['id'], 'medium_large', false, ['class' => 'transition4']); */
            ?>
							<img src="<?php 
            echo esc_url( wp_get_attachment_image_url( $image['image']['id'], 'large' ) );
            ?>" class="transition4 mp_gallery_img">
							
							<div class="swp_img_caption">
								<?php 
            echo esc_html( $image['caption'] );
            ?>
							</div>
						</a>
				</div>
			<?php 
        }
        ?>
		</div>
		<?php 
    }

}
