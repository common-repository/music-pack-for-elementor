<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
final class MPACK_Menu_Pages {
    public static $defa_event_slug = 'js_events';

    public static $defa_album_slug = 'js_albums';

    public static $defa_artist_slug = 'js_artist';

    public static $defa_video_slug = 'js_videos';

    public static $defa_gallery_slug = 'js_photo_albums';

    public static $defa_event_tax_slug = 'event_category';

    public static $defa_album_tax_slug = 'albums_category';

    public static $defa_artist_tax_slug = 'artist_category';

    public static $defa_video_tax_slug = 'video_category';

    public static $defa_gallery_tax_slug = 'photo_album_category';

    public function __construct() {
        add_action( 'admin_menu', array($this, 'add_plugin_pages') );
        add_action( 'admin_init', array($this, 'mpack_initialize_cpt_slugs_opts') );
        add_action( 'admin_init', array($this, 'mpack_initialize_mc_opts') );
    }

    public function add_plugin_pages() {
        /*top level menu page*/
        add_menu_page(
            esc_html__( "Music Pack", 'music-pack' ),
            esc_html__( "Music Pack", 'music-pack' ),
            "administrator",
            "mpack-dashboard",
            null,
            'dashicons-format-audio',
            2
        );
        /*sub-menu page*/
        add_submenu_page(
            "mpack-dashboard",
            esc_html__( "How to use", 'music-pack' ),
            esc_html__( "How to use", 'music-pack' ),
            "administrator",
            "mpack-dashboard",
            array($this, 'mpack_dashboard_page'),
            1
        );
        add_submenu_page(
            "mpack-dashboard",
            esc_html__( "Import Templates", "music-pack" ),
            esc_html__( "Import Templates", "music-pack" ),
            "administrator",
            "mpack-import",
            array($this, 'mpack_import_page'),
            2
        );
        add_submenu_page(
            "mpack-dashboard",
            esc_html__( "URL Settings", 'music-pack' ),
            esc_html__( "URL Settings", 'music-pack' ),
            "administrator",
            "mpack-cpt-slugs",
            array($this, 'mpack_cpt_slugs_render_opts'),
            3
        );
        add_submenu_page(
            "mpack-dashboard",
            esc_html__( "Widgets Settings", 'music-pack' ),
            esc_html__( "Widgets Settings", 'music-pack' ),
            "administrator",
            "mpack-mailchimp",
            array($this, 'mpack_mailchimp_opts'),
            4
        );
    }

