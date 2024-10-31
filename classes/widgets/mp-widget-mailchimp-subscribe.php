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
 * Elementor Mailchimp Subscribe Widget.
 *
 * Elementor widget that displays a pre-styled section heading
 *
 * @since 1.0.0
 */
class MPACK_Widget_Mailchimp_Subscribe extends Widget_Base {
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
        return 'mp-mailchimp-subscribe';
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
        return __( 'MailChimp Subscribe', 'music-pack' );
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
            'subscribe',
            'newsletter',
            'mailchimp'
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
            'label' => __( 'MailChimp Subscribe', 'music-pack' ),
        ] );
        $this->add_control( 'button_text', [
            'label'   => __( 'Text On Button', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Subscribe', 'music-pack' ),
        ] );
        $this->add_control( 'btn_loading_val', [
            'label'   => __( 'Text On Button On Loading', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Processing...', 'music-pack' ),
        ] );
        $this->add_control( 'input_placeholder', [
            'label'   => __( 'Input Placeholder', 'music-pack' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Email Address', 'music-pack' ),
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
        $this->end_controls_section();
        /*STYLE SECTION*/
        $this->start_controls_section( 'section_title_style', [
            'label' => __( 'MailChimp Subscribe', 'music-pack' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'general_heading', [
            'label'     => __( 'General', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        $this->add_control( 'align', [
            'label'        => __( 'Alignment', 'music-pack' ),
            'type'         => Controls_Manager::CHOOSE,
            'options'      => [
                'left'   => [
                    'title' => __( 'Left', 'music-pack' ),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __( 'Center', 'music-pack' ),
                    'icon'  => 'eicon-text-align-center',
                ],
                'right'  => [
                    'title' => __( 'Right', 'music-pack' ),
                    'icon'  => 'eicon-text-align-right',
                ],
            ],
            'default'      => '',
            'prefix_class' => 'smc-mc-align-',
        ] );
        $this->add_responsive_control( 'custom_width', [
            'label'      => __( 'Width', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 300,
                    'max'  => 800,
                    'step' => 10,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 570,
            ],
            'selectors'  => [
                '{{WRAPPER}} .swp_mc_subscr_container' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%;',
            ],
        ] );
        $this->add_control( 'tb_padding', [
            'label'      => __( 'Top/Bottom Padding', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 40,
                    'step' => 1,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 20,
            ],
            'selectors'  => [
                '{{WRAPPER}} .swp_mc_subscr_form_container' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel0', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'input_bg', [
            'label'     => __( 'Input Background', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .swp_mc_subscr_form_container' => 'background-color: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'separator_panel1', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '#767676',
            'selectors' => [
                '{{WRAPPER}} i.before_at_cf_detail' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'icon_size', [
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
                'size' => 18,
            ],
            'selectors'  => [
                '{{WRAPPER}} i.before_at_cf_detail' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_control( 'separator_panel2', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'txt_typo_heading', [
            'label'     => __( 'Text & Typography', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        /*get pro controls [[[*/
        $this->add_control( 'text_color_get_pro', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Text Typography', 'music-pack' ),
            'name'     => 'typography_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'placeholder_color_get_pro', [
            'label'     => __( 'Placeholder Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '',
            'selectors' => [],
            'classes'   => 'mpfe-get-pro',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Placeholder Typography', 'music-pack' ),
            'name'     => 'typography2_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        /*get pro controls ]]]*/
        $this->add_control( 'separator_panel3', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'btn_heading', [
            'label'     => __( 'Subscribe Button', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        /*get pro controls*/
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'    => __( 'Subscribe Typography', 'music-pack' ),
            'name'     => 'typography3_get_pro',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector' => '',
        ] );
        $this->add_control( 'mc_btn_lr_padding', [
            'label'      => __( 'Left/Right Padding', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
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
                'size' => 10,
            ],
            'selectors'  => [
                '{{WRAPPER}} .at_news_button_entry' => 'padding-left: {{SIZE}}{{UNIT}} !important; padding-right: {{SIZE}}{{UNIT}} !important;',
            ],
        ] );
        $this->add_control( 'mc_btn_tb_padding', [
            'label'      => __( 'Top/Bottom Padding', 'music-pack' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
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
                'size' => 10,
            ],
            'selectors'  => [
                '{{WRAPPER}} .at_news_button_entry' => 'padding-top: {{SIZE}}{{UNIT}} !important; padding-bottom: {{SIZE}}{{UNIT}} !important;',
            ],
        ] );
        $this->start_controls_tabs( 'mc_btn_style_tabs' );
        $this->start_controls_tab( 'mc_btn_style_normal_tab', [
            'label' => __( 'Normal', 'music-pack' ),
        ] );
        $this->add_control( 'mc_btn_txt_color', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '#474747',
            'selectors' => [
                '{{WRAPPER}} .at_news_button_entry' => 'color: {{VALUE}} !important;',
            ],
        ] );
        $this->add_control( 'mc_btn_bg_color', [
            'label'     => __( 'Background Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '#02010100',
            'selectors' => [
                '{{WRAPPER}} .at_news_button_entry' => 'background-color: {{VALUE}} !important;',
            ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'mc_btn_border',
            'label'    => __( 'Border', 'music-pack' ),
            'selector' => '{{WRAPPER}} .at_news_button_entry',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'mc_btn_style_hover_tab', [
            'label' => __( 'Hover', 'music-pack' ),
        ] );
        $this->add_control( 'mc_btn_hov_txt_color', [
            'label'     => __( 'Text Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .at_news_button_entry:hover' => 'color: {{VALUE}} !important;',
            ],
        ] );
        $this->add_control( 'mc_btn_hov_bg_color', [
            'label'     => __( 'Background Color', 'music-pack' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .at_news_button_entry:hover' => 'background-color: {{VALUE}} !important;',
            ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'mc_btn_hov_border',
            'label'    => __( 'Border', 'music-pack' ),
            'selector' => '{{WRAPPER}} .at_news_button_entry:hover',
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control( 'separator_panel4', [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ] );
        $this->add_control( 'widget_border_heading', [
            'label'     => __( 'Widget Border', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'border',
            'label'    => __( 'Border', 'music-pack' ),
            'selector' => '{{WRAPPER}} .swp_mc_subscr_form_container',
        ] );
        $this->add_control( 'separator_panel5', [
            'type'      => Controls_Manager::DIVIDER,
            'style'     => 'thick',
            'condition' => [
                'add_gdpr' => 'yes',
            ],
        ] );
        $this->add_control( 'consent_heading', [
            'label'     => __( 'Consent', 'music-pack' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'none',
            'condition' => [
                'add_gdpr' => 'yes',
            ],
        ] );
        $this->add_responsive_control( 'dist_before_gdpr', [
            'label'      => __( 'Consent Gap', 'music-pack' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min'  => 0,
                    'max'  => 100,
                    'step' => 5,
                ],
            ],
            'default'    => [
                'unit' => 'px',
                'size' => 10,
            ],
            'selectors'  => [
                '{{WRAPPER}} .swp_mc_subscr_form_container' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition'  => [
                'add_gdpr' => 'yes',
            ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'label'     => __( 'Consent Typography', 'music-pack' ),
            'name'      => 'consent_typo',
            'global'    => [
                'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
            ],
            'selector'  => '{{WRAPPER}} .gdpr_agree_consent_message',
            'condition' => [
                'add_gdpr' => 'yes',
            ],
        ] );
        $this->add_control( 'consent_col', [
            'label'     => __( 'Consent Color', 'music-pack' ),
            'type'      => Controls_Manager::COLOR,
            'global'    => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'default'   => '#707281',
            'selectors' => [
                '{{WRAPPER}} .gdpr_agree_consent_message' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'add_gdpr' => 'yes',
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
        ?>

		<div class="swp_mc_subscr_container">
			<div class="swp_mc_subscr_form_container clearfix lc_swp_bg_color">
				<form class="swp_mc_subscr_form clearfix">
					<i class="far fa-envelope before_at_cf_detail" aria-hidden="true"></i>
					<input type="text" placeholder="<?php 
        echo esc_attr( $settings['input_placeholder'] );
        ?>" name="newsletter_email" class="mc_email at_newslet_entry at_news_input_entry required"/>

					<input name="newsletter_subscribe" type="submit" data-btnval="<?php 
        echo esc_attr( $settings['button_text'] );
        ?>" data-loadingmsg="<?php 
        echo esc_attr( $settings['btn_loading_val'] );
        ?>" class="at_newslet_entry at_news_button_entry transition3" value="<?php 
        echo esc_attr( $settings['button_text'] );
        ?>" >

					<input type="hidden" name="action" value="swpmcform_action" />
					<?php 
        wp_nonce_field( 'swpmcform_action', 'mpack_subform_nonce' );
        ?>			
				</form>
			</div>

			<?php 
        if ( "yes" == $settings['add_gdpr'] ) {
            ?>
			<div class="gdpr_consent_mc">
				<input type="checkbox" required name="gdpr_agree_consent" value="" class="gdpr_agree_consent_checkbox" id="swp_consent_checkbox">
				<label for="swp_consent_checkbox" class="gdpr_agree_consent_message"><?php 
            echo wp_kses_post( $settings['gdpr_content'] );
            ?></label>
			</div>					
			<?php 
        }
        ?>		
			
			<div class="swp_mc_form_success">
				<?php 
        echo esc_html__( 'Thank You For Subscribing! You have been added to our mailing list.', 'music-pack' );
        ?>
			</div>
			<div class="swp_mc_form_error">
			</div>		
		</div>

		<?php 
    }

}
