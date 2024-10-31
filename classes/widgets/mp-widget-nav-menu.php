<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Contact Details.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Nav_Menu extends Widget_Base {

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
		return 'mp-nav-menu';
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
		return __('Nav Menu', 'music-pack');
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
		return [ 'music pack', 'menu', 'nav' ];
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
				'label' => __('Navigation Menu', 'music-pack'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$menus = $this->get_available_menus();

		if (empty($menus)) {
			$this->add_control(
				'no_menus',
				[
					'label' => esc_html__('No menus', 'music-pack'),
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => esc_html__('There are no menus created on your WordPress.', 'music-pack') . '<br>' . sprintf(__('Go to your <a href="%s" target="_blank">menus settings</a> to create a menu.', 'music-pack'), admin_url('nav-menus.php?action=edit&menu=0')),
					'content_classes' => 'music-pack-control-alert',
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'label' => __('Menu', 'music-pack'),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys($menus)[0],
					'save_default' => true,
					'separator' => 'after',
					'description' => sprintf(__('You can edit your menus from the <a href="%s" target="_blank">Menus screen</a>.', 'music-pack'), admin_url('nav-menus.php')),
				]
			);
		}

		$this->add_control(
			'menu_layout',
			[
				'label' => __('Layout', 'music-pack'),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __('Horizontal', 'music-pack'),
					'vertical' => __('Vertical', 'music-pack'),
				],
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

		$this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __('Typography', 'music-pack'),
				'name' => 'items_typo',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} a',
			]
		);

		$this->start_controls_tabs(
			'menu_style_tabs'
		);

		$this->start_controls_tab(
			'menu_style_normal_tab',
			[
				'label' => __('Normal', 'music-pack'),
			]
		);

		$this->add_control(
			'item_col',
			[
				'label' => __('Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'menu_style_hover_tab',
			[
				'label' => __('Hover', 'music-pack'),
			]
		);

		$this->add_control(
			'item_col_hover',
			[
				'label' => __('Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_style_active_tab',
			[
				'label' => __('Active', 'music-pack'),
			]
		);

		$this->add_control(
			'item_col_active',
			[
				'label' => __('Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} li.current_page_item > a' => 'color: {{VALUE}};',
				],
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
		$available_menus = $this->get_available_menus();
		if (empty($available_menus)) {
			return;
		}

		$settings = $this->get_settings_for_display();

		$menu_class = 'mpack-nav-menu' . ' menu-layout-'.$settings['menu_layout'];
		?>
		
		<nav class="mpack-nav-menu-container">
			<?php 
			wp_nav_menu(
				array(
					'menu' => $settings['menu'],
					'menu_class'	=> $menu_class,
					'fallback_cb' => '__return_empty_string',
					'container' => '',
				)
			);
			?>
		</nav>
		<?php
	}

	private function get_available_menus() {
		$available_menus = wp_get_nav_menus();

		if (empty($available_menus)) {
			return array();
		}

		$options = [];
		foreach ($available_menus as $single_menu) {
			$options[$single_menu->slug] = $single_menu->name;
		}

		return $options;
	}
}