    public function mpack_dashboard_page() {
        ?>
        
        <div class="mpfe_wrap">
            <div class="mpfe_promo_img">
                <img src="<?php 
        echo esc_attr( esc_url( MPACK_DIR_URL . '/img/mp-promo.jpg' ) );
        ?>">
            </div>
            <div class="mpfe_wrap_head">
                <h1>Welcome to Musician's Pack for Elementor!</h1>
            </div>
            <div class="mpfe_welcome mpfe_wrap_block">
                <h4>Congratulations for using a premium designed Elementor addon!</h4>
                We want to make sure that everything is nice and clear for you. Please review the short FAQ below, we promise that it will not take more than one minute.
            </div>

            <div class="mpfe_wrap_block">
                <h4>What is it?</h4>
                <div class="mpfe_wrap_desc">
                    <i>Musician's Pack for Elementor - Widgets and Templates for Musicians</i> is a complete package for musicians, artists, music bands, music producers or anyone working in the music industry. It includes <strong>custom post types for your discography, events, gallery, videos and artists, Elementor widgets and professionally designed Elementor templates</strong>.
                </div>
            </div>

            <div class="mpfe_wrap_block">
                <h4>Do I need a special configuration?</h4>
                <div class="mpfe_wrap_desc">
                    No initial configuration is needed to use the audio player. Just make sure you have the free version of <strong>Elementor plugin installed and active</strong>. 
                </div>
            </div>

            <div class="mpfe_wrap_block">
                <h4 class="vibrant_color">How to use the plugin?</h4>
                <div class="mpfe_wrap_desc">
                    <strong>Please make sure that you add your <a target="_blank" href="<?php 
        echo esc_url( admin_url( 'edit.php?post_type=js_albums' ) );
        ?>">albums</a>, <a target="_blank" href="<?php 
        echo esc_url( admin_url( 'edit.php?post_type=js_events' ) );
        ?>">events</a>, <a target="_blank" href="<?php 
        echo esc_url( admin_url( 'edit.php?post_type=js_photo_albums' ) );
        ?>">gallery</a>, <a target="_blank" href="<?php 
        echo esc_url( admin_url( 'edit.php?post_type=js_artist' ) );
        ?>">artists</a> and <a target="_blank" href="<?php 
        echo esc_url( admin_url( 'edit.php?post_type=js_videos' ) );
        ?>">videos</a> posts from your Dashboard!</strong> This will help you easily manage your data. All the widgets are reading data from your custom posts. <br><br>

                    You can <a href="<?php 
        echo esc_url( admin_url( 'admin.php?page=mpack-import' ) );
        ?>">import</a> one of the ready to use templates and customize the widgets appearance according to your needs, or you can create your layout from scratch, using any of our custom widgets.<br>
                    <strong>Edit any page in Elementor</strong> page builder, search for <strong>"Music Pack"</strong> in the widgets list to see all the available widgets, drag our custom widgets anywhere on your page.

                    <div class="mpfe_img_yt">
                        <a href="https://www.youtube.com/watch?v=BFrUspyUzEM&list=PLL29m3NyLceXIWuhP8ZleCFWCv6dURwqp" target="_blank">
                            <img src="<?php 
        echo esc_attr( esc_url( MPACK_DIR_URL . '/img/YouTubeCover.jpg' ) );
        ?>" class="img_yt">
                        </a>
                    </div>                    
                </div>
            </div>

            <div class="mpfe-header-quick-links">
                <a href="https://wordpress.org/support/plugin/music-pack-for-elementor/" class="button helper-quick-link  button-primary" target="_blank">
                    Report a problem            </a>
                <a href="https://wordpress.org/support/plugin/music-pack-for-elementor/" class="button helper-quick-link  button-primary" target="_blank">
                    Suggest a feature           </a>
                <a href="https://smartwpress.ticksy.com/submit/#100021040" class="button helper-quick-link  button-primary" target="_blank">
                    Open a support ticket (PRO)</a>
            </div>
        </div>

        <?php 
        ?>
        <div class="mpfe_wrap_block wpfe_promo">
            <div class="mpfe_icon_pro text_center">
                <img src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/icon-256x256.png" );
        ?>">
            </div>
            <div class="mpfe_wrap_desc text_center">
                <a href="<?php 
        echo esc_url( admin_url( 'admin.php?page=mpack-dashboard-pricing' ) );
        ?>" class="mpfe_go_pro vibrant_color">GO PRO</a> and create a professionally designed musician website, <u>unlocking the full potential</u> of Music Pack for Elementor plugin.
            </div>
            <div class="mpfe_wrap_desc pro_features">
                <div class="single_feat">
                    <span><img class="checked" src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/checked.png" );
        ?>"></span>
                    <strong>Professionally designed Elementor templates</strong>
                </div>                
                <div class="single_feat">
                    <span><img class="checked" src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/checked.png" );
        ?>"></span>
                    <strong>Unlimited colors and fonts</strong> options
                </div>
                <div class="single_feat">
                    <span><img class="checked" src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/checked.png" );
        ?>"></span>
                    <strong>Events Cards</strong> widget with complete options
                </div>
                <div class="single_feat">
                    <span><img class="checked" src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/checked.png" );
        ?>"></span>
                    <strong>Events List</strong> widget with complete options
                </div>
                <div class="single_feat">
                    <span><img class="checked" src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/checked.png" );
        ?>"></span>
                    <strong>Event Countdown</strong> widget with complete options
                </div>
                <div class="single_feat">
                    <span><img class="checked" src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/checked.png" );
        ?>"></span>
                    <strong>Additional styling options</strong>  for all widgets
                </div>
                <div class="single_feat">
                    <span><img class="checked" src="<?php 
        echo esc_attr( MPACK_DIR_URL . "/img/checked.png" );
        ?>"></span>
                    Priority <a href="https://smartwpress.ticksy.com/submit/#100021040" target="_blank"><strong>technical support</strong></a> on our ticketing system
                </div>
            </div>
            <div class="text_center">
                <a href="<?php 
        echo esc_url( admin_url( 'admin.php?page=mpack-dashboard-pricing' ) );
        ?>" class="mpfe_adm_btn">PLANS & FEATURES (starting at $29.99/year)</a>
            </div>
            
            <?php 
        if ( !mpack_fs()->can_use_premium_code() ) {
            ?>
            <div class="text_center mpfe_trial_test">
                Not ready to buy? <a href="<?php 
            echo esc_url( mpack_fs()->get_trial_url() );
            ?>">Test all our premium features</a> with a 7-day free trial. <span style="text-decoration: underline;">No credit-card, risk free!</span>
            </div>
            <?php 
        }
        ?>
        </div>
        <?php 
        ?>

        <?php 
    }

