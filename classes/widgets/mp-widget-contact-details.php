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
class MPACK_Widget_Contact_Details extends Widget_Base {

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
		return 'mp-contact-details';
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
		return __('Contact Details', 'music-pack');
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
		return [ 'music pack', 'contact', 'address' ];
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
				'label' => __('Contact Details', 'music-pack'),
			]
		);

		$this->add_control(
			'address',
			[
				'label' => __( 'Address', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( '2066 Merton Street, Toronto, Ontario', 'music-pack' ),
				'placeholder' => __( 'Type your physical address here', 'music-pack' ),
			]
		);

		$this->add_control(
			'email',
			[
				'label' => __('Email', 'music-pack'),
				'type' => Controls_Manager::TEXT,
				'default' => __('hello@musicpack.com', 'music-pack'),
			]
		);

		$this->add_control(
			'phone',
			[
				'label' => __('Phone', 'music-pack'),
				'type' => Controls_Manager::TEXT,
				'default' => __('+89 425 753 5428', 'music-pack'),
			]
		);

		$this->add_control(
			'phone2',
			[
				'label' => __('Second Phone', 'music-pack'),
				'type' => Controls_Manager::TEXT,
				'default' => __('+89 425 753 5428', 'music-pack'),
			]
		);

		$this->add_control(
			'fax',
			[
				'label' => __('Fax', 'music-pack'),
				'type' => Controls_Manager::TEXT,
				'default' => __('+89 916 768 5532', 'music-pack'),
			]
		);
	

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Contact Details', 'music-pack'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'address_col',
			[
				'label' => __('Address Color', 'music-pack'),
				'type' => Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .address_entry' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __('Address Typography', 'music-pack'),
				'name' => 'address_typo',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} .address_entry',
			]
		);

		$this->add_control(
			'separator_panel_1',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'labels_col',
			[
				'label' => __('Labels Color', 'music-pack'),
				'type' => Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .before_contact_entry' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __('Labels Typography', 'music-pack'),
				'name' => 'labels_typo',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} .before_contact_entry',
			]
		);

		$this->add_control(
			'separator_panel_2',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'contact_data_col',
			[
				'label' => __('Contact Data Color', 'music-pack'),
				'type' => Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .contact_address_data' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __('Contact Data Typography', 'music-pack'),
				'name' => 'contact_data_typo',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} .contact_address_data',
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
		?>

		<div class="swp_contact_data">
			<?php if (!empty($settings['address'])) { ?>
			<div class="contact_address_entry address_entry vibrant_color">
				<?php echo wp_kses_post($settings['address']); ?>
			</div>
			<?php }?>

			<?php if (!empty($settings['email'])) { ?>
			<div class="contact_address_entry">
				<div class="before_contact_entry">
					<?php echo esc_html__("Email:", 'music-pack'); ?>
				</div>
				<div class="contact_address_data">
					<?php echo esc_html(sanitize_email($settings['email'])); ?>
				</div>
			</div>
			<?php } ?>

			<?php if (!empty($settings['phone'])) { ?>
			<div class="contact_address_entry">
				<div class="before_contact_entry">
					<?php echo esc_html__("Phone:", 'music-pack'); ?>
				</div>
				<div class="contact_address_data">
					<?php echo esc_html($settings['phone']); ?>
					<?php if (!empty($settings['phone2'])) { ?>
						<br> <?php echo esc_html($settings['phone2']); ?>
					<?php } ?>
				</div>
			</div>
			<?php } ?>

			<?php if (!empty($settings['fax'])) { ?>
			<div class="contact_address_entry">
				<div class="before_contact_entry">
					<?php echo esc_html__("Fax:", 'music-pack'); ?>
				</div>
				<div class="contact_address_data">
					<?php echo esc_html($settings['fax']); ?>
				</div>
			</div>
			<?php } ?>		
		</div>

		<?php		
	}
}
