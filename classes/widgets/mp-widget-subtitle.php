<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Music Pack subtitle Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Subtitle extends Widget_Base {

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
		return 'mp-subtitle';
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
		return __('Subtitle', 'music-pack');
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
		return [ 'music pack', 'heading', 'subtitle', 'text', 'title' ];
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
				'label' => __('Subtitle', 'music-pack'),
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
				'default' => __('Unforgettable Moments', 'music-pack'),
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

		$this->add_control(
			'header_size',
			[
				'label' => __('HTML Tag', 'music-pack'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
				],
				'default' => 'h3',
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
					],
					'justify' => [
						'title' => __('Justified', 'music-pack'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
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

		$this->end_controls_section();
		
		/*STYLE SECTION*/
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Subtitle', 'music-pack'),
				'tab' => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .mpack-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} .mpack-subtitle',
			]
		);

		$this->add_control(
			'separator_panel_1',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'margin_top',
			[
				'label' => __( 'Margin Top', 'music-pack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mpack-subtitle' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin_bottom',
			[
				'label' => __( 'Margin Bottom', 'music-pack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mpack-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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


		$this->add_render_attribute('text', 'class', 'mpack-subtitle');
		$this->add_inline_editing_attributes('text');

		$text = $settings['text'];
		if (!empty($settings['link']['url'])) {
			$this->add_render_attribute('url', 'href', $settings['link']['url']);

			if ($settings['link']['is_external']) {
				$this->add_render_attribute('url', 'target', '_blank');
			}

			if (! empty($settings['link']['nofollow'])) {
				$this->add_render_attribute('url', 'rel', 'nofollow');
			}

			$text = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $text);
		}

		$text_html = sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('text'), $text);

		echo wp_kses_post($text_html);
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
		var text = settings.text;

		if ('' !== settings.link.url) {
			text = '<a href="' + settings.link.url + '">' + text + '</a>';
		}

		view.addRenderAttribute('text', 'class', 'mpack-subtitle');

		view.addInlineEditingAttributes('text');

		var text_html = '<' + settings.header_size  + ' ' + view.getRenderAttributeString('text') + '>' + text + '</' + settings.header_size + '>';

		print(text_html);
		#>
		<?php
	}

}
