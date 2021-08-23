<?php
/**
 * Functions and definitions
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
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
// $_index = basename(__FILE__,'.php');

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
 * [NOTE]
 * This WordPress theme is the child theme of Windmill.
 * https://github.com/y2k999/windmill
 * 
 * This theme requires the Beans Extension plugin.
 * https://github.com/y2k999/beans-extension
*/

/**
 * [CASE]
 * In this sample child theme, you can know how to 
 * 	1. Add new customizer settings.
 * 	2. Add new modules (applications and widgets).
 * 	3. Add new post meta.
 * 	4. Add sticky footer bar.
 * 	5. Apply one column template for archive page.
*/

	/**
	 * @reference (WP)
	 * 	Fires when scripts and styles are enqueued.
	 * 	https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	*/
	add_action('wp_enqueue_scripts',function()
	{
		// Enqueue child theme's root stylesheet.
		wp_enqueue_style(__utility_make_handle('base-child'),trailingslashit(get_stylesheet_directory_uri()) . 'style.css');

		// Enqueue scripts and styles (including inline style).
		require_once (trailingslashit(get_stylesheet_directory()) . 'lib/enqueue.php');
	},99);


	/**
	 * [NOTE]
	 * 	Set priority higher than parent theme.
	 * 
	 * @reference (WP)
	 * 	Fires after the theme is loaded.
	 * 	https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/customizer/setup.php
	 * 	[Parent]/inc/customizer/color.php
	 * 	[Parent]/inc/env/enqueue.php
	*/
	add_action('after_setup_theme',function()
	{
		/**
		 * @since 1.0.1
		 * 	Customizer settings.
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		 * 	Whether the site is being previewed in the Customizer.
		 * 	https://developer.wordpress.org/reference/functions/is_customize_preview/
		*/
		if(is_admin() || is_customize_preview()){
			require_once (trailingslashit(get_stylesheet_directory()) . 'lib/customizer.php');
		}

		// Applications and Widgets.
		__utility_glob(trailingslashit(get_stylesheet_directory()) . 'lib/model');

		// Render components.
		require_once (trailingslashit(get_stylesheet_directory()) . 'lib/controller.php');

	},99);


	// Theme colors.
	if(is_admin() || is_customize_preview()){
		require_once (trailingslashit(get_stylesheet_directory()) . 'lib/color.php');
	}

	// Hooks.
	require_once (trailingslashit(get_stylesheet_directory()) . 'lib/extra.php');
