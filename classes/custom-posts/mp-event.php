<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Event {
	public function __construct() {
		add_action('init', array($this, 'create_event_post'));
		add_action('admin_init', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'mp_save_event_fields'), 10, 2);

		add_filter('manage_edit-js_events_columns', array($this, 'mc_custom_event_cols'));
		add_action('manage_js_events_posts_custom_column', array($this, 'mc_manage_event_cols'), 10, 2);
		add_filter('manage_edit-js_events_sortable_columns', array($this, 'mc_event_sortable_cols'));
		add_filter('request', array($this, 'mc_event_cols_order_by'));

		add_action('init', array($this, 'mp_create_event_category'), 11);
	}

	public function create_event_post() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("js_events");

		if (!strlen($slug)) {
			$slug = "js_events";
		}

		register_post_type('js_events',
			array(
				'labels' => array(
					'name' =>  esc_html__('Events', 'music-pack') ,
					'singular_name' =>  esc_html__('Events', 'music-pack') ,
					'add_new' => esc_html__('Add New Event', 'music-pack'),
					'add_new_item' => esc_html__('Add New Event', 'music-pack'),
					'edit' => esc_html__('Edit', 'music-pack'),
					'edit_item' => esc_html__('Edit Event', 'music-pack'),
					'new_item' => esc_html__('New Event', 'music-pack'),
					'view' => esc_html__('View', 'music-pack'),
					'view_item' => esc_html__('View Event', 'music-pack'),
					'search_items' => esc_html__('Search Events', 'music-pack'),
					'not_found' => esc_html__('No Event Found','music-pack'),
					'not_found_in_trash' => esc_html__('No Event Found in Trash','music-pack'),
					'parent' => esc_html__('Parent Event','music-pack')
				),
			'public' => true,
			'rewrite' => array(
				'slug' => $slug,
				'with_front' => false
				),		
			'supports' => array('title', 'editor', 'comments', 'thumbnail', 'author'),
			'menu_icon' => 'dashicons-calendar',
			)
		);
	}

	public function add_meta_boxes() {
	    add_meta_box(
	    	'events_meta_box',
	        esc_html__('Event Settings','music-pack'),
	        array($this, 'mp_render_event_meta'),
	        'js_events',
			'normal',
			'high'
		);
	}

	public function mp_render_event_meta($eventObject) {
		$event_ID = $eventObject->ID;

	    /* Retrieve current name of the custom fields album ID */
	    $event_date = esc_html(get_post_meta($event_ID, 'event_date', true));
		$event_time = esc_html(get_post_meta($event_ID, 'event_time', true));
		$event_venue = esc_html(get_post_meta($event_ID, 'event_venue', true));
		$event_venue_url = esc_url(get_post_meta($event_ID, 'event_venue_url', true));	
		$event_location = esc_html(get_post_meta($event_ID, 'event_location', true));	
		$event_buy_tickets_message = esc_html(get_post_meta($event_ID, 'event_buy_tickets_message', true));		
		$event_buy_tickets_url = esc_url(get_post_meta($event_ID, 'event_buy_tickets_url', true));			
		$event_fb_message = esc_html(get_post_meta($event_ID, 'event_fb_message', true));
		$event_fb_url  = esc_url(get_post_meta($event_ID, 'event_fb_url', true));

		$event_youtube_url  = esc_url(get_post_meta($event_ID, 'event_youtube_url', true));	
		$event_vimeo_url  = esc_url(get_post_meta($event_ID, 'event_vimeo_url', true));

		$event_multiday = esc_html(get_post_meta($event_ID, 'event_multiday', true));
		$event_end_date = esc_html(get_post_meta($event_ID, 'event_end_date', true));

		/*event canceled and sold out*/
		$event_canceled	 = esc_html(get_post_meta($event_ID, 'event_canceled', true));
		$event_sold_out	 = esc_html(get_post_meta($event_ID, 'event_sold_out', true));
		
		/*venue target*/
		$event_venue_target = esc_html(get_post_meta($event_ID, 'event_venue_target', true));
		if (empty($event_venue_target)) {
			$event_venue_target = "_self";
		}

		/*buy tickets target*/
		$event_buy_tickets_target = esc_html(get_post_meta($event_ID, 'event_buy_tickets_target', true));
		if (empty($event_buy_tickets_target)) {
			$event_buy_tickets_target = "_self";
		}

		$link_target_opts  = array(
			esc_html__('Same Browser Window', 'music-pack')	=> '_self',
			esc_html__('New Browser Tab', 'music-pack')	=> '_blank'
		);
		?>

	    <table style= "width: 100%;">
	       <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Event Date','music-pack');?></td>
				<td ><input class="swp_datepicker event_date_input mp_setting_input" type="text" name="event_date" value="<?php echo esc_attr($event_date); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('The Date for Event YYYY/MM/DD','music-pack'); ?></div>
				</td>
	        </tr>	
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Event Time','music-pack');?></td>
	            <td ><input id="timepicker" class="mp_setting_input" type="text" name="event_time" value="<?php echo esc_attr($event_time); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Event Time hh:mm','music-pack'); ?></div>
				</td>
	        </tr>
	        <tr>
	        	<td class="mp_setting_label_td"><?php echo esc_html__('Multi-Day Event','music-pack');?></td>
	        	<td>
	        		<input name="event_multiday" class="event_multiday_check" type="checkbox" value="1" <?php checked("1", $event_multiday); ?>>
	        		<div class="mp_setting_desc"><?php echo esc_html__('Check this ONLY if this is a multi day event.','music-pack'); ?></div>
	        	</td>
	        </tr>
	       	<tr class="event_end_date_container">
	            <td class="mp_setting_label_td"><?php echo esc_html__('Event End Date','music-pack');?></td>
				<td>
					<input class="swp_datepicker event_end_date_input mp_setting_input" type="text" name="event_end_date" value="<?php echo esc_attr($event_end_date); ?>" />
					<div class="mp_setting_desc">
						<?php echo esc_html__('The End Date for the Multi Day Event YYYY/MM/DD','music-pack'); ?>
					</div>
				</td>
	        </tr>        
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Event Venue','music-pack');?></td>
	            <td ><input class="mp_setting_input" type="text" name="event_venue" value="<?php echo esc_attr($event_venue); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Venue ex. Glastonbury Festival','music-pack'); ?></div>
				</td>
	        </tr>
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Venue URL','music-pack');?></td>
	            <td ><input class="mp_setting_input" type="text" name="event_venue_url" value="<?php echo esc_attr($event_venue_url); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Venue URL ex. http://www.glastonburyfestivals.co.uk/','music-pack'); ?></div>
				</td>
	        </tr>

	        <tr>
	        	<td class="mp_setting_label_td"><?php echo esc_html__('Open Venue Link In','music-pack');?></td>
	        	<td>
	        		<select id="event_venue_target" name="event_venue_target">
	        			<?php MPACK_Utils::render_select_options($link_target_opts, $event_venue_target); ?>
	        		</select>

	        		<div class="mp_setting_desc">
		        		<?php echo esc_html__('Choose to open venue link in self window or in a new tab.', 'music-pack'); ?>
	        		</div>
	        	</td>
	        </tr>

	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Location','music-pack');?></td>
	            <td ><input class="mp_setting_input" type="text" name="event_location" value="<?php echo esc_attr($event_location); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Event Location ex. Worthy Farm, Pilton GB','music-pack'); ?></div>
				</td>
	        </tr>		

	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Tickets Message','music-pack');?></td>
	            <td ><input  class="mp_setting_input" type="text" name="event_buy_tickets_message" value="<?php echo esc_attr($event_buy_tickets_message); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('ex. [Buy Tickets From] or [Free Entry]','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Tickets URL','music-pack');?></td>
	            <td ><input class="mp_setting_input" type="text" name="event_buy_tickets_url" value="<?php echo esc_attr($event_buy_tickets_url); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('ex. http://www.ticketmaster.com/','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr>
	        	<td class="mp_setting_label_td"><?php echo esc_html__('Open Tickets Link In','music-pack');?></td>
	        	<td>
	        		<select id="event_buy_tickets_target" name="event_buy_tickets_target">
	        			<?php MPACK_Utils::render_select_options($link_target_opts, $event_buy_tickets_target); ?>
	        		</select>

	        		<div class="mp_setting_desc">
		        		<?php echo esc_html__('Choose to open tickets link in self window or in a new tab.', 'music-pack'); ?>
	        		</div>
	        	</td>
	        </tr>        
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Facebook Event Message','music-pack');?></td>
	            <td ><input  class="mp_setting_input" type="text" name="event_fb_message" value="<?php echo esc_attr($event_fb_message); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('ex. Check event on Facebook','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Facebook Event URL','music-pack');?></td>
	            <td ><input  class="mp_setting_input" type="text" name="event_fb_url" value="<?php echo esc_attr($event_fb_url); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('URL to Facebook Event Page','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Youtube URL','music-pack');?></td>
	            <td ><input  class="mp_setting_input" type="text" name="event_youtube_url" value="<?php echo esc_attr($event_youtube_url); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('URL to Promo Video on Youtube','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Vimeo URL','music-pack');?></td>
	            <td ><input  class="mp_setting_input" type="text" name="event_vimeo_url" value="<?php echo esc_attr($event_vimeo_url); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('URL to Promo Video on Vimeo','music-pack'); ?></div>
				</td>
	        </tr>
	        <tr>
	        	<td class="mp_setting_label_td"><?php echo esc_html__('Event Canceled','music-pack');?></td>
	        	<td>
	        		<input name="event_canceled" class="event_canceled_check" type="checkbox" value="1" <?php checked("1", $event_canceled); ?>>
	        		<div class="mp_setting_desc"><?php echo esc_html__('Check this if the event was canceled.','music-pack'); ?></div>
	        	</td>
	        </tr>
	        <tr>
	        	<td class="mp_setting_label_td"><?php echo esc_html__('Event Sold Out','music-pack');?></td>
	        	<td>
	        		<input name="event_sold_out" class="event_sold_out_check" type="checkbox" value="1" <?php checked("1", $event_sold_out); ?>>
	        		<div class="mp_setting_desc"><?php echo esc_html__('Check this if the event is sold out.','music-pack'); ?></div>
	        	</td>
	        </tr>
			<tr>
				<td>
					<?php wp_nonce_field('mpack_event_save_action', 'mpack_event_save_nonce');?>
				</td>
	        </tr>	        

		</table>
		<?php
	}

	public function mp_save_event_fields($event_id, $eventObject) {
		if (wp_is_post_autosave($event_id) || wp_is_post_revision($event_id)) {
			return;
		}
		
		if ($eventObject->post_type != 'js_events') {
			return;
		}
		if (!isset($_POST['mpack_event_save_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpack_event_save_nonce'])), 'mpack_event_save_action')) {
			return;
		}
		if (!current_user_can('edit_post', $event_id)) {
			return;
		}

		if (isset($_POST['event_date'])) {
			update_post_meta($event_id, 'event_date', MPACK_Utils::sanitize_date($_POST['event_date']));
		}
		if (isset($_POST['event_time'])) {
			update_post_meta($event_id, 'event_time', MPACK_Utils::sanitize_time($_POST['event_time']));
		}
		if (isset($_POST['event_venue'])) {
			update_post_meta($event_id, 'event_venue', sanitize_text_field($_POST['event_venue']));
		}
		if (isset($_POST['event_venue_url'])) {
			update_post_meta($event_id, 'event_venue_url', sanitize_url($_POST['event_venue_url']));
		}
		if (isset($_POST['event_location'])) {
			update_post_meta($event_id, 'event_location', sanitize_text_field($_POST['event_location']));
		}
		if (isset($_POST['event_buy_tickets_message'])) {
			update_post_meta($event_id, 'event_buy_tickets_message', sanitize_text_field($_POST['event_buy_tickets_message']));
		}
		if (isset($_POST['event_buy_tickets_url'])) {
			update_post_meta($event_id, 'event_buy_tickets_url', sanitize_url($_POST['event_buy_tickets_url']));
		}
		if (isset($_POST['event_fb_message'])) {
			update_post_meta($event_id, 'event_fb_message', sanitize_text_field($_POST['event_fb_message']));
		}
		if (isset($_POST['event_fb_url'])) {
			update_post_meta($event_id, 'event_fb_url', sanitize_url($_POST['event_fb_url']));
		}
		if (isset($_POST['event_youtube_url'])) {
			update_post_meta($event_id, 'event_youtube_url', sanitize_url($_POST['event_youtube_url']));
		}
		if (isset($_POST['event_vimeo_url'])) {
			update_post_meta($event_id, 'event_vimeo_url', sanitize_url($_POST['event_vimeo_url']));
		}
		if (isset($_POST['event_venue_target'])) {
			update_post_meta($event_id, 'event_venue_target', MPACK_Utils::sanitize_array_values($_POST['event_venue_target'], array('_self', '_blank')));
		}
		if (isset($_POST['event_buy_tickets_target'])) {
			update_post_meta($event_id, 'event_buy_tickets_target', MPACK_Utils::sanitize_array_values($_POST['event_buy_tickets_target'], array('_self', '_blank')));
		}

		if(isset($_POST['event_multiday'])) {
			update_post_meta($event_id, 'event_multiday', '1');
		} else {
			update_post_meta($event_id, 'event_multiday', '0');
		}
		if (isset($_POST['event_end_date'])) {
			update_post_meta($event_id, 'event_end_date', MPACK_Utils::sanitize_date($_POST['event_end_date']));
		}

		if(isset($_POST['event_canceled'])) {
			update_post_meta($event_id, 'event_canceled', '1');
		} else {
			update_post_meta($event_id, 'event_canceled', '0');
		}
		
		if(isset($_POST['event_sold_out'])) {
			update_post_meta($event_id, 'event_sold_out', '1');
		} else {
			update_post_meta($event_id, 'event_sold_out', '0');
		}
	}

	public function mc_custom_event_cols($columns) {
		$columns = array(
			'cb'	=> '<input type="checkbox" />',
			'title' => esc_html__('Event Title', 'music-pack'),
			'event_date'	=>	__('Date', 'music-pack'),				
			'event_location' => esc_html__('Location', 'music-pack'),
			'event_venue'	=>	__('Venue', 'music-pack'),
			'author'	=> esc_html__('Author', 'music-pack'),
			'date'		=> esc_html__('Date', 'music-pack')		
		);
		
		return $columns;
	}

	public function mc_manage_event_cols($column, $event_id) {
		global $post;
		
		switch($column) {
			case 'event_date' :
				$event_date = get_post_meta($event_id, 'event_date', true);
				echo esc_html($event_date);
				break;
			case 'event_location':
				$event_location = get_post_meta($event_id, 'event_location', true);
				echo esc_html($event_location);
				break;
			case 'event_venue':
				$event_venue = get_post_meta($event_id, 'event_venue', true);
				echo esc_html($event_venue);
				break;			
			default:
				break;
		}
	}

	public function mc_event_sortable_cols($columns) {
		$columns['event_date'] = 'event_date';

		return $columns;
	}

	public function mc_event_cols_order_by($vars) {
		if (isset($vars['orderby']) && 'event_date' == $vars['orderby']) {
		    $vars = array_merge( $vars, array(
		        'meta_key' => 'event_date',
		        'orderby' => 'meta_value'
		    ));
		}

		return $vars;
	}

	public function mp_create_event_category() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("event_category");
		if ("" == $slug) {
			$slug = "event_category";
		}

		register_taxonomy(
				'event_category',
				'js_events',
				array(
					'labels' => array(
						'name' => esc_html__('Event Categories', 'music-pack'),
						'singular_name'     => esc_html__('Event Category', 'music-pack'),
						'search_items'      => esc_html__('Search Event Categories', 'music-pack' ),
						'all_items'         => esc_html__('All Event Categories', 'music-pack' ),
						'parent_item'       => esc_html__('Parent Event Category', 'music-pack' ),
						'parent_item_colon' => esc_html__('Parent Event Category:', 'music-pack' ),
						'edit_item'         => esc_html__('Edit Event Category', 'music-pack' ),
						'update_item'       => esc_html__('Update Event Category', 'music-pack' ),
						'add_new_item' 		=> esc_html__('Add New Event Category', 'music-pack'),
						'new_item_name' 	=> esc_html__('New Event Category', 'music-pack'),
					),
					'rewrite' => array(
						'slug' => $slug,
						'with_front' => false
					),
					'show_ui' => true,
					'show_tagcloud' => false,
					'hierarchical' => true
				)
			);
	}
}

$event_pt_inst = new MPACK_Event();