    public function mpack_import_page() {
        $templates = json_decode( MPACK_Utils::get_available_templates() );
        $img_path = MPACK_DIR_URL . 'img/templates/';
        ?>
        <div class="mpfe_wrap_templates">
            <h1 class="mpfe_import_head"><?php 
        echo esc_html__( 'Import Musician Templates', 'music-pack' );
        ?></h1>
            <div class="mpfe_import_messages">
                <div class="mpfe_import_notice mpfe_import_success">
                    <?php 
        echo esc_html__( 'Template imported successfully! You can find it under My Templates/Saved Templates and you can insert it anywhere with Elementor editor.', 'music-pack' );
        ?>
                    <a href="https://elementor.com/help/adding-templates/" target="_blank"><?php 
        echo esc_html__( "See how to insert a template in Elementor." );
        ?></a>
                    <br>
                </div>
                <div class="mpfe_import_notice mpfe_import_failed">
                    <?php 
        echo esc_html__( 'Sorry, we could not import the template. Please contact Music Pack for Elementor support team!', 'music-pack' );
        ?>
                </div>
            </div>


            <div class="templ_tags">
                <div class="single_templ_tag active_tag" data-name="all">
                    <?php 
        echo esc_html( "All" );
        ?>
                </div>
            <?php 
        $available_tags = array(
            'landing',
            'events',
            'discography',
            'vinyl',
            'about',
            'footer',
            'hero',
            'player',
            'bright',
            'dark',
            'artist',
            'blog',
            'contact',
            'creative',
            'gallery',
            'timer',
            'vibrant',
            'newsletter',
            'testimonial',
            'video'
        );
        foreach ( $available_tags as $single_tag ) {
            ?>
                <div class="single_templ_tag" data-name="<?php 
            echo esc_attr( $single_tag );
            ?>">
                    <?php 
            echo esc_html( $single_tag );
            ?>
                </div>
            <?php 
        }
        ?>
            </div>

            <div class="mpfe_player_templates">
                <?php 
        $templates_no = count( $templates );
        foreach ( $templates as $index => $template ) {
            ?>
                    <?php 
            $template = get_object_vars( $template );
            $is_available = ( 0 == $template['available'] ? false : true );
            $cta = ( $is_available ? "IMPORT TEMPLATE" : "GET PRO" );
            $cta_css = ( $is_available ? "mpack_cta_text import_available" : "mpack_cta_text import_pro" );
            $container_class = str_replace( ',', ' ', $template['tags'] );
            ?>
                        <div class="mpfe_templ_container <?php 
            echo esc_attr( $container_class );
            ?>">
                            <img src="<?php 
            echo esc_attr( esc_url( $img_path . $template['img'] ) );
            ?>">
                            <div class="mpfe_import_overlay">
                                <div class="<?php 
            echo esc_attr( $cta_css );
            ?>" data-file="<?php 
            echo esc_attr( $template['file'] );
            ?>">
                                    <?php 
            if ( $is_available ) {
                echo esc_html( $cta );
            } else {
                ?>
                                        <a class="cta_templ_buy" href="<?php 
                echo esc_url( admin_url( 'admin.php?page=mpack-dashboard-pricing' ) );
                ?>"><?php 
                echo esc_html( $cta );
                ?></a>
                                        <a class="cta_templ_buy" href="<?php 
                echo esc_url( admin_url( 'admin.php?page=billing_cycle=annual&trial=true&page=mpack-dashboard-pricing' ) );
                ?>"><?php 
                echo esc_html( 'TRY FOR FREE', 'music-pack' );
                ?></a>
                                    <?php 
            }
            ?>
                                </div>
                                <div class="mpfe_importing">
                                    <?php 
            echo esc_html__( 'Please wait...', 'music-pack' );
            ?>
                                </div>
                            </div>
                            <div class="mp_templ_name">
                                <?php 
            echo esc_html( $template['name'] );
            ?>
                            </div>
                        </div>
                <?php 
        }
        ?>
                <?php 
        wp_nonce_field( 'mpack_template_import_action', 'mpack_template_import_nonce' );
        ?>
            </div>
        </div>
        <?php 
    }

