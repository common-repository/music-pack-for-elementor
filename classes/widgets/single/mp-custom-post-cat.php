<?php

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class MP_Custom_Post_Cat extends Widget_Base {
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
        return 'sm-custom-post-cat';
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
        return __( 'Single: Custom Post Category', 'music-pack' );
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
            'album category',
            'artist category',
            'event category',
            'artist category',
            'artist category',
            'gallery category'
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
        $this->add_responsive_control( 'text_align', [
            'label'     => __( 'Text Align', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [
                    'title' => __( 'Left', 'music-pack' ),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __( 'Center', 'music-pack' ),
                    'icon'  => 'eicon-text-align-center',
                ],
                'right'  => [
                    'title' => __( 'Right', 'music-pack' ),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'   => 'center',
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'separator_panel_1', [
            'type'  => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_responsive_control( 'item_padding', [
            'label'      => esc_html__( 'Category Padding', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors'  => [
                '{{WRAPPER}} .lc_cpt_category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        if ( !is_singular( "js_albums" ) && !is_singular( "js_artist" ) && !is_singular( "js_events" ) && !is_singular( "js_photo_albums" ) && !is_singular( "js_videos" ) && !is_singular( "post" ) ) {
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo esc_html__( "This widget should be used in the following posts: single artist, single event, single discography, single video or single photo album.", 'music-pack' );
            }
            return;
        }
        global $post;
        $post_id = $post->ID;
        if ( empty( $post_id ) ) {
            return;
        }
        $post_type = get_post_type( $post_id );
        $taxonomy_name = $this->get_tax_name_by_post_type( $post_type );
        ?>

		<div class="lc_post_meta lc_cpt_category cpt_post_meta lc_swp_full">
			<span class="meta_entry lc_cpt_category">
				<?php 
        if ( has_term( '', $taxonomy_name, $post_id ) ) {
            the_terms(
                $post_id,
                $taxonomy_name,
                '',
                ' ',
                ''
            );
        }
        ?>
			</span>
		</div>

		<?php 
    }

    private function get_tax_name_by_post_type( $post_type ) {
        switch ( $post_type ) {
            case "js_albums":
                return 'album_category';
            case 'js_events':
                return 'event_category';
            case 'js_photo_albums':
                return 'photo_album_category';
            case 'js_videos':
                return 'video_category';
            case 'js_artist':
                return 'artist_category';
            default:
                return 'category';
        }
    }

}
