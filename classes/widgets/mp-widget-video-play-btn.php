<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor Video Play Button.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Video_Play_Button extends Widget_Base {
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
        return 'mp-video-play-button';
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
        return __( 'Video Play Button', 'music-pack' );
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

    public function get_script_depends() {
        return ['mpack-front'];
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
            'video',
            'play',
            'button'
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
        $this->start_controls_section( 'section_general', [
            'label' => __( 'Video Play Button', 'music-pack' ),
        ] );
        $this->add_control( 'video_source', [
            'label'   => __( 'Video Source', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'youtube',
            'options' => [
                'youtube' => __( 'YouTube', 'music-pack' ),
                'vimeo'   => __( 'Vimeo', 'music-pack' ),
            ],
        ] );
        $this->add_control( 'youtube_url', [
            'label'       => __( 'Link', 'music-pack' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => __( 'Enter YouTube URL', 'music-pack' ),
            'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
            'label_block' => true,
            'condition'   => [
                'video_source' => 'youtube',
            ],
        ] );
        $this->add_control( 'vimeo_url', [
            'label'       => __( 'Link', 'music-pack' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => __( 'Enter Vimeo URL', 'music-pack' ),
            'default'     => 'https://vimeo.com/235215203',
            'label_block' => true,
            'condition'   => [
                'video_source' => 'vimeo',
            ],
        ] );
        $this->add_control( 'button_text', [
            'label'       => __( 'Text', 'music-pack' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => __( 'Watch Now..', 'music-pack' ),
            'default'     => 'Watch Now',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Video Play Button', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'icon_size', [
            'label'      => __( 'Icon Size', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                '%' => [
                    'min'  => 0,
                    'max'  => 40,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 21,
            ],
            'selectors'  => [
                '{{WRAPPER}} i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'circle_size', [
            'label'      => __( 'Circle Size', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                '%' => [
                    'min'  => 0,
                    'max'  => 150,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 70,
            ],
            'selectors'  => [
                '{{WRAPPER}} .video_play_btn_scd' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'separator_panel_0_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'txt_col_get_pro', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Text Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_1_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'icon_col_get_pro', [
            'label'     => __( 'Icon Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icon_bg', [
            'label'     => __( 'Icon Background', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'add_animation_get_pro', [
            'label'        => __( 'Add Animation', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'music-pack' ),
            'label_off'    => __( 'No', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'classes'      => 'mpfe-get-pro',
        ] );
        /*get pro controls ]]]*/
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
        if ( empty( $settings['youtube_url'] ) && empty( $settings['vimeo_url'] ) ) {
            return;
        }
        $add_animation_val = "no";
        $btn_class = ( "yes" == $add_animation_val ? "video_play_btn_scd mp_play_lightbox_video swp-animate-play" : "video_play_btn_scd mp_play_lightbox_video" );
        $vid = ( "youtube" == $settings['video_source'] ? $this->get_youtube_id( $settings['youtube_url'] ) : $this->get_vimeo_id( $settings['vimeo_url'] ) );
        ?>

		<div class="swp_video_btn_scd">
			<div class="<?php 
        echo esc_attr( $btn_class );
        ?>" data-vsource="<?php 
        echo esc_attr( $settings['video_source'] );
        ?>" data-vid="<?php 
        echo esc_attr( $vid );
        ?>">
				<i class="fas fa-play video_scd_play_icon" aria-hidden="true"></i>
			</div>
			<span class="swp_after_video_btn"><?php 
        echo esc_html( $settings['button_text'] );
        ?></span>
		</div>

		<?php 
    }

    private function get_youtube_id( $url ) {
        if ( !strlen( $url ) ) {
            return "";
        }
        preg_match( '%(?:youtube(?:-nocookie)?\\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\\.be/)([^"&?/ ]{11})%i', $url, $match );
        if ( empty( $match ) ) {
            return "";
        }
        return $match[1];
    }

    private function get_vimeo_id( $url ) {
        if ( !strlen( $url ) ) {
            return "";
        }
        $url_parts = explode( "/", parse_url( $url, PHP_URL_PATH ) );
        if ( empty( $url_parts ) ) {
            return "";
        }
        return (int) $url_parts[count( $url_parts ) - 1];
    }

}