    public function mpack_mailchimp_opts() {
        ?>
        <div class="wrap">
            <?php 
        settings_errors();
        ?>

            <form method="post" action="options.php">
                <?php 
        settings_fields( 'mpack_mc_options' );
        do_settings_sections( 'mpack-mailchimp' );
        submit_button();
        ?>
            </form>
        </div>
        <?php 
    }

    public function mpack_cpt_slugs_render_opts() {
        ?>
        <div class="wrap">
            <?php 
        settings_errors();
        ?>

            <form method="post" action="options.php">
                <?php 
        settings_fields( 'mpack_cpt_slug_options' );
        do_settings_sections( 'mpack-cpt-slugs' );
        submit_button();
        ?>
            </form>
        </div>
        <?php 
        flush_rewrite_rules();
    }

    public function mpack_initialize_mc_opts() {
        if ( false == get_option( 'mpack_mc_options' ) ) {
            add_option( 'mpack_mc_options' );
        }
        add_settings_section(
            'mpack_mc_section',
            /*ID used to identify this section and with which to register options*/
            esc_html__( 'Widgets Settings', 'music-pack' ),
            /*title on the administration page*/
            array($this, 'cpt_mc_sett_desc'),
            /* callback used to render the description of the section */
            'mpack-mailchimp'
        );
        register_setting( 
            'mpack_mc_options',
            /*option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()*/
            'mpack_mc_options',
            /*option_name -  The name of an option to sanitize and save. */
            array($this, 'mpack_sanitize_mc_slug_options')
         );
        add_settings_field(
            'mpack_mc_api_key',
            esc_html__( 'MailChimp API Key', 'music-pack' ),
            array($this, 'mpack_mc_api_key_cbk'),
            'mpack-mailchimp',
            'mpack_mc_section'
        );
        add_settings_field(
            'mpack_mc_list_id',
            esc_html__( 'MailChimp List/Audience ID', 'music-pack' ),
            array($this, 'mpack_mc_list_id_cbk'),
            'mpack-mailchimp',
            'mpack_mc_section'
        );
        add_settings_field(
            'mpack_contact_form_email',
            esc_html__( 'Contact Form Recipient Email', 'music-pack' ),
            array($this, 'mpack_mpack_contact_form_email_cbk'),
            'mpack-mailchimp',
            'mpack_mc_section'
        );
    }

    public function mpack_mc_api_key_cbk() {
        $this->render_input_for_slug( 'mpack_mc_api_key', '', 'mpack_mc_options' );
    }

    public function mpack_mc_list_id_cbk() {
        $this->render_input_for_slug( 'mpack_mc_list_id', '', 'mpack_mc_options' );
    }

    public function mpack_mpack_contact_form_email_cbk() {
        $this->render_input_for_slug( 'mpack_contact_form_email', '', 'mpack_mc_options' );
    }

    public function cpt_mc_sett_desc() {
        echo esc_html__( 'Please insert your MailChimp API KEY and list ID for the MailChimp Subscribe widget and the recipient email address for the contact form widget.' );
    }

