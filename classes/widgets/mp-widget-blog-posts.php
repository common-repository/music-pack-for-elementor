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
 * Elementor Blog Posts Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Blog_Posts extends Widget_Base {
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
        return 'mp-blog-posts';
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
        return __( 'Blog Posts', 'music-pack' );
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
            'blog',
            'posts',
            'articles'
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
            'label' => __( 'Blog Posts', 'music-pack' ),
        ] );
        $this->add_control( 'posts_no', [
            'label'   => __( 'Posts No', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 100,
            'step'    => 1,
            'default' => 3,
        ] );
        $this->add_control( 'post_cat', [
            'label'   => __( 'Post Category:', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '0',
            'options' => $this->get_post_cat_as_array(),
        ] );
        $this->add_control( 'user_excerpt_length', [
            'label'   => __( 'Excerpt Length', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 30,
            'step'    => 1,
            'default' => 17,
        ] );
        $this->add_control( 'gap_width', [
            'label'   => __( 'Gap Width', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 80,
            'step'    => 1,
            'default' => 50,
        ] );
        $this->add_control( 'show_post_thumbnails', [
            'label'        => __( 'Show Thumbnails', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Show', 'music-pack' ),
            'label_off'    => __( 'Hide', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'show_post_cat', [
            'label'        => __( 'Show Categories', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Show', 'music-pack' ),
            'label_off'    => __( 'Hide', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'no',
        ] );
        $this->add_control( 'show_dates', [
            'label'        => __( 'Show Dates', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Show', 'music-pack' ),
            'label_off'    => __( 'Hide', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->end_controls_section();
        /*STYLE SECTION*/
        $this->start_controls_section( 'section_title_style', [
            'label' => __( 'Blog Posts', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'meta_color_get_pro', [
            'label'     => __( 'Meta Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Meta Typography', 'music-pack' ),
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
        $this->add_control( 'title_color_get_pro', [
            'label'     => __( 'Title Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Title Typography', 'music-pack' ),
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_2_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'content_color_get_pro', [
            'label'     => __( 'Content Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Content Typography', 'music-pack' ),
            'name'     => 'typography3_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_3_1_get_pro', [
            'type'      => Controls_Manager::DIVIDER,
            'style'     => 'thick',
            'condition' => [
                'show_post_cat' => 'yes',
            ],
        ] );
        $this->add_control( 'cats_color_get_pro', [
            'label'     => __( 'Categories Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'condition' => [
                'show_post_cat' => 'yes',
            ],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_3', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'readmore_color_get_pro', [
            'label'     => __( 'Read More Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'readmore_hov_color_get_pro', [
            'label'     => __( 'Read More Hover Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
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
        $args = MPACK_Utils::get_posts_args( $settings['posts_no'], $settings['post_cat'] );
        $posts_elt_query = new WP_Query();
        $posts_elt_query->query( $args );
        if ( !$posts_elt_query->have_posts() ) {
            return;
        }
        $show_post_thumbnails = ( "yes" == $settings['show_post_thumbnails'] ? true : false );
        $show_post_cat = ( "yes" == $settings['show_post_cat'] ? true : false );
        $center_css_class = "text_left";
        $container_class = 'lc_blog_masonry_container blog_container swp_blog_scd_container';
        $gap_width = $settings['gap_width'];
        $bricks_on_row = 3;
        ?>

		<div class="<?php 
        echo esc_attr( $container_class );
        ?>" data-gapwidth="<?php 
        echo esc_attr( $gap_width );
        ?>" data-bricksonrow="<?php 
        echo esc_attr( $bricks_on_row );
        ?>">
			<?php 
        while ( $posts_elt_query->have_posts() ) {
            $posts_elt_query->the_post();
            $thumbnail_class = ( has_post_thumbnail() ? 'has_thumbnail' : 'no_thumbnail' );
            $post_classes = 'post_item lc_blog_masonry_brick ' . $thumbnail_class;
            $masonry_excerpt_length = $settings['user_excerpt_length'];
            ?>
				<article <?php 
            post_class( $post_classes );
            ?>>
					<?php 
            if ( $show_post_thumbnails && has_post_thumbnail() ) {
                ?>
						<a href="<?php 
                the_permalink();
                ?>">
							<?php 
                the_post_thumbnail( 'full', array(
                    'class' => 'lc_masonry_thumbnail_image mp_blog_featured_image',
                ) );
                ?>
						</a>
					<?php 
            }
            ?>

					<div class="post_item_details <?php 
            echo esc_attr( $thumbnail_class );
            ?>">
						<?php 
            if ( $show_post_cat ) {
                ?>
							<div class="swp_blog_widget_cats">
								<?php 
                the_terms(
                    '',
                    'category',
                    '',
                    '&nbsp;',
                    ''
                );
                ?>
							</div>
						<?php 
            }
            ?>

						<?php 
            if ( "yes" == $settings['show_dates'] ) {
                ?>
						<div class="post_item_meta lc_post_meta masonry_post_meta lc_vibrant_color">
							<?php 
                echo get_the_date( get_option( 'date_format' ) );
                ?>
						</div>
						<?php 
            }
            ?>

						<a href="<?php 
            the_permalink();
            ?>">
							<h2 class="lc_post_title transition4 masonry_post_title">
								<?php 
            the_title();
            ?>
							</h2>
						</a>

						<div class="lc_post_excerpt masonry_excerpt">
							<?php 
            $default_excerpt = get_the_excerpt();
            echo "<p>" . wp_trim_words( $default_excerpt, $masonry_excerpt_length ) . "</p>";
            ?>
						</div>

						<div class="masonry_read_more swp_slide_link">
							<a href="<?php 
            the_permalink();
            ?>" class="masonry_read_more">
								<?php 
            echo esc_html__( "Read more", 'music-pack' );
            ?>
								<span class="swp_before_right_arrow transition4"></span><span class="swp_arrow swp_arrow_right"></span>
							</a>
						</div>
					</div>
				</article>
				<?php 
        }
        ?>
		</div>

		<?php 
    }

    private function get_post_cat_as_array() {
        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 'false',
        );
        $post_categories = get_terms( 'category', $cat_args );
        /*default*/
        $cat_arr = array(
            0 => esc_html__( "All", "music-pack" ),
        );
        if ( empty( $post_categories ) ) {
            return $cat_arr;
        }
        foreach ( $post_categories as $cat ) {
            $cat_arr[$cat->term_id] = $cat->name;
        }
        return $cat_arr;
    }

}
