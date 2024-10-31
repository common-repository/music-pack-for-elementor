<?php

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class MP_Featured_Image extends Widget_Base {

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
		return 'sm-featured-image';
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
		return __('Single: Featured Image', 'music-pack');
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
		return [ 'music pack', 'featured image', 'post thumbnail',];
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
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'id' 	=> get_post_thumbnail_id(),
					'url'	=> get_the_post_thumbnail_url()
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'img_size', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'music-pack' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'music-pack' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'music-pack' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_source',
			[
				'label' => esc_html__( 'Caption', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'music-pack' ),
					'attachment' => esc_html__( 'Attachment Caption', 'music-pack' ),
					'custom' => esc_html__( 'Custom Caption', 'music-pack' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Custom Caption', 'custom' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your image caption', 'custom' ),
				'condition' => [
					'caption_source' => 'custom',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => esc_html__( 'Link', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'music-pack' ),
					'file' => esc_html__( 'Media File', 'music-pack' ),
					'custom' => esc_html__( 'Custom URL', 'music-pack' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'music-pack' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'music-pack' ),
					'yes' => esc_html__( 'Yes', 'music-pack' ),
					'no' => esc_html__( 'No', 'music-pack' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
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
			'width',
			[
				'label' => esc_html__( 'Width', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => esc_html__( 'Max Width', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'music-pack' ),
					'fill' => esc_html__( 'Fill', 'music-pack' ),
					'cover' => esc_html__( 'Cover', 'music-pack' ),
					'contain' => esc_html__( 'Contain', 'music-pack' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'music-pack' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => esc_html__( 'Opacity', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'music-pack' ),
			]
		);

		$this->add_control(
			'opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover img',
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => esc_html__( 'Caption', 'music-pack' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption_source!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'caption_align',
			[
				'label' => esc_html__( 'Alignment', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'music-pack' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'music-pack' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'music-pack' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'music-pack' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_control(
			'caption_background_color',
			[
				'label' => esc_html__( 'Background Color', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .widget-image-caption',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'caption_text_shadow',
				'selector' => '{{WRAPPER}} .widget-image-caption',
			]
		);

		$this->add_responsive_control(
			'caption_space',
			[
				'label' => esc_html__( 'Spacing', 'music-pack' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
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
		if ( empty( $settings['image']['id'] ) ) {
			return;
		}

		$has_caption = $this->has_caption( $settings );
		$link = $this->get_link_url( $settings );

		if ( $link ) {
			$this->add_link_attributes( 'link', $link );

			if ( Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute( 'link', [
					'class' => 'elementor-clickable',
				] );
			}

			if ( 'custom' !== $settings['link_to'] ) {
				$this->add_lightbox_data_attributes( 'link', $settings['image']['id'], $settings['open_lightbox'] );
			}
		} ?>

		<?php if ( $has_caption ) { ?>
			<figure class="wp-caption">
		<?php } ?>
			<?php if ( $link ) { ?>
					<a <?php $this->print_render_attribute_string( 'link' ); ?>>
			<?php } ?>
				<?php \Elementor\Group_Control_Image_Size::print_attachment_image_html($settings, 'img_size', 'image'); ?>
			<?php if ( $link ) { ?>
				</a>
			<?php } ?>
		<?php if ( $has_caption ) { ?>
				<figcaption class="widget-image-caption wp-caption-text"><?php
					echo wp_kses_post( $this->get_caption( $settings ) );
				?></figcaption>
		<?php }
	}

	private function has_caption( $settings ) {
		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	private function get_caption( $settings ) {
		$caption = '';
		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['image']['id'] );
					break;
				case 'custom':
					$caption = ! \Elementor\Utils::is_empty( $settings['caption'] ) ? $settings['caption'] : '';
			}
		}
		return $caption;
	}

	private function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}

			return $settings['link'];
		}

		return [
			'url' => $settings['image']['url'],
		];
	}
}