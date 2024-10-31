<?php

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Event_Single_Promo_Links extends Widget_Base {

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
		return 'sm-event-single-promo-links';
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
		return __('Event Single: Promo Links', 'music-pack');
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
		return [ 'music pack', 'event single', 'promo links'];
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
			'section_style',
			[
				'label' => __('Style', 'music-pack'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __('Typography', 'music-pack'),
				'name' => 'buttons_typo',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} a.event_single_promo',
			]
		);

		$this->add_control(
			'separator_panel_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} a.event_single_promo',
			]
		);

		$this->add_control(
			'link_br',
			[
				'label' => __( 'Border Radius', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'buttons_style'
		);
		
		$this->start_controls_tab(
			'btn_style_normal_tab',
			[
				'label' => __('Normal', 'music-pack'),
			]
		);

		$this->add_control(
			'btn_background',
			[
				'label' => __('Button Background', 'music-pack'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'classic' => [
						'title' => __('Classic', 'music-pack'),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => __('Gradient', 'music-pack'),
						'icon' => 'eicon-barcode',
					],

				],
				'default' => 'classic',
				'toggle' => true,
			]
		);

		$this->add_control(
			'btn_bg_col',
			[
				'label' => __('Background Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'btn_background' => 'classic',
				],
			]
		);

		$this->add_control(
			'btn_bg_col1',
			[
				'label' => __('Background First Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo' => 'background-image: linear-gradient(to right, {{VALUE}}, {{btn_bg_col2.VALUE}}); background-clip: padding-box;',
				],
				'condition' => [
					'btn_background' => 'gradient',
				],
			]
		);

		$this->add_control(
			'btn_bg_col2',
			[
				'label' => __('Background Second Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo' => 'background-image: linear-gradient(to right, {{btn_bg_col1.VALUE}}, {{VALUE}}); background-clip: padding-box;',
				],
				'condition' => [
					'btn_background' => 'gradient',
				],
			]
		);

		$this->add_control(
			'btn_txt_col',
			[
				'label' => __('Text Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border_col',
			[
				'label' => __('Border Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'btn_style_hover_tab',
			[
				'label' => __('Hover', 'music-pack'),
			]
		);

		$this->add_control(
			'btn_hov_background',
			[
				'label' => __('Button Background', 'music-pack'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'classic' => [
						'title' => __('Classic', 'music-pack'),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => __('Gradient', 'music-pack'),
						'icon' => 'eicon-barcode',
					],

				],
				'default' => 'classic',
				'toggle' => true,
			]
		);

		$this->add_control(
			'btn_bg_hov_col',
			[
				'label' => __('Background Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo:hover' => 'background-color: {{VALUE}}; background-image: none;',
				],
				'condition' => [
					'btn_hov_background' => 'classic',
				],
			]
		);

		$this->add_control(
			'btn_bg_hov_col1',
			[
				'label' => __('Background First Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo:hover' => 'background-image: linear-gradient(to right, {{VALUE}}, {{btn_bg_hov_col2.VALUE}}); background-clip: padding-box;',
				],
				'condition' => [
					'btn_hov_background' => 'gradient',
				],
			]
		);

		$this->add_control(
			'btn_bg_hov_col2',
			[
				'label' => __('Background Second Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo:hover' => 'background-image: linear-gradient(to right, {{btn_bg_hov_col1.VALUE}}, {{VALUE}}); background-clip: padding-box;',
				],
				'condition' => [
					'btn_hov_background' => 'gradient',
				],
			]
		);

		$this->add_control(
			'btn_txt_hov_col',
			[
				'label' => __('Text Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border_hov_col',
			[
				'label' => __('Border Color', 'music-pack'),
				'type' => \Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.event_single_promo:hover' => 'border-color: {{VALUE}} !important;',
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
		if (!is_singular("js_events")) {
			if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
				echo esc_html__("This widget should be used in single events.", 'music-pack');
			}

			return;
		}

		global $post;
		$event_id = $post->ID;

		$event_buy_tickets_message = get_post_meta($event_id, 'event_buy_tickets_message', true);
		$event_buy_tickets_url = get_post_meta($event_id, 'event_buy_tickets_url', true);
		/*if buy tickets message is empty - give it a default value*/
		if (empty($event_buy_tickets_message) && !empty($event_buy_tickets_url)) {
			$event_buy_tickets_message = esc_html__('Tickets', 'music-pack');
		}
		$tickets_target = get_post_meta($event_id, 'event_buy_tickets_target', true);
		if (empty($tickets_target)) {
			$tickets_target = "_blank";
		}
		?>

		<?php 
		$event_fb_message = get_post_meta($event_id, 'event_fb_message', true);
		$event_fb_url  = get_post_meta($event_id, 'event_fb_url', true);
		if (empty($event_fb_message) && !empty($event_fb_url)) {
			$event_fb_message = esc_html__('Facebook Event ', 'music-pack');	
		}

		$event_canceled = get_post_meta($event_id, 'event_canceled', true);
		$event_canceled = empty($event_canceled) ? false : true;
		$event_sold_out = get_post_meta($event_id, 'event_sold_out', true);
		$event_sold_out = empty($event_sold_out) ? false : true;
		?>

		<div class="small_content_padding">
			<?php if ((!empty($event_buy_tickets_url)) || (!empty($event_fb_url))) { ?>
			<div class="lc_event_entry event_promo_btns">
				<?php 
					$button_class = "lc_button MPACK_Event_promo"; 
					$button_text = $event_buy_tickets_message;
					if ($event_canceled) {
							$button_class .= " event_canceled";
							$button_text = esc_html__("Canceled", 'music-pack');						
					} elseif ($event_sold_out) {
							$button_class .= " event_sold_out";
							$button_text = esc_html__("Sold Out", 'music-pack');						
					}
				?>

				<div class="<?php echo esc_attr($button_class); ?>">
					<a href="<?php echo esc_url($event_buy_tickets_url); ?>" target="<?php echo esc_attr($tickets_target); ?>" class="event_single_promo">
						<?php echo esc_html($button_text); ?>
					</a>
				</div>

				<?php if (!empty($event_fb_url)) { ?>
					<div class="lc_button MPACK_Event_promo">
						<a href="<?php echo esc_url($event_fb_url); ?>" target="_blank" class="event_single_promo">
							<?php echo esc_html($event_fb_message); ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php } ?>

		</div>
		<?php
	}
}