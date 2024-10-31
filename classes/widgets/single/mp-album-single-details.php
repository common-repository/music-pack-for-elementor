<?php

use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class MP_Album_Single_Details extends Widget_Base {
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
        return 'sm-album-single-details';
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
        return __( 'Album Single: Details', 'music-pack' );
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
        return ['music pack', 'album single', 'album details'];
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
        /*get pro controls [[[*/
        $this->add_control( 'icon_color_get_pro', [
            'label'     => esc_html__( 'Icon Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icon_size_get_pro', [
            'label'     => esc_html__( 'Icon Size', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 30,
                    'min'  => 10,
                    'step' => 1,
                ],
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icon_space_get_pro', [
            'label'     => esc_html__( 'Icon Space', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 30,
                    'min'  => 5,
                    'step' => 1,
                ],
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_1_get_pro', [
            'type'  => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'label_color_get_pro', [
            'label'     => esc_html__( 'Label Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'label'    => esc_html__( 'Label Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_2', [
            'type'  => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'text_color_get_pro', [
            'label'     => esc_html__( 'Text Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
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
        if ( !is_singular( "js_albums" ) ) {
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo esc_html__( "This widget should be used in single album posts.", 'music-pack' );
            }
            return;
        }
        global $post;
        $album_ID = $post->ID;
        ?>

		<div class="album_single_elt_details">
			<div class="lc_event_entry">
				<i class="far fa-calendar-alt" aria-hidden="true"></i>
				<?php 
        $album_release_date = get_post_meta( $album_ID, 'album_release_date', true );
        $album_release_date = str_replace( "/", "-", $album_release_date );
        try {
            $output_date = new DateTime($album_release_date);
        } catch ( Exception $e ) {
            $output_date = new DateTime('NOW');
        }
        echo date_i18n( get_option( 'date_format' ), $output_date->format( 'U' ) );
        ?>
			</div>

			<div class="lc_event_entry">
				<i class="fas fa-music" aria-hidden="true"></i>
				<?php 
        $album_artist = get_post_meta( $album_ID, 'album_artist', true );
        echo esc_html( $album_artist );
        ?>
			</div>

			<?php 
        $album_label = get_post_meta( $album_ID, 'album_label', true );
        ?>
			<?php 
        if ( !empty( $album_label ) ) {
            ?>
			<div class="lc_event_entry">
				<i class="fas fa-tag" aria-hidden="true"></i>
				<?php 
            echo esc_html( $album_label );
            ?>
			</div>
			<?php 
        }
        ?>

			<?php 
        $album_cat_no = get_post_meta( $album_ID, 'album_catalogue_number', true );
        ?>
			<?php 
        if ( !empty( $album_cat_no ) ) {
            ?>
			<div class="lc_event_entry">
				<i class="fas fa-hashtag" aria-hidden="true"></i>
				<?php 
            echo esc_html( $album_cat_no );
            ?>
			</div>
			<?php 
        }
        ?>	

			<?php 
        $album_producer = get_post_meta( $album_ID, 'album_producer', true );
        ?>
			<?php 
        if ( !empty( $album_producer ) ) {
            ?>
			<div class="lc_event_entry">
				<span class="album_detail_name"><?php 
            echo esc_html__( 'Producer:', 'slide' );
            ?></span>
				<?php 
            echo esc_html( $album_producer );
            ?>
			</div>
			<?php 
        }
        ?>
			
			<?php 
        $album_no_disc = get_post_meta( $album_ID, 'album_no_disc', true );
        ?>
			<?php 
        if ( !empty( $album_no_disc ) ) {
            ?>
			<div class="lc_event_entry">
				<span class="album_detail_name"><?php 
            echo esc_html__( 'Number of discs:', 'slide' );
            ?></span>
				<?php 
            echo esc_html( $album_no_disc );
            ?>
			</div>
			<?php 
        }
        ?>
		</div>

		<?php 
    }

}
