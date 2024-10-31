<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor Music PackEvent Countdown Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Event_Countdown extends Widget_Base {
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
        return 'event-countdown';
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
        return __( 'Event Countdown', 'music-pack' );
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
            'event',
            'show',
            'tour',
            'countdown',
            'upcoming',
            'timer'
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
            'label' => __( 'Event Countdown', 'music-pack' ),
        ] );
        $this->add_control( 'countdown_txt', [
            'label'       => __( 'Widget Title', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Next Big Show', 'music-pack' ),
            'placeholder' => __( 'Type your text here', 'music-pack' ),
        ] );
        $this->add_control( 'show_image', [
            'label'        => __( 'Show Event Image', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Show', 'music-pack' ),
            'label_off'    => __( 'Hide', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'no',
        ] );
        $this->add_control( 'use_custom_image', [
            'label'        => __( 'Use Custom Event Image', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'music-pack' ),
            'label_off'    => __( 'No', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'condition'    => [
                'show_image' => 'yes',
            ],
        ] );
        $this->add_control( 'custom_image', [
            'label'     => __( 'Choose Event Image', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::MEDIA,
            'default'   => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'show_image'       => 'yes',
                'use_custom_image' => 'yes',
            ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_style', [
            'label' => __( 'Event Countdown', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'left_right_padding', [
            'label'      => __( 'Left/Right Padding', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 50,
            ],
            'selectors'  => [
                '{{WRAPPER}} .swp_event_countdown' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'top_bottom_padding', [
            'label'      => __( 'Top/Bottom Padding', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 45,
            ],
            'selectors'  => [
                '{{WRAPPER}} .swp_event_countdown' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel1', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'border_radius', [
            'label'      => __( 'Border Radius', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 10,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 5,
            ],
            'selectors'  => [
                '{{WRAPPER}} .swp_event_countdown' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel2', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'label'    => __( 'Background Color', 'music-pack' ),
            'name'     => 'background_color_free',
            'types'    => ['classic'],
            'selector' => '{{WRAPPER}} .swp_event_countdown',
        ] );
        /*get pro free opts*/
        $this->add_control( 'separator_panel3_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'widget_title_color_get_pro', [
            'label'     => __( 'Widget Title Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel5_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'event_title_color_get_pro', [
            'label'     => __( 'Event Title Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Event Title Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel6_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'venue_color_get_pro', [
            'label'     => __( 'Venue Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'tickets_link_color_get_pro', [
            'label'     => __( 'Tickets Link Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel4_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'timer_bg_color_get_pro', [
            'label'     => __( 'Timer Background Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel4_1_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'timer_txt_color_get_pro', [
            'label'     => __( 'Timer Numbers Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Timer Numbers Typography', 'music-pack' ),
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
            'classes'  => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel4_2_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'timer_words_color_get_pro', [
            'label'     => __( 'Timer Words Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel4_3_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'timer_border_radius_get_pro', [
            'label'      => __( 'Timer Border Radius', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 10,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 5,
            ],
            'selectors'  => [],
            'classes'    => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel7_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
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
        $settings = $this->get_settings_for_display();
        $user_text = $settings['countdown_txt'];
        $show_image = $settings['show_image'];
        /*
        $event_data['thumbnail']
        $event_data['event_title']
        $event_data['event_venue']
        $event_data['event_buy_tickets_message']
        $event_data['event_buy_tickets_url']
        $event_data['time_attr']
        */
        $event_data = $this->get_next_event_data();
        if ( empty( $event_data ) ) {
            return;
        }
        $img_src = "";
        if ( "yes" == $show_image ) {
            $img_src = ( "yes" == $settings['use_custom_image'] ? $settings['custom_image']['url'] : $event_data['thumbnail'] );
        }
        ?>
		<div class="swp_event_countdown clearfix" data-todate="<?php 
        echo esc_attr( $event_data['time_attr'] );
        ?>">
			<div class="event_countdown_details ec_inline">
				<?php 
        if ( strlen( $img_src ) ) {
            ?>
				<div class="ev_cd_img">
					<img src="<?php 
            echo esc_attr( esc_url( $img_src ) );
            ?>" alt="<?php 
            echo esc_attr( $event_data['event_title'] );
            ?>">
				</div>
				<?php 
        }
        ?>
				<div class="ec_details_inner">
					<div class="ec_user_text"><?php 
        echo esc_html( $user_text );
        ?></div>
					<div class="ec_title">
						<a href="<?php 
        the_permalink();
        ?>" class="ec_title_link">
							<?php 
        echo esc_html( $event_data['event_title'] );
        ?>
						</a>
					</div>
					<div class="ec_venue"><?php 
        echo esc_html( $event_data['event_venue'] );
        ?></div>
				</div>
			</div>

			<div class="event_countdown_timer ec_inline clearfix">
				<div class="event_countdown_timer_inner">
					<div class="ec_days ec_timer_entry ec_inline">
						<div class="days_amount ec_amount">00</div>
						<span class="countdown_timer_word"><?php 
        echo esc_html__( "Days", "music-pack" );
        ?></span>
					</div>
					<div class="ec_hours ec_timer_entry ec_inline">
						<div class="hours_amount ec_amount">00</div>
						<span class="countdown_timer_word"><?php 
        echo esc_html__( "Hrs", "music-pack" );
        ?></span>
					</div>
					<div class="ec_mins ec_timer_entry ec_inline">
						<div class="mins_amount ec_amount">00</div>
						<span class="countdown_timer_word"><?php 
        echo esc_html__( "Mins", "music-pack" );
        ?></span>
					</div>
					<div class="ec_seconds ec_timer_entry ec_inline">
						<div class="seconds_amount ec_amount">00</div>
						<span class="countdown_timer_word"><?php 
        echo esc_html__( "Secs", "music-pack" );
        ?></span>
					</div>
				</div>
			</div>

			<div class="event_countdown_tickets ec_inline ec_countdown_buy">
				<?php 
        if ( strlen( $event_data['event_buy_tickets_message'] ) ) {
            ?>
					<a href="<?php 
            echo esc_url( $event_data['event_buy_tickets_url'] );
            ?>" target="_blank" class="ec_title_link_tickets">
						<?php 
            echo esc_html( $event_data['event_buy_tickets_message'] );
            ?>
					</a>
				<?php 
        }
        ?>
			</div>
		</div>

		<?php 
    }

    private function get_next_event_data() {
        $args = array(
            'numberposts'      => 1,
            'posts_per_page'   => 1,
            'orderby'          => array(
                'event_date' => 'ASC',
                'event_time' => 'ASC',
            ),
            'order'            => 'ASC',
            'meta_key'         => 'event_date',
            'post_type'        => 'js_events',
            'post_status'      => 'publish',
            'suppress_filters' => false,
            'meta_query'       => array(
                'relation'   => 'AND',
                'event_date' => array(
                    'key'     => 'event_date',
                    'value'   => date( 'Y/m/d', current_time( 'timestamp' ) ),
                    'compare' => '>=',
                ),
                'event_time' => array(
                    'key' => 'event_time',
                ),
            ),
        );
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query( $args );
        $event_data = array();
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $event_id = get_the_ID();
                $event_data['thumbnail'] = ( has_post_thumbnail( $event_id ) ? get_the_post_thumbnail_url( $event_id, 'medium' ) : "" );
                $event_data['event_title'] = get_the_title();
                $event_data['event_venue'] = esc_html( get_post_meta( $event_id, 'event_venue', true ) );
                $event_data['event_buy_tickets_message'] = esc_html( get_post_meta( $event_id, 'event_buy_tickets_message', true ) );
                $event_data['event_buy_tickets_url'] = esc_html( get_post_meta( $event_id, 'event_buy_tickets_url', true ) );
                $event_date = esc_html( get_post_meta( $event_id, 'event_date', true ) );
                $event_time = esc_html( get_post_meta( $event_id, 'event_time', true ) );
                if ( strlen( $event_time ) ) {
                    $build_time = $event_date . " " . $event_time . ":00";
                } else {
                    $build_time = $event_date;
                }
                if ( strtotime( $build_time ) ) {
                    $final_date = new DateTime($build_time);
                } else {
                    /*fallback - current date*/
                    $final_date = new DateTime('tomorrow');
                }
                $event_data['time_attr'] = $final_date->format( "F d, Y H:i:s" );
            }
        }
        return $event_data;
    }

}
