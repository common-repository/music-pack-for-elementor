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
 * Elementor Contact Form.
 *
 *
 * @since 1.0.0
 */
class MPACK_Widget_Contact_Form extends Widget_Base {
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
        return 'mp-contact-form';
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
        return __( 'Contact Form', 'music-pack' );
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
        return ['music pack', 'contact', 'form'];
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
            'label' => __( 'Contact Form', 'music-pack' ),
        ] );
        $this->add_control( 'input_styling', [
            'label'   => __( 'Style', 'music-pack' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'one_on_row',
            'options' => [
                'one_on_row' => __( 'One On Row', 'music-pack' ),
                'two_on_row' => __( 'Two on Row', 'music-pack' ),
            ],
        ] );
        $this->add_control( 'subject', [
            'label'   => __( 'Email Subject', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'New contact form message from your website', 'music-pack' ),
        ] );
        $this->add_control( 'add_gdpr', [
            'label'        => __( 'Add GDPR Consent', 'music-pack' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'music-pack' ),
            'label_off'    => __( 'No', 'music-pack' ),
            'return_value' => 'yes',
            'default'      => 'no',
        ] );
        $this->add_control( 'gdpr_content', [
            'label'       => __( 'GDPR Consent Message', 'music-pack' ),
            'type'        => \Elementor\Controls_Manager::WYSIWYG,
            'default'     => __( 'This form collects your name and email. Check our our privacy policy for more details on how we protect and manage your data.', 'music-pack' ),
            'placeholder' => __( 'GDPR consent message...', 'music-pack' ),
            'condition'   => [
                'add_gdpr' => 'yes',
            ],
        ] );
        $this->add_control( 'btn_text', [
            'label'   => __( 'Text On Button', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Send Email', 'music-pack' ),
        ] );
        $this->add_control( 'btn_text_loading', [
            'label'   => __( 'Loading Text On Button', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Please Wait...', 'music-pack' ),
        ] );
        $this->add_control( 'pl_name', [
            'label'   => __( 'Name Placeholder', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Your Name', 'music-pack' ),
        ] );
        $this->add_control( 'pl_email', [
            'label'   => __( 'Email Placeholder', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Your Email', 'music-pack' ),
        ] );
        $this->add_control( 'pl_mess', [
            'label'   => __( 'Message Placeholder', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Please enter a message', 'music-pack' ),
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Contact Form', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'color_opts_heading_get_pro', [
            'label'     => __( 'COLORS', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        $this->add_control( 'placeholder_col_get_pro', [
            'label'     => __( 'Placeholder Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'txt_col_get_pro', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'icons_col_get_pro', [
            'label'     => __( 'Icons Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'error_col_get_pro', [
            'label'     => __( 'Error Messages Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_0_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'input_bg_get_pro', [
            'label'     => __( 'Input Background', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_control( 'separator_panel_1_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'typo_opts_heading_get_pro', [
            'label'     => __( 'TYPOGRAPHY', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Text Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'separator_panel_1_1_get_pro', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        /*get pro controls ]]]*/
        $this->add_control( 'position_opts_heading', [
            'label'     => __( 'POSITION', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        $this->add_control( 'input_gap', [
            'label'      => __( 'Input Gap', 'music-pack' ),
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
                '{{WRAPPER}} input[type="text"]' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'input_lr_padding', [
            'label'      => __( 'Input Left/Right Padding', 'music-pack' ),
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
                '{{WRAPPER}} input[type="text"], {{WRAPPER}} textarea' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'input_tb_padding', [
            'label'      => __( 'Input Top/Bottom Padding', 'music-pack' ),
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
                '{{WRAPPER}} input[type="text"]' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'textarea_tb_padding', [
            'label'      => __( 'Textarea Top/Bottom Padding', 'music-pack' ),
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
                '{{WRAPPER}} textarea' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'textarea_height', [
            'label'      => __( 'Textarea height', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 200,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 103,
            ],
            'selectors'  => [
                '{{WRAPPER}} textarea' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'icon_distance', [
            'label'      => __( 'Icons distance from right', 'music-pack' ),
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
                '{{WRAPPER}} i' => 'right: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'icons_size', [
            'label'      => __( 'Icon Size', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 50,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 16,
            ],
            'selectors'  => [
                '{{WRAPPER}} i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel_4', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'input_border_opts_heading', [
            'label'     => __( 'INPUT BORDER', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'cf_input_border',
            'label'    => __( 'Input Border', 'music-pack' ),
            'selector' => '{{WRAPPER}} input[type="text"], {{WRAPPER}} textarea',
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'border_focus_col_get_pro', [
            'label'     => __( 'Border Color On Focus', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        /*get pro controls ]]]*/
        $this->add_control( 'input_br', [
            'label'      => __( 'Input Border Radius', 'music-pack' ),
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
                'size' => 3,
            ],
            'selectors'  => [
                '{{WRAPPER}} input[type="text"], {{WRAPPER}} textarea' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
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
        $additional_input_class = ( "two_on_row" == $settings['input_styling'] ? " two_on_row two_on_row_layout" : "" );
        ?>

		<div class="swp_contactform<?php 
        echo esc_attr( $additional_input_class );
        ?>">
			<form class="swp_contactform<?php 
        echo esc_attr( $additional_input_class );
        ?>">
				<ul class="contactform_fields">
					<li class="mp-contact-form-author swp_cf_entry<?php 
        echo esc_attr( $additional_input_class );
        ?>">
						<input type="text" placeholder="<?php 
        echo esc_html( $settings['pl_name'] );
        ?>" name="contactName" id="contactName" class="lucille_cf_input required requiredField contactNameInput" />
						<i class="far fa-user swp_cf_icon"></i>
						<div class="swp_cf_error"><?php 
        echo esc_html__( 'Please enter your name', 'music-pack' );
        ?></div>
					</li>

					<li class="mp-contact-form-email swp_cf_entry<?php 
        echo esc_attr( $additional_input_class );
        ?>">
						<input type="text" placeholder="<?php 
        echo esc_html( $settings['pl_email'] );
        ?>" name="email" id="contactemail" class="lucille_cf_input required requiredField email" />
						<i class="far fa-envelope swp_cf_icon" aria-hidden="true"></i>
						<div class="swp_cf_error"><?php 
        echo esc_html__( 'Please enter a correct email address', 'music-pack' );
        ?></div>
					</li>

					<li class="comment-form-comment swp_cf_entry">
						<textarea name="comments" placeholder="<?php 
        echo esc_html( $settings['pl_mess'] );
        ?>" id="commentsText" rows="6" cols="30" class="lucille_cf_input required requiredField contactMessageInput"></textarea>
						<div class="swp_cf_error"><?php 
        echo esc_html__( 'Please enter a message', 'music-pack' );
        ?></div>
					</li>
					
					<?php 
        if ( "yes" == $settings['add_gdpr'] ) {
            ?>
					<li class="gdpr_consent">
						<input type="checkbox" required name="gdpr_agree_consent" value="" class="gdpr_agree_consent_checkbox" id="swp_consent_checkbox">
						<label for="swp_consent_checkbox" class="gdpr_agree_consent_message"><?php 
            echo wp_kses_post( $settings['gdpr_content'] );
            ?></label>
					</li>
					<?php 
        }
        ?>

					<li class="wp_mail_error">
						<div class="swp_cf_error"><?php 
        echo esc_html__( 'Cannot send mail, an error occurred while delivering this message. Please try again later.', 'music-pack' );
        ?></div>
					</li>

					<li class="form_result_error"></li>	

					<li class="contact_buttom">
						<input name="Button1" type="submit" id="submit" class="lc_button contact_button" data-loadingmsg="<?php 
        echo esc_html( $settings['btn_text_loading'] );
        ?>" value="<?php 
        echo esc_html( $settings['btn_text'] );
        ?>" >
					</li>
					<li class="formResultOK">
						<div class="swp_cf_error"><?php 
        echo esc_html__( 'Your message was sent successfully. Thanks!', 'music-pack' );
        ?></div>
					</li>
				</ul>
				<input type="hidden" name="action" value="swpcontactform_action" />
				<input type="hidden" name="swp_cf_subject" value="<?php 
        echo esc_attr( esc_html( $settings['subject'] ) );
        ?>" />
				<?php 
        wp_nonce_field( 'swpcontactform_action', 'mpack_cf_nonce' );
        ?>
			</form>
		</div>

		<?php 
    }

}
