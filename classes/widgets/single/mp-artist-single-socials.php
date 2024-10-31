<?php

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) exit; // Exit if accessed directly


class MPACK_Artist_Single_Socials extends Widget_Base {
 
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
		return 'sm-artist-single-socials';
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
		return __('Artist Single: Socials', 'music-pack');
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
		return [ 'music pack', 'artist single', 'socials', 'facebook', 'twitter', 'icon', 'like'];
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
				'label' => esc_html__( 'Text Before', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Follow:', 'music-pack' ),
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
				'type' =>\Elementor\Controls_Manager::COLOR,
'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				'selectors' => [
					'{{WRAPPER}} .artist_follow' => 'color: {{VALUE}};',
				],
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
				'selector' => '{{WRAPPER}} .artist_follow',
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
					'{{WRAPPER}} .artist_follow' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_1',
			[
				'type' =>\Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
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

		<div class="artist_social_single">
			<?php if (strlen($settings['text_before'])) { ?>
				<span class="artist_follow">
					<?php echo esc_html($settings['text_before']); ?>
				</span>
			<?php } ?>


			<?php
			/*social options*/
			$available_artist_profiles = array(
				/*'icon name fa-[icon name]'	=> 'settings name'*/
				'facebook-f'		=> 'artist_facebook',
				'twitter'			=>'artist_twitter',		
				'instagram'			=> 'artist_instagram',
				'soundcloud'		=>'artist_soundcloud',	
				'youtube'			=>'artist_youtube',
				'spotify'			=>'artist_spotify',
				'apple'				=>'artist_apple',
				'tiktok'			=>'artist_tiktok'
			);

			$artist_profiles = array();
			foreach ($available_artist_profiles as $key =>	$profile) {
				$profile_url = esc_url(get_post_meta($artist_id, $profile, true));

				if (!empty($profile_url)) {
					$single_profile = array();
					$single_profile['url'] 	= $profile_url;
					$single_profile['icon'] 	= $key;

					$artist_profiles[] = $single_profile;
				}
			}
			?>

			<?php foreach ($artist_profiles as $social_profile) { ?>
				<div class="artist_social_profile artist_single mp-widget">
					<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank">
						<i class="fab fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
					</a>
				</div>
			<?php }	?>		
		</div>

		<?php
	}
}