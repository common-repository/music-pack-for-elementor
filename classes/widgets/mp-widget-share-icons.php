<?php

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Widget_Share_Icons extends Widget_Base {

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
		return 'mp-share-icons';
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
		return __('Share Icons', 'music-pack');
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
		return [ 'music pack', 'share', 'social', 'icon', 'like'];
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
				'show_text',
				[
					'label' => __( 'Show Text', 'music-pack' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'music-pack' ),
					'label_off' => __( 'No', 'music-pack' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icons',
			[
				'label' => __('Icons', 'music-pack'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'network',
			[
				'label' => __( 'Network', 'music-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [
					'facebook'	=> esc_html__('Facebook', 'music-pack'),
					'twitter'	=> esc_html__('Twitter', 'music-pack'),
					'linkedin'	=> esc_html__('LinkedIn', 'music-pack'),
					'pinterest'	=> esc_html__('Pinterest', 'music-pack'),
				]
			]
		);

		$this->add_control(
			'share_buttons',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'network' => 'facebook',
					],
					[
						'network' => 'pinterest',
					],
					[
						'network' => 'twitter',
					],
				],
				'title_field' => '{{{ network }}}',
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

		$this->add_control(
			'text_col',
			[
				'label' => __('Text Color', 'music-pack'),
				'type' => Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'selectors' => [
					'{{WRAPPER}} .lc_share_item_text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __('Text Typography', 'music-pack'),
				'name' => 'text_typo',
				'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				'selector' => '{{WRAPPER}} .lc_share_item_text',
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'txt_margin',
			[
				'label' => esc_html__( 'Text Margin', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 0,
						'step' => 1,
					],
				],
				'default'	=> [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .lc_share_item_text' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'separator_panel_1',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
				'condition' => [
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => 30,
						'min' => 5,
						'step' => 1,
					],
				],
				'default'	=> [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_gap',
			[
				'label' => esc_html__( 'Icons Gap', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 0,
						'step' => 1,
					],
				],
				'default'	=> [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('icon_colors');

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'music-pack' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab(); 

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'music-pack' ),
			]
		);

		$this->add_control(
			'icon_color_hov',
			[
				'label' => esc_html__( 'Icon Color', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
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
		$settings = $this->get_settings_for_display();
		if (empty($settings['share_buttons'])) {
			return;
		}

		$permalink = get_permalink();
		$title = get_the_title();
		$image = get_the_post_thumbnail_url(null, 'full');
		?>

		<div class="lc_sharing_icons">
			<?php if ("yes" == $settings['show_text']) { ?>
			<span class="lc_share_item_text"><?php echo esc_html__('Share:', 'music-pack')?></span>
			<?php } ?>

			<?php foreach ($settings['share_buttons'] as $network) {
				$this->print_share_link($network, $permalink, $title, $image);
			} ?>
		</div>

		<?php
	}

	private function print_share_link($network, $permalink, $title, $image) {
		$link = $icon_class = '';
		$encoded_url = urlencode(esc_url($permalink));

		switch ($network['network']) {
		    case "facebook":
		        $link = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url;
		        $icon_class ="fa-facebook-f";
		        break;
		    case "twitter":
		        $link = 'https://twitter.com/intent/tweet?url=' . $encoded_url;
		        $icon_class ="fa-twitter";
		        break;
		    case "linkedin":
		        $link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $encoded_url;
		        $icon_class ="fa-linkedin-in";
		        break;
		    case 'pinterest':
		    	$link = 'http://pinterest.com/pin/create/button/?url=' . $encoded_url . '&amp;media='.$image;
		    	$icon_class ="fa-pinterest-p";
		    	break;
		}

		?>

		<a href="<?php echo esc_url($link);?>" target="_blank" class="lc_share_item">
			<i class="fab <?php echo esc_attr($icon_class); ?>" aria-hidden="true"></i>
		</a>

		<?php
	}

}