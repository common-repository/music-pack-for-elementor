<?php

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) exit; // Exit if accessed directly


class MPACK_Artist_Single_Website_Link extends Widget_Base {
 
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
		return 'sm-artist-website-link';
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
		return __('Artist Single: Website Link', 'music-pack');
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
		return [ 'music pack', 'artist single', 'website', 'link'];
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
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text_before',
			[
				'label' => esc_html__( 'Link Text', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Official website:', 'music-pack' ),
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} .mp-artist-web-link',
			]
		);

		$this->add_control(
			'separator_panel1',
			[
				'type' =>\Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs('web-link-cols');

		$this->start_controls_tab('normal',
			[
				'label' => __('Normal', 'music-pack'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Text Color', 'music-pack'),
				'type' =>\Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'selectors' => [
					'{{WRAPPER}} .mp-artist-web-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel2',
			[
				'type' =>\Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'lr_padding',
			[
				'label' => __( 'Left/Right Padding', 'music-pack' ),
				'type' =>\Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .mp-artist-web-link' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel2_1',
			[
				'type' =>\Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'link_border',
				'label' => __( 'Border', 'music-pack' ),
				'selector' => '{{WRAPPER}} .mp-artist-web-link',
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
				'type' =>\Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'selectors' => [
					'{{WRAPPER}} .mp-artist-web-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel3',
			[
				'type' =>\Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'lr_hov_padding',
			[
				'label' => __( 'Left/Right Padding', 'music-pack' ),
				'type' =>\Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .mp-artist-web-link:hover' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel3_1',
			[
				'type' =>\Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'link_hov_border',
				'label' => __( 'Border', 'music-pack' ),
				'selector' => '{{WRAPPER}} .mp-artist-web-link:hover',
			]
		);

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
		if (!is_singular("js_artist")) {
			if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
				echo esc_html__("This widget should be used in single artist posts.", 'music-pack');
			}

			return;
		}

		$settings = $this->get_settings_for_display();

		global $post;
		$artist_id = $post->ID;
		?>

		<div class="artist_website artist_single">
			<?php $artist_website = esc_url(get_post_meta($artist_id, 'artist_website', true)); ?>
			<?php if (!empty($artist_website)) { ?>
				<a href="<?php echo esc_attr(esc_url($artist_website)) ;?>" target="_blank" class="mp-artist-web-link">
					<?php echo esc_html($settings['text_before']); ?>
				</a>	
			<?php } ?>
		</div>

		<?php
	}
}