<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

final class MPACK_Load_Music_Pack_For_Elementor {

	private static $instance = null;

	/**
	 * Plugin Version
	 *
	 * @since 1.2.0
	 * @var string The plugin version.
	 */
	const PLUGIN_DOMAIN = 'music-pack-for-elementor';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action('init', array($this, 'init'));
		add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts_and_styles'));
		add_action('wp_enqueue_scripts', array($this, 'load_front_scripts_and_styles'));
		add_action('activated_plugin', array($this, 'mpack_redirect_to_dash'));
		add_filter('plugin_action_links_' . MPACK_BASE, array($this, 'add_action_links'));

		$this->include_files();

		register_activation_hook(MPACK_PLUGIN_FILE, array($this, 'mpack_on_activate'));
		register_deactivation_hook(MPACK_PLUGIN_FILE, array($this, 'mpack_on_deactivate'));

		add_action('admin_notices', array($this, 'mpack_dummy_import_notice'));

		add_action('wp_ajax_mpack_import_template', array($this, 'import_mpack_template'));
		add_action('wp_ajax_mpack_generate_dummy_data', array($this, 'generate_dummy_data'));
		add_action('wp_ajax_mpack_prevent_dummy_import_notice', array($this, 'prevent_dummy_import_notice'));

		add_filter('single_template', array($this, 'load_mp_cpt_single_templates'));
	}

	public function init() {
		$locale = apply_filters('plugin_locale', get_locale(), self::PLUGIN_DOMAIN);
		$trans_location = trailingslashit(WP_LANG_DIR) . "plugins/" . self::PLUGIN_DOMAIN . '-' . $locale . '.mo';
		
		/*wp-content/languages/plugins/music-pack-es_ES.mo*/
		if ($loaded = load_plugin_textdomain(self::PLUGIN_DOMAIN, FALSE, $trans_location)) {
			return $loaded;
		}

		/*music-pack-for-elementor/languages/es_ES.mo*/
		load_plugin_textdomain(self::PLUGIN_DOMAIN, FALSE, MPACK_DIR_PATH . '/languages/');
	}

	public function load_admin_scripts_and_styles() {
		wp_enqueue_style('mpack_admin_style',  MPACK_DIR_URL . '/css/mpack-admin-style.css', array(), MPACK_VERSION);
		wp_enqueue_script('mpack_admin_js',  MPACK_DIR_URL . '/js/mpack-admin.js', array('jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable'), MPACK_VERSION);

		wp_localize_script(
			'mpack_admin_js', 
			'swpvars', 
			array(
				'ajaxurl'	=>	admin_url('admin-ajax.php')
			)
		);
	}

	public function load_front_scripts_and_styles() {
		wp_enqueue_style('mpack_front_style',  MPACK_DIR_URL . '/css/mpack-front-style.css', array(), MPACK_VERSION);
		wp_enqueue_style('font-awesome-5.15.1', MPACK_DIR_URL . '/assets/fontawesome-free-5.15.1/css/all.min.css', array(), '5.15.1', 'all');

		wp_enqueue_script('imagesloaded');
		if (is_singular("js_photo_albums")) {
			wp_enqueue_script('masonry');
			wp_enqueue_script('mpack_single_gallery_js',  MPACK_DIR_URL . '/js/mpack-single-gallery.js', array('jquery', 'masonry', 'imagesloaded'), MPACK_VERSION, true);	
		}
		wp_enqueue_script('lightbox',  MPACK_DIR_URL . '/assets/lightbox2/js/lightbox.js', array('jquery'), MPACK_VERSION, true);
		wp_enqueue_style('lightbox', MPACK_DIR_URL . '/assets/lightbox2/css/lightbox.css');
	}

	private function include_files() {
		require_once(MPACK_DIR_PATH."/classes/core/mpack-check-elementor.php");
		require_once(MPACK_DIR_PATH."/classes/core/mpack-menu-pages.php");
		require_once(MPACK_DIR_PATH."/classes/core/mpack-utils.php");
		require_once(MPACK_DIR_PATH."/classes/core/mp-ajax-handler.php");

		require_once(MPACK_DIR_PATH."/classes/custom-posts/mp-music-album.php");
		require_once(MPACK_DIR_PATH."/classes/custom-posts/mp-event.php");
		require_once(MPACK_DIR_PATH."/classes/custom-posts/mp-photo-album.php");
		require_once(MPACK_DIR_PATH."/classes/custom-posts/mp-artist.php");
		require_once(MPACK_DIR_PATH."/classes/custom-posts/mp-video.php");

		require_once(MPACK_DIR_PATH."/classes/custom-meta/mp-custom-meta.php");

		require_once(MPACK_DIR_PATH."/classes/core/mpack-dummy-generator.php");
	}

	public function mpack_redirect_to_dash($plugin) {
	    if($plugin != 'music-pack-for-elementor/music-pack-for-elementor.php') {
	    	return;
	    }

        wp_safe_redirect(admin_url('admin.php?page=mpack-dashboard'));
        exit;
	}

	public function add_action_links($links) {
		$cust_links = array(
			'<a href="' . admin_url('admin.php?page=mpack-dashboard') . '">How To</a>'
		);

		return array_merge($links, $cust_links);
	}

	public function import_mpack_template() {
		$ret = array();

		if (!isset($_POST['nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'mpack_template_import_action')) {

			$ret['success'] = false;
	    	$ret['message'] = esc_html__('Please refresh the page and try again!', 'music-pack');
	    	echo json_encode($ret);

			exit;
		}

		if (!did_action('elementor/loaded')) {
	    	$ret['success'] = false;
	    	$ret['message'] = esc_html__('Elementor plugin must be installed and active to run the template importer.', 'music-pack');
			
			echo json_encode($ret);
			exit;
		}

		if (null == \Elementor\Plugin::instance()->templates_manager) {
	    	$ret['success'] = false;
	    	$ret['message'] = esc_html__('Could not use the Elementor importer.', 'music-pack');
			
			echo json_encode($ret);
			exit;
		}

		
		$filename = sanitize_file_name($_POST['filename']);
		/*for some reason, the file name have '-' instead of spaces*/
		$filename = str_replace('-', ' ', $filename);
		$filepath = MPACK_DIR_PATH . 'templates/import/' . $filename;

	    $fileContent = file_get_contents($filepath);
	    if (false == $fileContent) {
	    	$ret['success'] = false;
	    	$ret['message'] = esc_html__('Could not load the template file.', 'music-pack');
			
			echo json_encode($ret);
			exit;
	    }

	    $result = \Elementor\Plugin::instance()->templates_manager->import_template( [
	            'fileData' => base64_encode( $fileContent ),
	            'fileName' => $filename,
	        ]
	    );

	    if (is_wp_error($result)) {
	    	$ret['success'] = false;
	    	$ret['message'] = $result->get_error_message();
			
			echo json_encode($ret);
			exit;
	    }

	    if (empty($result) || empty($result[0])) {
			$ret['success'] = false;
			$ret['message'] = 'Importer did not return successfully.';

			echo json_encode($ret);
			exit;
	    }

		$ret['success'] = true;

		echo json_encode($ret);
		exit;
	}

	public static function mpack_on_activate() {
		flush_rewrite_rules();
		self::add_cpt_elementor_support();
		add_option('mpack_already_shown_import_dummy_notice', "no");
	}

	public static function mpack_on_deactivate() {
		flush_rewrite_rules();
	}

	private static function add_cpt_elementor_support() {
		$cpt_support_settings = get_option('elementor_cpt_support');
		$cpt_mp_support = ['js_artist', 'js_events', 'js_albums', 'js_photo_albums', 'js_videos', 'page', 'post'];

		if(!$cpt_support_settings) {
		    $cpt_support_settings = $cpt_mp_support;
		} else {
			foreach ($cpt_mp_support as $cpt_name) {
				if(!in_array($cpt_name, $cpt_support_settings)) {
				    $cpt_support_settings[] = $cpt_name;
				}			
			}
		}

		update_option('elementor_cpt_support', $cpt_support_settings);
	}

	private function has_elementor_content($post_id) {
		if (!did_action('elementor/loaded')) {
			return false;
		}

		return \Elementor\Plugin::$instance->documents->get($post_id)->is_built_with_elementor();
	}

	public function load_mp_cpt_single_templates($template) {
		global $post;

		$supported_cpt = array('js_artist', 'js_events', 'js_albums', 'js_photo_albums', 'js_videos');

		if (!in_array($post->post_type, $supported_cpt)) {
			return $template;
		}

		if ($this->has_elementor_content($post->ID)) {
			return $template;
		}

		$page_template = get_post_meta($post->ID, '_wp_page_template', true);
		if (isset($page_template) && strlen($page_template) && ("default" != $page_template)) {
			return $template;
		}

		switch ($post->post_type) {
		    case "js_albums":
				return MPACK_TEMPLATE_PATH . 'single/single-album.php';
		    case "js_events":
				return MPACK_TEMPLATE_PATH . 'single/single-event.php';
		    case "js_photo_albums":
				return MPACK_TEMPLATE_PATH . 'single/single-photo-album.php';
		    case "js_videos":
				return MPACK_TEMPLATE_PATH . 'single/single-video.php';
		    case "js_artist":
				return MPACK_TEMPLATE_PATH . 'single/single-artist.php';
		    default:
				return $template;
		}		
	}

	public function mpack_dummy_import_notice() {
		$notice_shown = get_option('mpack_already_shown_import_dummy_notice');
		if ("yes" == $notice_shown) {
			return;
		}

		?>

		<div class="swp_notice notice is-dismissible">
			<div class="swp_notice_left">
				<img src="<?php echo  esc_attr(MPACK_DIR_URL . "/img/icon-256x256.png"); ?>">
			</div>
			<div class="swp_notice_right">
				<div class="mpfe_notice_message">
					<div class="mpfe_notice_message_content">
					It looks that you've just installed Music Pack for Elementor Plugins. That's really awesome!<br>
					Let's start by generating some content for your new custom posts: <strong>discography, events, artists and videos</strong>.<br><br>
					Do you want us to automatically generate content for your custom posts?
					</div>
				</div>
				<div class="swp_notice_options">
					<a class="swp_adm_btn swp_notice_option swp_import_dummy_btn" href="">Yes, generate content.</a>
					<a class="swp_adm_btn btn_naked swp_notice_option swp_import_notice_close" href="#">No, I will add them manualy.</a>
				</div>
			</div>
		</div>

		<?php
	}

	public function generate_dummy_data() {
        $dummy_gen = new MPACK_Dummy_Generator();
        $dummy_gen->generate();
        update_option('mpack_already_shown_import_dummy_notice', "yes");
		echo json_encode(array("success"));
    	exit;
	}

	public function prevent_dummy_import_notice() {
		update_option('mpack_already_shown_import_dummy_notice', "yes");
		echo json_encode(array("success"));
    	exit;
	}

    public static function get_instance() {
        if(null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

if (!function_exists('mpack_instance')) {
	/**
	 * Returns an instance of the plugin class.
	 */
	function mpack_instance() {
		return MPACK_Load_Music_Pack_For_Elementor::get_instance(); 
	}
}

mpack_instance();


