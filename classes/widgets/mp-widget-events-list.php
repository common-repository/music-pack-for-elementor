<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor Music PackEvents List Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Events_List extends Widget_Base {
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
        return 'events-list';
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
        return __( 'Events List', 'music-pack' );
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
            'tour',
            'show',
            'list'
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
            'label' => __( 'Events List', 'music-pack' ),
        ] );
        $this->add_control( 'count', [
            'label'   => __( 'Events Number', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 100,
            'step'    => 5,
            'default' => 5,
        ] );
        $this->add_control( 'event_category', [
            'label'   => __( 'Event Category', 'lucille-music-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '0',
            'options' => $this->get_events_cat_as_array(),
        ] );
        $this->add_control( 'past_next', [
            'label'   => __( 'Show', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'next',
            'options' => [
                'next' => __( 'Next Events', 'music-pack' ),
                'past' => __( 'Past Events', 'music-pack' ),
                'all'  => __( 'All Events', 'music-pack' ),
            ],
        ] );
        $this->add_control( 'sort_events', [
            'label'   => __( 'Sort Events', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'ASC',
            'options' => [
                'ASC'  => __( 'Ascending', 'music-pack' ),
                'DESC' => __( 'Descending', 'music-pack' ),
            ],
        ] );
        $this->add_control( 'artist_id', [
            'label'   => __( 'Firlter By Artist:', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '0',
            'options' => $this->get_artist_as_array(),
        ] );
        $this->add_control( 'show_year_get_pro', [
            'label'        => __( 'Show Event Year', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Show', 'music-pack' ),
            'label_off'    => __( 'Hide', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'classes'      => 'mpfe-get-pro',
        ] );
        $this->add_control( 'show_image_get_pro', [
            'label'        => __( 'Show Event Image', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Show', 'music-pack' ),
            'label_off'    => __( 'Hide', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'classes'      => 'mpfe-get-pro',
        ] );
        $this->end_controls_section();
        /*STYLE SECTION*/
        $this->start_controls_section( 'section_title_style', [
            'label' => __( 'Events List', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'date_style', [
            'label'   => __( 'Date Style', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'classic',
            'options' => [
                'classic'  => __( 'Classic', 'music-pack' ),
                'creative' => __( 'Creative', 'music-pack' ),
            ],
        ] );
        $this->add_control( 'day_opacity', [
            'label'      => __( 'Day Opacity', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.05,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 0.2,
            ],
            'selectors'  => [
                '{{WRAPPER}} .eventlist_day.creative_ev_date' => 'opacity: {{SIZE}};',
            ],
            'condition'  => [
                'date_style' => 'creative',
            ],
        ] );
        $this->add_control( 'separator_panel0', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'left_right_padding', [
            'label'      => __( 'Left/Right Padding', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
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
                'size' => 0,
            ],
            'selectors'  => [
                '{{WRAPPER}} li.single_event_list' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'event_border_radius', [
            'label'      => __( 'Border Radius', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 20,
                    'step' => 1,
                ],
                '%'  => [
                    'min'  => 0,
                    'max'  => 50,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 0,
            ],
            'selectors'  => [
                '{{WRAPPER}} li.single_event_list' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel1', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'separator_color', [
            'label'     => __( 'Separator Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [
                '{{WRAPPER}} li.single_event_list' => 'border-bottom-color: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'separator_width', [
            'label'      => __( 'Separator Width', 'music-pack' ),
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
                'size' => 1,
            ],
            'selectors'  => [
                '{{WRAPPER}} li.single_event_list:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel2', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_responsive_control( 'event_bottom_margin', [
            'label'      => __( 'Gap', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
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
                'size' => 0,
            ],
            'selectors'  => [
                '{{WRAPPER}} li.single_event_list' => 'padding-bottom: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'inactive_btn_color_get_pro', [
            'label'     => __( 'Inactive Button Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'inactive_btn_bg_color_get_pro', [
            'label'     => __( 'Inactive Button Bg Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel4', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'buttons_radius', [
            'label'      => __( 'Buttons Border Radius', 'music-pack' ),
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
                '{{WRAPPER}} .event_buy_btn' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'event_bg_get_pro', [
            'label'     => __( 'Event Bg Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel6_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'day_color_get_pro', [
            'label'     => __( 'Event Day Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'month_color_get_pro', [
            'label'     => __( 'Event Month Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel7_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'event_name_color_get_pro', [
            'label'     => __( 'Event Name Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'event_loc_color_get_pro', [
            'label'     => __( 'Event Location Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel8_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'event_venue_color_get_pro', [
            'label'     => __( 'Event Venue Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'event_time_color_get_pro', [
            'label'     => __( 'Event Time Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'button_txt_color_get_pro', [
            'label'     => __( 'Button Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
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
        $args = MPACK_Utils::get_events_args_for_query( $settings );
        $events_query = new WP_Query();
        $events_query->query( $args );
        $show_year = 'no';
        $show_image = 'no';
        $date_style = ( "classic" == $settings['date_style'] ? "classic_ev_date" : "creative_ev_date" );
        if ( !$events_query->have_posts() ) {
            return;
        }
        $li_css_class = ( "yes" == $show_image ? "single_event_list transition3 clearfix" : "single_event_list no_event_image transition3 clearfix" );
        ?>

		<ul class="events_list vc_events_element">
			<?php 
        while ( $events_query->have_posts() ) {
            $events_query->the_post();
            $post_id = get_the_ID();
            $event_obj = MPACK_Utils::slide_get_event_data_for_list( $post_id );
            $li_css_class .= " " . $this->get_terms_as_slug( $post_id, "event_category" );
            if ( isset( $event_obj['el_month'] ) ) {
                $event_obj['el_month'] = MPACK_Utils::get_translated_month( $event_obj['el_month'] );
            }
            ?>

				<li class="<?php 
            echo esc_attr( $li_css_class );
            ?>" data-evmonth="<?php 
            echo esc_attr( $event_obj['el_month'] );
            ?>">
					<a href="<?php 
            echo get_the_permalink();
            ?>">
						<div class="event_list_entry event_date transition3_color">
							<div class="text_center event_list_date_container">
								<div class="eventlist_day <?php 
            echo esc_attr( $date_style );
            ?>">
									<?php 
            echo esc_html( $event_obj['el_day'] );
            if ( $event_obj['have_multiday_date'] ) {
                echo esc_html( "-" ) . $event_obj['el_end_day'];
            }
            ?>
								</div>
								<div class="eventlist_month <?php 
            echo esc_attr( $date_style );
            ?>"><?php 
            echo esc_html( $event_obj['el_month'] );
            ?></div>
								<?php 
            if ( "yes" == $show_year ) {
                ?>
									<div class="eventlist_year"><?php 
                echo esc_html( $event_obj['el_year'] );
                ?></div>
								<?php 
            }
            ?>
							</div>
						</div>

						<div class="event_list_entry event_title_img clearfix">
							<?php 
            if ( "yes" == $show_image && has_post_thumbnail() ) {
                ?>
								<div class="event_img"> 
									<img src="<?php 
                echo esc_url( get_the_post_thumbnail_url( $post_id, 'medium' ) );
                ?>" alt="<?php 
                echo esc_attr( $event_obj['event_title'] );
                ?>">
								</div>
							<?php 
            }
            ?>
							<div class="evnt_list_title_loc">
								<div class="event_list_title transition3_color"><?php 
            echo esc_html( $event_obj['event_title'] );
            ?></div>
								<div class="event_list_location transition3_color"> <?php 
            echo esc_html( $event_obj['event_location'] );
            ?> </div>
							</div>
						</div>

						<div class="event_list_entry event_venue transition3_color">
							<i class="fas fa-map-marker-alt" aria-hidden="true"></i>
							<?php 
            echo esc_html( $event_obj['event_venue'] );
            ?>
						</div>


						<div class="event_list_entry event_time transition3_color">
							<?php 
            if ( $event_obj['is_event_today'] ) {
                ?>
							<span class="et_today"><?php 
                echo esc_html__( "Today", 'music-pack' );
                ?></span>
							<?php 
            }
            ?>
							<?php 
            if ( $event_obj['is_event_tomorrow'] ) {
                ?>
							<span class="et_today"><?php 
                echo esc_html__( "Tomorrow", 'music-pack' );
                ?></span>
							<?php 
            }
            ?>
							<i class="far fa-clock" aria-hidden="true"></i>
							<?php 
            echo esc_html( $event_obj['output_time'] );
            ?>
						</div>

						<div class="event_list_entry event_buy">
							<?php 
            if ( !empty( $event_obj['event_buy_tickets_message'] ) ) {
                ?>
								<div class="<?php 
                echo esc_attr( $event_obj['tickets_btn_class'] );
                ?>" data-href="<?php 
                echo esc_url( $event_obj['event_buy_tickets_url'] );
                ?>" data-target="<?php 
                echo esc_attr( $event_obj['event_buy_tickets_target'] );
                ?>">
									<?php 
                echo esc_html( $event_obj['tickets_btn_text'] );
                ?>
								</div>
							<?php 
            }
            ?>
						</div>
					</a>
				</li>

			<?php 
        }
        ?>
		</ul>	
	<?php 
    }

    private function get_artist_as_array() {
        $args = array(
            'numberposts'      => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => 'js_artist',
            'post_status'      => 'publish',
            'suppress_filters' => false,
        );
        $result_posts = get_posts( $args );
        $artist_arr = array(
            0 => esc_html__( "All", 'music-pack' ),
        );
        foreach ( $result_posts as $single_post ) {
            $artist_arr[$single_post->ID] = $single_post->post_title;
        }
        return $artist_arr;
    }

    private function get_events_cat_as_array() {
        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 'false',
        );
        $event_categories = get_terms( 'event_category', $cat_args );
        $cat_arr = array(
            0 => esc_html__( "All", 'music-pack' ),
        );
        if ( empty( $event_categories ) ) {
            return $cat_arr;
        }
        foreach ( $event_categories as $cat ) {
            $cat_arr[$cat->term_id] = $cat->name;
        }
        return $cat_arr;
    }

    private function get_terms_as_slug( $post_id, $taxonomy ) {
        $terms = get_the_terms( $post_id, $taxonomy );
        if ( is_wp_error( $terms ) || !$terms ) {
            return "";
        }
        $terms_as_slug = "";
        foreach ( $terms as $term ) {
            $terms_as_slug .= $term->slug . ' ';
        }
        return $terms_as_slug;
    }

}
