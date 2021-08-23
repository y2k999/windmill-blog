<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
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
	 * @since 1.0.1
	 * 	Modify Uikit section properties of topbar (masthead).
	 * @reference (Beans)
	 * 	Hooks a function or method to a specific filter action.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_filter/
	 * @reference (Uikit)
	 * 	https://getuikit.com/docs/section
	 * @reference
	 * 	[Parent]/controller/render/section.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/template/header/header.php
	*/
	beans_add_filter("_filter[_structure_header][icon]",function()
	{
		/**
		 * @param (array) $icon
		 * 	Registerd icons in parent theme.
		 * @return (array)
		 * 	Icons to be registerd (override) in this child theme.
		 * @hook target
		 * 	_filter[_structure_header][icon]
		 * @reference
		 * 	[Parent]/controller/structure/header.php
		 * 	[Parent]/inc/utility/general.php
		 * 	[Parent]/model/data/icon.php
		*/
		return array(
			'nav' => __utility_get_icon('nav'),
			'search' => __utility_get_icon('search'),
			'html-sitemap' => __utility_get_icon('html-sitemap'),
			// 'amp' => __utility_get_icon('amp'),
		);

	},99);


	/**
	 * @reference (WP)
	 * 	Fires on the first WP load after a theme switch if the old theme still exists.
	 * 	https://developer.wordpress.org/reference/hooks/after_switch_theme/
	*/
	beans_add_smart_action('after_switch_theme',function()
	{
		/**
		 * [NOTE]
		 * 	"WB" stands for Windmill Blog.
		 * 
		 * @since 1.0.1
		 * 	Set initial values of theme customizer of this child theme.
		 * @reference (WP)
		 * 	Retrieves all theme modifications.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mods/
		*/
		$theme_mods = get_theme_mods();

		foreach(array(
			'setting_WB_header_ticker' => 1,
			'setting_WB_meta_elapsed' => 1,
			'setting_WB_meta_estimated' => 1,
			'setting_WM_fixed_footer' => 1,
		) as $key => $value){
			// Only insert values when no values are set.
			if(!array_key_exists($key,$theme_mods)){
				/**
				 * @reference (WP)
				 * 	Updates theme modification value for the current theme.
				 * 	https://developer.wordpress.org/reference/functions/set_theme_mod/
				*/
				set_theme_mod($key,$value);
			}
		}

	},99);
