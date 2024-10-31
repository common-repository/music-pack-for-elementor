<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Class MPACK_Load_Elementor_Widgets
 *
 * Main MPACK_Load_Elementor_Widgets class
 * @since 1.2.0
 */
class MPACK_Load_Elementor_Widgets {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var MPACK_Load_Elementor_Widgets The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return MPACK_Load_Elementor_Widgets An instance of the class.
	 */
	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    /**
     * Registers required JS files
     * 
     * @since 1.0.0
     * @access public
    */
	public function mpack_frontend_scripts() {
        wp_register_script(
            'mpack-front',
            MPACK_DIR_URL . '/js/mpack-front.js',
            array('jquery', 'imagesloaded'),
            MPACK_VERSION,
            true
        );

		$ajaxurl_val = array(
			'ajaxurl' => admin_url('admin-ajax.php' )
		);
        wp_localize_script('mpack-front', 'DATAVALUES', $ajaxurl_val);
	}

	public function mpack_elementor_editor_scripts() {
		wp_enqueue_style(
			'mpack-elementor-editor',
			MPACK_DIR_URL . 'css/elementor-editor.css',
			array(), 
			MPACK_VERSION
		);
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-single-music-album.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-events-list.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-events-cards.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-event-countdown.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-single-video.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-videos.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-artists.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-review-slider.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-contact-details.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-contact-form.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-albums.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-albums-vinyl.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-latest-releases.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-video-play-btn.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-single-gallery.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-gallery.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/slide-music-player-free.php");

		/*general*/
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-link.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-blog-posts.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-mailchimp-subscribe.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-page-title.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-share-icons.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-blockquote.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-nav-menu.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-subtitle.php");

		require_once(MPACK_DIR_PATH."/classes/widgets/mp-widget-artist-creative.php");

		/*single*/
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-featured-image.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-event-single-details.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-event-single-promo-links.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-event-single-video.php");

		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-album-single-details.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-album-single-promo-links.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-album-single-video.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-album-single-songlist.php");

		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-artist-single-socials.php");
		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-artist-single-website-link.php");

		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-video-single-video.php");

		require_once(MPACK_DIR_PATH."/classes/widgets/single/mp-custom-post-cat.php");
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		/* Its is now safe to include Widgets files */
		$this->include_widgets_files();

		/* Register Widgets */
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Single_Music_Album());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Events_List());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Events_Cards());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Event_Countdown());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Single_Video());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Videos());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Artists());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Review_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Contact_Details());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Contact_Form());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Albums());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Albums_Vinyl());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Latest_Releases());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Video_Play_Button());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Single_Gallery());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Gallery());
		\Elementor\Plugin::instance()->widgets_manager->register(new Widget_Slide_Music_Player_Free());

		/*general*/
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Link());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Blog_Posts());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Mailchimp_Subscribe());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Page_Title());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Share_Icons());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Blockquote());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Nav_Menu());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Subtitle());

		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Widget_Artist_Creative());
		
		/*single*/
		\Elementor\Plugin::instance()->widgets_manager->register(new MP_Featured_Image());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Event_Single_Details());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Event_Single_Promo_Links());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Event_Single_Video());

		\Elementor\Plugin::instance()->widgets_manager->register(new MP_Album_Single_Details());
		\Elementor\Plugin::instance()->widgets_manager->register(new MP_Album_Single_Promo_Links());
		\Elementor\Plugin::instance()->widgets_manager->register(new MP_Album_Single_Video());
		\Elementor\Plugin::instance()->widgets_manager->register(new MP_Album_Single_Songlist());

		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Artist_Single_Socials());
		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Artist_Single_Website_Link());

		\Elementor\Plugin::instance()->widgets_manager->register(new MPACK_Video_Single_Video());

		\Elementor\Plugin::instance()->widgets_manager->register(new MP_Custom_Post_Cat());
	}

	private function include_control_files() {
		require_once(MPACK_DIR_PATH . '/classes/controls/mpfe-audio-chooser.php');
	}

	public function register_controls() {
		$this->include_control_files();
		
		/* Register controls - check if already registered */
		$audio_chooser_control_inst = new \MPFE_Audio_Chooser_Control();
		if (false == \Elementor\Plugin::$instance->controls_manager->get_control($audio_chooser_control_inst->get_type())) {
			\Elementor\Plugin::$instance->controls_manager->register($audio_chooser_control_inst);	
		}
	}

	/**
	 * Add Elementor Widget Categories
	 *
	 * Add widget categories
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_elementor_widget_categories($elements_manager) {
		$elements_manager->add_category(
			'mpack-widgets',
			[
				'title' => __('Music Pack', 'music-pack-for-elementor'),
				'icon' => 'fas fa-music',
			]
		);
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register custom controls
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );		

		// Register widget scripts
		add_action('elementor/frontend/after_register_scripts', array($this, 'mpack_frontend_scripts'));

		//editor scripts
		add_action('elementor/editor/before_enqueue_scripts', array($this, 'mpack_elementor_editor_scripts'));

		// Register widgets
		add_action('elementor/widgets/register', [ $this, 'register_widgets' ]);

		//Add categories
		add_action('elementor/elements/categories_registered', array($this, 'add_elementor_widget_categories'));
	}
}

// Instantiate MPACK_Load_Elementor_Widgets Class
MPACK_Load_Elementor_Widgets::instance();