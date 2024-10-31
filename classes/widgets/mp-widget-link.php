<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Music PackLink Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Link extends Widget_Base {

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
		return 'music-pack-link';
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
		return __('Link', 'music-pack');
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
		return [ 'music pack', 'link', 'text' ];
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
		$this->start_controls_section(
			'section_general',
			[
				'label' => __('Custom Link', 'music-pack'),
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __('Text', 'music-pack'),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Enter text content', 'music-pack'),
				'default' => __('Add Your Link Text Here', 'music-pack'),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __('Link', 'music-pack'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'music-pack'),
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
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __('View', 'music-pack'),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon After', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);		

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Custom Link', 'music-pack'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} .swp_slide_link',
			]
		);

		$this->add_control(
			'separator_panel1',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs('border_style');

		$this->start_controls_tab('normal',
			[
				'label' => __('Normal', 'music-pack'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Text Color', 'music-pack'),
				'type' => Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'selectors' => [
					'{{WRAPPER}} .swp_slide_link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel2',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'lr_padding',
			[
				'label' => __( 'Left/Right Padding', 'music-pack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .swp_slide_link' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel2_1',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'link_border',
				'label' => __( 'Border', 'music-pack' ),
				'selector' => '{{WRAPPER}} .swp_slide_link',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('hover',
			[
				'label' => __('Hover', 'music-pack'),
			]
		);

		$this->add_control(
			'title_hov_color',
			[
				'label' => __('Text Color', 'music-pack'),
				'type' => Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'selectors' => [
					'{{WRAPPER}} .swp_slide_link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel3',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'lr_hov_padding',
			[
				'label' => __( 'Left/Right Padding', 'music-pack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .swp_slide_link:hover' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel3_1',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'link_hov_border',
				'label' => __( 'Border', 'music-pack' ),
				'selector' => '{{WRAPPER}} .swp_slide_link:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs('list_colors');

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

		$this->add_render_attribute('url', 'class', 'swp_slide_link vibrant_color');
		$this->add_render_attribute('url', 'href', $settings['link']['url']);

		if ($settings['link']['is_external']) {
			$this->add_render_attribute('url', 'target', '_blank');
		}

		if (! empty($settings['link']['nofollow'])) {
			$this->add_render_attribute('url', 'rel', 'nofollow');
		}
		?>

		<a <?php echo $this->get_render_attribute_string('url'); ?>>
			<?php echo wp_kses_post($text); 
			\Elementor\Icons_Manager::render_icon($settings['icon'], [ 'aria-hidden' => 'true' ])
			?>
		</a>

		<?php
	}

	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		var iconHTML = elementor.helpers.renderIcon(view, settings.icon, { 'aria-hidden': true }, 'i' , 'object');

		view.addRenderAttribute('url', 'class', 'swp_slide_link vibrant_color');
		view.addRenderAttribute('url', 'href', settings.link.url);

		#>

		<a {{{ view.getRenderAttributeString('url') }}}>
			{{{ settings.text }}}
			{{{ iconHTML.value }}}
		</a>

		<?php
	}
}