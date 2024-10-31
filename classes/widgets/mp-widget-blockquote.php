<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Blockquote Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Blockquote extends Widget_Base {

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
		return 'mp-blockquote';
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
		return __('Blockquote', 'music-pack');
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
        return [
            'mpack-front'
        ];
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
		return [ 'music pack', 'blockquote', 'quote', 'cite' ];
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
		$this->start_controls_section(
			'section_general',
			[
				'label' => __('General', 'music-pack'),
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __('Content', 'music-pack'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'music-pack') . __('Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'music-pack'),
				'placeholder' => __('Enter your quote', 'music-pack'),
				'rows' => 10,
			]
		);

		$this->add_control(
			'author',
			[
				'label' => __('Author', 'music-pack'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __('John Doe', 'music-pack'),
				'separator' => 'after',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Style', 'music-pack'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => __('Text Align', 'music-pack'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'music-pack'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'music-pack'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'music-pack'),
						'icon' => 'eicon-text-align-right',
					]
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mp-blockquote' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Container Padding', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .mp-blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'content_text_color',
			[
				'label' => __( 'Content Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .mp-blockquote-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'elementor-pro' ),
				'selector' => '{{WRAPPER}} .mp-blockquote-content',
			]
		);

		$this->add_control(
			'separator_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'author_text_color',
			[
				'label' => __( 'Author Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} cite.mp-blockquote-author' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_typography',
				'label' => __( 'Author Typography', 'elementor-pro' ),
				'selector' => '{{WRAPPER}} cite.mp-blockquote-author',
			]
		);

		$this->add_control(
			'separator_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mp-quote-icon i' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mp-quote-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_bmargin',
			[
				'label' => esc_html__( 'Icon Bottom Margin', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mp-quote-icon i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

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
		$this->add_render_attribute('author', [ 'class' => 'mp-blockquote-author' ]);
		$this->add_render_attribute('blockquote', [ 'class' => 'mp-blockquote' ]);

		?>
		<blockquote <?php echo $this->get_render_attribute_string( 'blockquote' ); ?>>
			<div class="mp-quote-icon">
				<i class="fas fa-quote-left" aria-hidden="true"></i>
			</div>
			
			<div class="mp-blockquote-content">
				<?php echo esc_html($settings['content']); ?>
			</div>
			
			<?php if (!empty( $settings['author'])) { ?>
				<cite <?php echo $this->get_render_attribute_string( 'author' ); ?>><?php echo esc_html($settings['author']); ?></cite>
			<?php } ?>
		</blockquote>
		<?php


	}
}
