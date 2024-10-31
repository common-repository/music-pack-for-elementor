<?php

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class MP_Album_Single_Promo_Links extends Widget_Base {
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
        return 'sm-album-single-promo-links';
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
        return __( 'Album Single: Promo Links', 'music-pack' );
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
        return [
            'music pack',
            'album single',
            'promo',
            'buttons'
        ];
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
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Style', 'music-pack' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        /*get pro controls*/
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_1', [
            'type'  => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'border',
            'selector' => '{{WRAPPER}} a.album_buy_link',
        ] );
        $this->add_control( 'link_br', [
            'label'      => __( 'Border Radius', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 30,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 3,
            ],
            'selectors'  => [
                '{{WRAPPER}} a.album_buy_link' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel_2', [
            'type'  => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_responsive_control( 'padding', [
            'label'      => esc_html__( 'Padding', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors'  => [
                '{{WRAPPER}} a.album_buy_link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );
        $this->start_controls_tabs( 'buttons_style' );
        $this->start_controls_tab( 'btn_style_normal_tab', [
            'label' => __( 'Normal', 'music-pack' ),
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'btn_background_get_pro', [
            'label'   => __( 'Button Background', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'classic'  => [
                    'title' => __( 'Classic', 'music-pack' ),
                    'icon'  => 'eicon-paint-brush',
                ],
                'gradient' => [
                    'title' => __( 'Gradient', 'music-pack' ),
                    'icon'  => 'eicon-barcode',
                ],
            ],
            'default' => 'classic',
            'toggle'  => true,
            'classes' => 'mpfe-get-pro',
        ] );
        $this->add_control( 'btn_bg_col_get_pro', [
            'label'     => __( 'Background Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'btn_txt_col_get_pro', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'btn_border_col_get_pro', [
            'label'     => __( 'Border Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        /*get pro controls ]]]*/
        $this->end_controls_tab();
        $this->start_controls_tab( 'btn_style_hover_tab', [
            'label' => __( 'Hover', 'music-pack' ),
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'btn_hov_background_get_pro', [
            'label'   => __( 'Button Background', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'classic'  => [
                    'title' => __( 'Classic', 'music-pack' ),
                    'icon'  => 'eicon-paint-brush',
                ],
                'gradient' => [
                    'title' => __( 'Gradient', 'music-pack' ),
                    'icon'  => 'eicon-barcode',
                ],
            ],
            'default' => 'classic',
            'toggle'  => true,
            'classes' => 'mpfe-get-pro',
        ] );
        $this->add_control( 'btn_bg_hov_col_get_pro', [
            'label'     => __( 'Background Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'btn_txt_hov_col_get_pro', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'btn_border_hov_col_get_pro', [
            'label'     => __( 'Border Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        /*get pro controls ]]]*/
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
        if ( !is_singular( "js_albums" ) ) {
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo esc_html__( "This widget should be used in single album posts.", 'music-pack' );
            }
            return;
        }
        global $post;
        $album_ID = $post->ID;
        ?>

			<div class="lc_event_entry small_content_padding clearfix">
				<?php 
        $album_buy_message1 = get_post_meta( $album_ID, 'album_buy_message1', true );
        $album_buy_link1 = get_post_meta( $album_ID, 'album_buy_link1', true );
        $album_buy_message2 = get_post_meta( $album_ID, 'album_buy_message2', true );
        $album_buy_link2 = get_post_meta( $album_ID, 'album_buy_link2', true );
        $album_buy_message3 = get_post_meta( $album_ID, 'album_buy_message3', true );
        $album_buy_link3 = get_post_meta( $album_ID, 'album_buy_link3', true );
        $album_buy_message4 = get_post_meta( $album_ID, 'album_buy_message4', true );
        $album_buy_link4 = get_post_meta( $album_ID, 'album_buy_link4', true );
        $album_buy_message5 = get_post_meta( $album_ID, 'album_buy_message5', true );
        $album_buy_link5 = get_post_meta( $album_ID, 'album_buy_link5', true );
        $album_buy_message6 = get_post_meta( $album_ID, 'album_buy_message6', true );
        $album_buy_link6 = get_post_meta( $album_ID, 'album_buy_link6', true );
        ?>

				<?php 
        if ( !empty( $album_buy_message1 ) ) {
            ?>
					<div class="album_buy_from">
						<a class="album_buy_link" target="_blank" class="lc_button" href="<?php 
            echo esc_url( $album_buy_link1 );
            ?>">
							<?php 
            echo esc_html( $album_buy_message1 );
            ?>
						</a>
					</div>
				<?php 
        }
        ?>

				<?php 
        if ( !empty( $album_buy_message2 ) ) {
            ?>
					<div class="album_buy_from">
						<a class="album_buy_link" target="_blank" class="lc_button" href="<?php 
            echo esc_url( $album_buy_link2 );
            ?>">
							<?php 
            echo esc_html( $album_buy_message2 );
            ?>
						</a>
					</div>
				<?php 
        }
        ?>

				<?php 
        if ( !empty( $album_buy_message3 ) ) {
            ?>
					<div class="album_buy_from">
						<a class="album_buy_link" target="_blank" class="lc_button" href="<?php 
            echo esc_url( $album_buy_link3 );
            ?>">
							<?php 
            echo esc_html( $album_buy_message3 );
            ?>
						</a>
					</div>
				<?php 
        }
        ?>

				<?php 
        if ( !empty( $album_buy_message4 ) ) {
            ?>
					<div class="album_buy_from">
						<a class="album_buy_link" target="_blank" class="lc_button" href="<?php 
            echo esc_url( $album_buy_link4 );
            ?>">
							<?php 
            echo esc_html( $album_buy_message4 );
            ?>
						</a>
					</div>
				<?php 
        }
        ?>

				<?php 
        if ( !empty( $album_buy_message5 ) ) {
            ?>
					<div class="album_buy_from">
						<a class="album_buy_link" target="_blank" class="lc_button" href="<?php 
            echo esc_url( $album_buy_link5 );
            ?>">
							<?php 
            echo esc_html( $album_buy_message5 );
            ?>
						</a>
					</div>
				<?php 
        }
        ?>

				<?php 
        if ( !empty( $album_buy_message6 ) ) {
            ?>
					<div class="album_buy_from">
						<a class="album_buy_link" target="_blank" class="lc_button" href="<?php 
            echo esc_url( $album_buy_link6 );
            ?>">
							<?php 
            echo esc_html( $album_buy_message6 );
            ?>
						</a>
					</div>
				<?php 
        }
        ?>
			</div>
		<?php 
    }

}