    public function mpack_initialize_cpt_slugs_opts() {
        /*create plugin options*/
        if ( false == get_option( 'mpack_cpt_slug_options' ) ) {
            add_option( 'mpack_cpt_slug_options' );
        }
        /*create setting section*/
        add_settings_section(
            'mpack_slug_section',
            /*ID used to identify this section and with which to register options*/
            esc_html__( 'Music Pack URL Settings', 'music-pack' ),
            /*title on the administration page*/
            array($this, 'cpt_slug_desc'),
            /* callback used to render the description of the section */
            'mpack-cpt-slugs'
        );
        register_setting( 
            'mpack_cpt_slug_options',
            /*option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()*/
            'mpack_cpt_slug_options',
            /*option_name -  The name of an option to sanitize and save. */
            array($this, 'mpack_sanitize_cpt_slug_options')
         );
        /*settings fields - custom post types*/
        add_settings_field(
            'mpack_events_slug',
            esc_html__( 'Event Slug', 'music-pack' ),
            array($this, 'mpack_event_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_albums_slug',
            esc_html__( 'Discography Slug', 'music-pack' ),
            array($this, 'mpack_album_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_artists_slug',
            esc_html__( 'Artist Slug', 'music-pack' ),
            array($this, 'mpack_artist_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_videos_slug',
            esc_html__( 'Video Slug', 'music-pack' ),
            array($this, 'mpack_video_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_gallery_slug',
            esc_html__( 'Gallery Slug', 'music-pack' ),
            array($this, 'mpack_gallery_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        /*settings fields - custom taxonomies*/
        add_settings_field(
            'mpack_event_tax_slug',
            esc_html__( 'Event Category Slug', 'music-pack' ),
            array($this, 'mpack_event_tax_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_album_tax_slug',
            esc_html__( 'Album Category Slug', 'music-pack' ),
            array($this, 'mpack_album_tax_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_artist_tax_slug',
            esc_html__( 'Artist Category Slug', 'music-pack' ),
            array($this, 'mpack_artist_tax_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_video_tax_slug',
            esc_html__( 'Video Category Slug', 'music-pack' ),
            array($this, 'mpack_video_tax_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
        add_settings_field(
            'mpack_gallery_tax_slug',
            esc_html__( 'Gallery Category Slug', 'music-pack' ),
            array($this, 'mpack_gallery_tax_slug_setting_cbk'),
            'mpack-cpt-slugs',
            'mpack_slug_section'
        );
    }

    public function mpack_event_tax_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_event_tax_slug', self::$defa_event_tax_slug );
    }

    public function mpack_album_tax_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_album_tax_slug', self::$defa_album_tax_slug );
    }

    public function mpack_artist_tax_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_artist_tax_slug', self::$defa_artist_tax_slug );
    }

    public function mpack_video_tax_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_video_tax_slug', self::$defa_video_tax_slug );
    }

    public function mpack_gallery_tax_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_gallery_tax_slug', self::$defa_gallery_tax_slug );
    }

    public function mpack_album_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_albums_slug', self::$defa_album_slug );
    }

    public function mpack_event_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_events_slug', self::$defa_event_slug );
    }

    public function mpack_artist_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_artists_slug', self::$defa_artist_slug );
    }

    public function mpack_video_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_videos_slug', self::$defa_video_slug );
    }

    public function mpack_gallery_slug_setting_cbk() {
        $this->render_input_for_slug( 'mpack_gallery_slug', self::$defa_gallery_slug );
    }

    private function render_input_for_slug( $setting_name, $defa_val, $option_name = 'mpack_cpt_slug_options' ) {
        $options = get_option( $option_name );
        $slug = ( isset( $options[$setting_name] ) ? $options[$setting_name] : $defa_val );
        $input_name = $option_name . '[' . esc_attr( $setting_name ) . ']';
        ?>

        <input type="text" size="50 id="<?php 
        echo esc_attr( $setting_name );
        ?>" name="<?php 
        echo esc_attr( $input_name );
        ?>" value="<?php 
        echo esc_attr( $slug );
        ?>" />

        <?php 
    }

    public static function get_slug_from_settings( $cpt_or_tax_name ) {
        if ( !strlen( $cpt_or_tax_name ) ) {
            return "";
        }
        $setting_name = self::get_setting_name_from_ctp_tax_name( $cpt_or_tax_name );
        $defa_val = self::get_defa_val_from_cpt_tax_name( $cpt_or_tax_name );
        $options = get_option( 'mpack_cpt_slug_options' );
        return ( isset( $options[$setting_name] ) ? $options[$setting_name] : $defa_val );
    }

    public static function get_mc_api_key() {
        $options = get_option( 'mpack_mc_options' );
        return ( isset( $options['mpack_mc_api_key'] ) ? $options['mpack_mc_api_key'] : '' );
    }

    public static function get_mc_list_id() {
        $options = get_option( 'mpack_mc_options' );
        return ( isset( $options['mpack_mc_list_id'] ) ? $options['mpack_mc_list_id'] : '' );
    }

    public static function get_recipient_email() {
        $options = get_option( 'mpack_mc_options' );
        $cf_email = ( isset( $options['mpack_contact_form_email'] ) ? $options['mpack_contact_form_email'] : '' );
        if ( "" == $cf_email ) {
            $cf_email = get_option( "admin_email" );
        }
        return $cf_email;
    }

    private static function get_setting_name_from_ctp_tax_name( $cpt_or_tax_name ) {
        switch ( $cpt_or_tax_name ) {
            case "js_photo_albums":
                return "mpack_gallery_slug";
            case "js_videos":
                return "mpack_videos_slug";
            case "js_artist":
                return "mpack_artists_slug";
            case "js_albums":
                return "mpack_albums_slug";
            case "js_events":
                return "mpack_events_slug";
            case "photo_album_category":
                return "mpack_gallery_tax_slug";
            case "video_category":
                return "mpack_video_tax_slug";
            case "artist_category":
                return "mpack_artist_tax_slug";
            case "album_category":
                return "mpack_album_tax_slug";
            case "event_category":
                return "mpack_event_tax_slug";
            default:
                return "";
        }
    }

    private static function get_defa_val_from_cpt_tax_name( $cpt_or_tax_name ) {
        switch ( $cpt_or_tax_name ) {
            case "js_photo_albums":
                return self::$defa_gallery_slug;
            case "js_videos":
                return self::$defa_video_slug;
            case "js_artist":
                return self::$defa_artist_slug;
            case "js_albums":
                return self::$defa_album_slug;
            case "js_events":
                return self::$defa_event_slug;
            case "photo_album_category":
                return self::$defa_gallery_tax_slug;
            case "video_category":
                return self::$defa_video_tax_slug;
            case "artist_category":
                return self::$defa_artist_tax_slug;
            case "albums_category":
                return self::$defa_album_tax_slug;
            case "event_category":
                return self::$defa_event_tax_slug;
            default:
                return "";
        }
    }

    public function cpt_slug_desc() {
        echo esc_html__( 'Set up the URL/permalink slugs for your custom post types' );
    }

    public function mpack_sanitize_cpt_slug_options( $inputOptions ) {
        $output = array();
        foreach ( $inputOptions as $key => $val ) {
            if ( isset( $inputOptions[$key] ) ) {
                $output[$key] = sanitize_title( trim( $inputOptions[$key] ) );
            }
        }
        return apply_filters( 'mpack_sanitize_cpt_slug_options', $output, $inputOptions );
    }

    public function mpack_sanitize_mc_slug_options( $inputOptions ) {
        $output = array();
        foreach ( $inputOptions as $key => $val ) {
            if ( isset( $inputOptions[$key] ) ) {
                if ( "mpack_contact_form_email" == $key ) {
                    $output[$key] = sanitize_email( trim( $inputOptions[$key] ) );
                } else {
                    $output[$key] = sanitize_key( trim( $inputOptions[$key] ) );
                }
            }
        }
        return apply_filters( 'mpack_sanitize_mc_slug_options', $output, $inputOptions );
    }

}

if ( is_admin() ) {
    $mpfe_menu_pages = new MPACK_Menu_Pages();
}