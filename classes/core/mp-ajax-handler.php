<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Ajax_Handler {
	private static $_instance = null;

	public function __construct() {
		add_action( 'wp_ajax_swpmcform_action', [ $this, 'ajax_mailchimp_form' ]);
		add_action( 'wp_ajax_nopriv_swpmcform_action', [ $this, 'ajax_mailchimp_form' ]);

		add_action('wp_ajax_swpcontactform_action', [$this, 'mp_process_contact_form']);
		add_action('wp_ajax_nopriv_swpcontactform_action', [$this, 'mp_process_contact_form']);

	}

	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function mp_process_contact_form() {
		$ret['success'] = false;

		if (!isset($_POST['data']['mpack_cf_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['data']['mpack_cf_nonce'])), 'swpcontactform_action')) {
			
			$ret['error'] = esc_html__('Please refresh the page and try again.', 'music-pack');
			echo json_encode($ret);	
		
			die();		
		}
		
		$namedError = '';
		if (sanitize_text_field($_POST['data']['contactName']) === '') {
			$hasError = true;
			$namedError = esc_html__('Please eneter a valid name', 'slide');
		} else {
			$name = sanitize_text_field($_POST['data']['contactName']);
		}

		if (trim($_POST['data']['email']) === '') {
			$hasError = true;
			$namedError = esc_html__('Your email address cannot be empty', 'slide');
		} else {
			if ((!is_email($_POST['data']['email']))) {
				$hasError = true;
				$namedError = esc_html__('Email address is not correct, please enter a valid email address', 'slide');
			} 
			else {
				$email = sanitize_email(trim($_POST['data']['email']));
			}
		}
		
		if(sanitize_text_field($_POST['data']['comments']) === '') {
			$hasError = true;
			$namedError = esc_html__('Please enter a message.', 'slide');;
		}
		else {
			$comments = sanitize_text_field($_POST['data']['comments']);
		}

		if(!isset($hasError)) {
			$emailTo = MPACK_Menu_Pages::get_recipient_email();

			$email_subject = sanitize_text_field($_POST['data']['swp_cf_subject']);
			if (!strlen($email_subject)) {
				$email_subject = esc_html__("New contact form message from your website ", 'slide')."[" . get_bloginfo('name') . "] ";
			}

			$email_message = $comments;
			$email_message .= "\n\n".esc_html__("Sender Email: ", 'slide')." ".$email."\n";
			$email_message .= "\n\n".esc_html__("Sender Name: ", 'slide')." ".$name."\n";
			
			/* e-mail headers with the user's name, e-mail address and character encoding*/
			$headers = "MIME-Version: 1.0\r\n" .
			"Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\r\n".
			"Reply-To: ".$name." <".$email.">\"\r\n";

			if (!wp_mail($emailTo, $email_subject, $email_message, $headers)) {
				$namedError = 'wp_mail_failed';
			} else {
				$ret['success'] = true;	
			}
		} 
		
		$ret['error'] = $namedError;
		echo json_encode($ret);	
		
		die();
	}

	public function ajax_mailchimp_form() {
		$ret['success'] = false;

		if (!isset($_POST['data']['mpack_subform_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['data']['mpack_subform_nonce'])), 'swpmcform_action')) {
			
			$ret['error'] = esc_html__('Please refresh the page and try again.', 'music-pack');
			echo json_encode($ret);	

			die();		
		}
		
		$list_id = MPACK_Menu_Pages::get_mc_list_id();
		$api_key = MPACK_Menu_Pages::get_mc_api_key();

		if (!strlen($list_id) || !strlen($api_key)) {
			$ret['success'] = false;
			$ret['error'] = esc_html__('A problem occurred, could not register your email.', 'music-pack');
			echo json_encode($ret);
			die();
		}

		require_once(MPACK_DIR_PATH . "/assets/mailchimp/MailChimp.php");
		$MPACK_MailChimpInst = new MPACK_MailChimp($api_key);
		
		$mc_merge_fields = array(
			'FNAME'=> '', 
			'LNAME'=> ''
			);
		$mc_opts = array(
				'email_address' => sanitize_email($_POST['data']["newsletter_email"]),
                'merge_fields'  => $mc_merge_fields,
                'status'        => 'subscribed'
			);
		$result = $MPACK_MailChimpInst->post("lists/$list_id/members", $mc_opts);


		$namedError = '';
		if ($MPACK_MailChimpInst->success()) {
			$ret['success'] = true;
		} else {
			$namedError = $MPACK_MailChimpInst->getLastError();
		}

		$ret['error'] = $namedError;
		echo json_encode($ret);	

		die();
	}
}

MPACK_Ajax_Handler::instance();