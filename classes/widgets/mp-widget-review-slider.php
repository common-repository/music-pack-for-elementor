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
 * Elementor Review Slider Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Review_Slider extends Widget_Base {
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
        return 'mp-review-slider';
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
        return __( 'Review Slider', 'music-pack' );
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
            'review',
            'quote',
            'testimonial'
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
            'label' => __( 'Slide Review Slider', 'music-pack' ),
        ] );
        $this->add_control( 'slide_speed', [
            'label'      => __( 'Slide Speed', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['ms'],
            'range'      => [
                'ms' => [
                    'min'  => 400,
                    'max'  => 1000,
                    'step' => 100,
                ],
            ],
            'default'    => [
                'unit' => 'ms',
                'size' => 400,
            ],
        ] );
        $this->add_control( 'slide_delay', [
            'label'      => __( 'Slide Delay', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['ms'],
            'range'      => [
                'ms' => [
                    'min'  => 1000,
                    'max'  => 10000,
                    'step' => 1000,
                ],
            ],
            'default'    => [
                'unit' => 'ms',
                'size' => 4000,
            ],
        ] );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'reviewer_name', [
            'label'   => __( 'Martin Stanley', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Someone Like You', 'music-pack' ),
        ] );
        $repeater->add_control( 'reviewer_position', [
            'label'   => __( 'Position', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Manager', 'music-pack' ),
        ] );
        $repeater->add_control( 'reviewer_image', [
            'label'   => __( 'Reviewer Image', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ] );
        $repeater->add_control( 'review_content', [
            'label'       => __( 'Content', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::WYSIWYG,
            'default'     => __( 'We just want to say thank you...', 'music-pack' ),
            'placeholder' => __( 'Review content here', 'music-pack' ),
        ] );
        $this->add_control( 'review_list', [
            'label'       => __( 'Reviews', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [[
                'reviewer_name'     => 'Martin Stanley',
                'reviewer_position' => 'Manager',
                'review_content'    => 'We just want to say thank you...',
            ]],
            'title_field' => '{{{ reviewer_name }}}',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_style', [
            'label' => __( 'Slide Review Slider', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'quote_color', [
            'label'     => __( 'Quote Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} i.swp_before_reviews' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_responsive_control( 'quote_size', [
            'label'      => __( 'Quote Size', 'music-pack' ),
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
                'size' => 55,
            ],
            'selectors'  => [
                '{{WRAPPER}} i.swp_before_reviews' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'quote_opacity', [
            'label'      => __( 'Quote Opacity', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 0.5,
                ],
            ],
            'default'    => [
                'unit' => '%',
                'size' => 35,
            ],
            'selectors'  => [
                '{{WRAPPER}} i.swp_before_reviews' => 'opacity: {{SIZE}}{{UNIT}};',
            ],
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'separator_panel_1_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'content_color_get_pro', [
            'label'     => __( 'Content Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Content Typography', 'music-pack' ),
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
        $this->add_control( 'name_color_get_pro', [
            'label'     => __( 'Name Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Name Typography', 'music-pack' ),
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_3_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'position_color_get_pro', [
            'label'     => __( 'Position Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        /*get pro controls ]]]*/
        $this->add_control( 'separator_panel_4', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_responsive_control( 'image_border_radius', [
            'label'      => __( 'Image Border Radius', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => '%',
                'size' => 0,
            ],
            'selectors'  => [
                '{{WRAPPER}} .lc_reviewer_image img' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'image_max_width', [
            'label'      => __( 'Image Max Width', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 150,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 50,
            ],
            'selectors'  => [
                '{{WRAPPER}} .lc_reviewer_image img' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel_5', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_responsive_control( 'arrows_pos', [
            'label'      => __( 'Arrows Navigation Top Distance', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => '%',
                'size' => 41,
            ],
            'selectors'  => [
                '{{WRAPPER}} .unslider-arrow' => 'top: {{SIZE}}{{UNIT}};',
            ],
        ] );
        /*get pro controls*/
        $this->add_control( 'arrows_color_get_pro', [
            'label'     => __( 'Arrows Color', 'music-pack' ),
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
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

		<div class="lc_reviews_slider_container swp-elt-widget" data-slidespeed="<?php 
        echo esc_attr( $settings['slide_speed']['size'] );
        ?>" data-slidedelay="<?php 
        echo esc_attr( $settings['slide_delay']['size'] );
        ?>">
			<i class="fas fa-quote-left swp_before_reviews" aria-hidden="true"></i>

			<div class="lc_reviews_slider swp-elt-reviews-slider">
				<?php 
        if ( $settings['review_list'] ) {
            ?>
				<ul>	
					<?php 
            foreach ( $settings['review_list'] as $review ) {
                ?>
						<li class="smc_elt_single_review">
							<div class="lc_swp_boxed text_center">
								<div class="lc_review_content">
									<?php 
                echo wp_kses_post( $review['review_content'] );
                ?>
								</div>

								<h5 class="lc_reviewer_name"><?php 
                echo esc_html( $review['reviewer_name'] );
                ?></h5>
								<?php 
                if ( strlen( $review['reviewer_position'] ) ) {
                    ?>
									<div class="lc_reviewer_position">
										<?php 
                    echo esc_html( $review['reviewer_position'] );
                    ?>
									</div>
								<?php 
                }
                ?>

								<div class="lc_reviewer_image">
									<img src="<?php 
                echo esc_attr( $review['reviewer_image']['url'] );
                ?>">
								</div>
							</div>
						</li>
					<?php 
            }
            /*foreach*/
            ?>
				</ul>	
				<?php 
        }
        /*if*/
        ?>
			</div>	
		</div>

		<?php 
    }

}
