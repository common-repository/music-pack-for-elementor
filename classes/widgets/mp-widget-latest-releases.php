<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Music Albums Widget.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Latest_Releases extends Widget_Base {

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
		return 'mp-latest-releases';
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
		return __('Latest Releases', 'music-pack');
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
		return [ 'music pack', 'music', 'albums', 'discography', 'releases' ];
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
				'label' => __('Latest Releases Widget', 'music-pack'),
			]
		);

		$this->add_control(
			'albums_no',
			[
				'label' => __( 'Albums to show', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 5,
			]
		);

		$this->add_control(
			'album_cat',
			[
				'label' => __('Albums Category:', 'music-pack'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->get_album_cat_as_array(),
			]
		);

		$this->add_control(
			'artist_id',
			[
				'label' => __('Albums By Artist:', 'music-pack'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->get_artist_as_array(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Style', 'music-pack'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'elementor-pro' ),
				'selector' => '{{WRAPPER}} .lr_album_title',
			]
		);

		$this->add_responsive_control(
			'title_bottom_margin',
			[
				'label' => esc_html__( 'Title Bottom Margin', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lr_album_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_st_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);


		$this->add_control(
			'show_cat',
			[
				'label' => __( 'Show Category', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'music-pack' ),
				'label_off' => __( 'No', 'music-pack' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cat_typography',
				'label' => __( 'Category Typography', 'elementor-pro' ),
				'selector' => '{{WRAPPER}} .lr_album_cat',
				'condition' => [
					'show_cat' => 'yes',
				],
			]
		);

		$this->add_control(
			'separator_st_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'entry_bottom_margin',
			[
				'label' => esc_html__( 'Album Entry Bottom Margin', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .latest_releases_album' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'albums_style_tabs'
		);

		$this->start_controls_tab(
			'albums_normal_tab',
			[
				'label' => __('Normal', 'music-pack'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .lr_album_title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cat_color',
			[
				'label' => __( 'Category Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .lr_album_cat a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_cat' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'albums_hover_tab',
			[
				'label' => __('Hover', 'music-pack'),
			]
		);

		$this->add_control(
			'title_color_hov',
			[
				'label' => __( 'Title Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .lr_album_title:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cat_color_hov',
			[
				'label' => __( 'Category Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .lr_album_cat a:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_cat' => 'yes',
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

		$args = MPACK_Utils::get_albums_args($settings['albums_no'], $settings['album_cat'], $settings['artist_id']);
		$lr_albums_query = new WP_Query();
		$lr_albums_query->query($args);

		if (!$lr_albums_query->have_posts()) {
			return;
		}

		$container_class = 'mpack-latest-releases';
		?>

		<div class="<?php echo esc_attr($container_class); ?>">
			<?php while ($lr_albums_query->have_posts()) {
				$lr_albums_query->the_post();
				?>
				<div class="latest_releases_album">
					<a href="<?php the_permalink(); ?>">
						<h5 class="lr_album_title">
							<?php the_title(); ?>
						</h5>
					</a>
					<?php if (("yes" == $settings['show_cat']) && (has_term('', "album_category"))) { ?>
						<div class="lr_album_cat">
							<?php the_terms("", "album_category", '', ' ', '');	 ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
		<?php		
	}

	private function get_album_cat_as_array() {
		$cat_args = array(
		    'orderby'    => 'name',
		    'order'      => 'ASC',
		    'hide_empty' => 'false',
		);

		$album_categories = get_terms('album_category', $cat_args);

		/*default*/
		$cat_arr = array(0	=>	esc_html__("All", 'music-pack'));

		if (empty($album_categories)) {
			return $cat_arr;
		}

		foreach ( $album_categories as $cat ) {
			$cat_arr[$cat->term_id] = $cat->name; 
		}

		return $cat_arr;
	}

	private function get_artist_as_array() {
		$args = array(
				'numberposts'		=> 	-1,
				'orderby'          => 'title',
				'order'            => 'ASC',
				'post_type'        => 'js_artist',
				'post_status'      => 'publish',
				'suppress_filters' => false
			);
		$result_posts = get_posts($args);

		$artist_arr = array(0	=>	esc_html__("All", 'music-pack'));

		foreach($result_posts as $single_post) {
				$artist_arr[$single_post->ID] = $single_post->post_title;
		}

		return $artist_arr;
	}
}
