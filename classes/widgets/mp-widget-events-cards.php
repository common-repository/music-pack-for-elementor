<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Background;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Elementor Music PackEvents Cards Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Events_Cards extends Widget_Base {
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
        return 'events-cards';
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
        return __( 'Events Cards', 'music-pack' );
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
            'events',
            'tour',
            'show',
            'cards'
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
            'label' => __( 'Events Cards', 'music-pack' ),
        ] );
        $this->add_control( 'count', [
            'label'   => __( 'Events Number', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 100,
            'step'    => 1,
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
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_style_get_pro', [
            'label' => __( 'Events Cards', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'name_color_get_pro', [
            'label'     => __( 'Event Name Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'venue_color_get_pro', [
            'label'     => __( 'Event Venue Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'date_color_get_pro', [
            'label'     => __( 'Date Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'date_bg_color_get_pro', [
            'label'     => __( 'Date Background Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
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
        $this->add_control( 'separator_panel_style_get_pro', [
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
        $args = MPACK_Utils::get_events_args_for_query( $settings );
        //$posts = get_posts( $atts );
        $events_query = new WP_Query();
        $events_query->query( $args );
        if ( !$events_query->have_posts() ) {
            return;
        }
        ?>

		<div class="swp_event_cards_container clearfix">
			<?php 
        while ( $events_query->have_posts() ) {
            $events_query->the_post();
            $event_obj = MPACK_Utils::get_event_data( get_the_ID() );
            $cat_css_class = $this->get_terms_as_slug( get_the_ID(), "event_category" );
            ?>

				<div class="swp_event_card lc_swp_background_image swp_custom_ar ar_1910 <?php 
            echo esc_attr( $cat_css_class );
            ?>" data-bgimage="<?php 
            echo esc_attr( $event_obj['post_thumbnail'] );
            ?>">
					<div class="swp_event_card_inner">
						<div class="event_card_overlay transition2"></div>
						<div class="event_card_datails clearfix transition3">
							<div class="event_card_detail event_card_date">
								<div class="event_card_day"> <?php 
            echo esc_html( $event_obj['el_day'] );
            ?> </div>
								<div class="event_card_month"> <?php 
            echo esc_html( $event_obj['el_month'] );
            ?> </div>
							</div>
							<div class="event_card_detail event_card_name_venue">
								<div class="event_card_name">
									<a href="<?php 
            echo get_the_permalink();
            ?>" class="event_card_name_link">
										<?php 
            echo esc_html( $event_obj['event_title'] );
            ?>
									</a>
								</div>
								<div class="event_card_venue"><?php 
            echo esc_html( $event_obj['event_venue'] );
            ?></div>
							</div>
						</div>

						<div class="event_card_buy transition3">
							<?php 
            if ( $event_obj['event_sold_out'] ) {
                echo esc_html__( "Sold Out", 'music-pack' );
            } elseif ( $event_obj['event_canceled'] ) {
                echo esc_html__( "Canceled", 'music-pack' );
            } else {
                ?>
								<a class="event_card_buy_tickets" href="<?php 
                echo esc_attr( esc_url( $event_obj['event_buy_tickets_url'] ) );
                ?>" target="<?php 
                echo esc_attr( $event_obj['event_buy_tickets_target'] );
                ?>">
									<?php 
                echo esc_html( $event_obj['event_buy_tickets_message'] );
                ?>
								</a>
							<?php 
            }
            ?>
						</div>
					</div>
				</div>

			<?php 
        }
        ?>
		</div>
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
            0 => esc_html__( "All", "music-pack" ),
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
            0 => esc_html__( "All", "music-pack" ),
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
