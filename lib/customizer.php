<?php
/**
 * Customizer settings for child theme.
 * @package Windmill Blog
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by Eggnews WordPress Theme
 * @link https://themeegg.com/themes/eggnews/
 * @author ThemeEgg
 * 
 * Inspired by Sparkling WordPress Theme
 * @link http://colorlib.com/wp/themes/sparkling
 * @author Colorlib
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');

/**
 * @reference (WP)
 * 	Retrieves name of the current stylesheet.
 * 	https://developer.wordpress.org/reference/functions/get_stylesheet/
*/
// $theme = get_stylesheet();


/* Exec
______________________________
*/
?>
<?php
/**
 * [TOC]
 * 	add_panel
 * 	add_section
 * 	add_setting
 * 	add_control
 * 	 - header_ticker
 * 	 - meta_elapsed
 * 	 - meta_estimated
 * 	 - fixed_footer
*/

	/**
	 * [CASE]
	 * 	1. Add new customizer settings.
	 * 
	 * @since 1.0.1
	 * 	In this sample, add specified panel, sections, and settings/controls for this child theme.
	 * @reference (Beans)
	 * 	Set beans_add_action() using the callback argument as the action ID.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_smart_action/
	 * @reference (WP)
	 * 	Fires once WordPress has loaded, allowing scripts and styles to be initialized.
	 * 	https://developer.wordpress.org/reference/hooks/customize_register/
	*/
	beans_add_smart_action('customize_register',function($wp_customize)
	{
		/**
		 * [NOTE]
		 * 	"WB" stands for Windmill Blog.
		 * 
		 * @param (WP_Customize_Manager) $wp_customize
		 * 	Instance of WP_Customize_Manager.
		 * 	https://developer.wordpress.org/reference/classes/wp_customize_manager/
		 * @return (bool)
		 * 	Will always return true (Validate action arguments?).
		 * @reference
		 * 	[Parent]/inc/customizer/setup.php
		*/

		/**
		 * @reference (WP)
		 * 	Add a customize panel.
		 * 	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
		*/
		$wp_customize->add_panel('panel_WB_child',array(
			'priority' => 2000,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => '[Windmill Blog] ' . esc_html__('Panel','windmill'),
		));

		/**
		 * @reference (WP)
		 * 	Add a customize section.
		 * 	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
		*/
		$wp_customize->add_section('section_WB_header',array(
			'title' => esc_html__('Header','windmill'),
			'panel' => 'panel_WB_child'
		));

		$wp_customize->add_section('section_WB_meta',array(
			'title' => esc_html__('Meta','windmill'),
			'panel' => 'panel_WB_child'
		));

		// Transport postMessage variable set.
		$customizer_selective_refresh = isset($wp_customize->selective_refresh) ? 'refresh' : 'postMessage';

		/**
		 * @reference (WP)
		 * 	Add a customize setting.
		 * 	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
		 * 	Add a customize control.
		 * 	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
		*/

		/**
		 * @since 1.0.1
		 * 	News ticker on topbar.
		 * @reference
		 * 	[Child]/lib/model/ticker.php
		 * 	[Parent]/inc/utility/sanitize.php
		*/
		$wp_customize->add_setting('setting_WB_header_ticker',array(
			'default' => 0,
			'capability' => 'edit_theme_options',
			'transport' => $customizer_selective_refresh,
			'sanitize_callback' => '__utility_sanitize_checkbox',
		));
		$wp_customize->add_control('setting_WB_header_ticker',array(
			'label' => esc_html__('News Ticker Option','windmill'),
			'description' => esc_html__('Enable/disable news ticker at header.','windmill'),
			'section' => 'section_WB_header',
			'type' => 'checkbox',
		));

		/**
		 * @since 1.0.1
		 * 	Elapsed date from the previous post.
		 * @reference
		 * 	[Child]/lib/controller.php
		 * 	[Parent]/inc/utility/sanitize.php
		*/
		$wp_customize->add_setting('setting_WB_meta_elapsed',array(
			'default' => 0,
			'capability' => 'edit_theme_options',
			'transport' => $customizer_selective_refresh,
			'sanitize_callback' => '__utility_sanitize_checkbox',
		));
		$wp_customize->add_control('setting_WB_meta_elapsed',array(
			'label' => esc_html__('Elapsed Date from Previous','windmill'),
			'description' => esc_html__('Elapsed date from previous post.','windmill'),
			'section' => 'section_WB_meta',
			'type' => 'checkbox',
		));

		/**
		 * @since 1.0.1
		 * 	Estimated time to read the article.
		 * @reference
		 * 	[Child]/lib/controller.php
		 * 	[Parent]/inc/utility/sanitize.php
		*/
		$wp_customize->add_setting('setting_WB_meta_estimated',array(
			'default' => 0,
			'capability' => 'edit_theme_options',
			'transport' => $customizer_selective_refresh,
			'sanitize_callback' => '__utility_sanitize_checkbox',
		));
		$wp_customize->add_control('setting_WB_meta_estimated',array(
			'label' => esc_html__('Estimated Time','windmill'),
			'description' => esc_html__('Estimated time to read this article.','windmill'),
			'section' => 'section_WB_meta',
			'type' => 'checkbox',
		));

		/**
		 * [NOTE]
		 * 	Add new setting/control to the existing section in the parent theme.
		 * 
		 * @since 1.0.1
		 * 	Sticky Footer.
		 * @reference
		 * 	[Parent]/inc/customizer/setup.php
		 * 	[Parent]/inc/customizer/setting/template/footer.php
		 * 	[Parent]/inc/utility/sanitize.php
		*/
		$wp_customize->add_setting('setting_WM_fixed_footer',array(
			'default' => 1,
			'capability' => 'edit_theme_options',
			'transport' => $customizer_selective_refresh,
			'sanitize_callback' => '__utility_sanitize_checkbox',
		));
		$wp_customize->add_control('setting_WM_fixed_footer',array(
			'label' => esc_html__('Static(Fixed) Footer','windmill'),
			'description' => esc_html__('Check here to activate sticky footer.','windmill'),
			'section' => 'section_WM_footer',
			'type' => 'checkbox',
			'priority' => 5,
		));

	});
