<?php

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class MP_Album_Single_Songlist extends Widget_Base {
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
        return 'sm-album-single-songlist';
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
        return __( 'Album Single: Playlist', 'music-pack' );
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
            'playlist',
            'songlist',
            'album songs'
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
        $this->add_control( 'track_bg_col_get_pro', [
            'label'     => __( 'Item Background', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_responsive_control( 'track_padding', [
            'label'      => esc_html__( 'Item Padding', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors'  => [
                '{{WRAPPER}} .single_track' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'item_bottom_margin', [
            'label'      => __( 'Item Bottom Margin', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 50,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 10,
            ],
            'selectors'  => [
                '{{WRAPPER}} .single_track' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel_1', [
            'type'  => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'text_col_get_pro', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        /*get pro controls ]]]*/
        $this->add_control( 'container_border_radius', [
            'label'      => __( 'Border Radius', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 50,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 18,
            ],
            'selectors'  => [
                '{{WRAPPER}} .track_name' => 'padding-left: {{SIZE}}{{UNIT}};',
            ],
        ] );
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


		<div class="album_tracks">
			<?php 
        $track_order = 1;
        $album_songs_ids = get_post_meta( $album_ID, 'album_songs_ids', true );
        $idsArray = explode( ',', $album_songs_ids );
        $idsArray = array_filter( $idsArray );
        foreach ( $idsArray as $single_song_ID ) {
            $track = get_post( $single_song_ID );
            ?>

				<div class="single_track">
					<div class="track_name">
						<span class="track_order"><?php 
            echo esc_html( $track_order ) . '.';
            ?></span><?php 
            echo esc_html( $track->post_title );
            ?>
					</div>
					<?php 
            $attr = array(
                'src'      => wp_get_attachment_url( $track->ID ),
                'loop'     => '',
                'autoplay' => '',
                'preload'  => 'none',
            );
            echo wp_audio_shortcode( $attr );
            ?>
				</div>
				<?php 
            $track_order++;
        }
        ?>
		</div>
		<?php 
    }

}
