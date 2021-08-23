<?php
/**
 * Enqueue child theme scripts and styles.
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
	 * 	Only front-end scripts for this child theme.
	 * @reference (WP)
	 * 	Determines whether the current request is for an administrative interface page.
	 * 	https://developer.wordpress.org/reference/functions/is_admin/
	*/
	if(is_admin()){return;}


	/**
	 * [CASE]
	 * 	2. Add new modules (applications and widgets).
	 * 
	 * @since 1.0.1
	 * 	Enqueue BxSlider library and custom script for news ticker application.
	 * 	https://bxslider.com/
	 * @reference
	 * 	[Child]/lib/controller.php
	 * 	[Child]/lib/customizer.php
	 * 	[Child]/lib/model/ticker.php
	 * 	[Parent]/inc/utility/general.php
	*/
	if(get_theme_mod('setting_WB_header_ticker')){
		wp_enqueue_script('bxslider','https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js',array('jquery'),'4.2.15',TRUE);
		wp_enqueue_script(__utility_make_handle('ticker'),trailingslashit(get_stylesheet_directory_uri()) . 'asset/script/front/ticker.min.js',array('jquery','bxslider'),__utility_get_theme_version(),TRUE);
		// wp_enqueue_style(PREFIX['style'] . 'ticker','https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css',array(),'4.2.15','all');
	}


	/**
	 * @since 1.0.1
	 * 	Invoke PHP_CSS plugin.
	 * @reference
	 * 	[Parent]/inc/plugin/php-css/php-css.php
	*/
	if(class_exists('PHP_CSS') === FALSE) :
		get_template_part(SLUG['plugin'] . 'php-css/php-css');
	endif;
	$php_css = new PHP_CSS;


	/**
	 * [CASE]
	 * 	2. Add new modules (applications and widgets).
	 * 
	 * @since 1.0.1
	 * 	Inline style for news ticker.
	 * @reference
	 * 	https://bxslider.com/options/
	*/
	// Add a single property.
	$php_css->set_selector('#ticker li:not(:first-child)');
	$php_css->add_property('display','none');

	// Add a single property.
	$php_css->set_selector('.bx-viewport #ticker li');
	$php_css->add_property('display','block !important');


	/**
	 * [CASE]
	 * 	2. Add new modules (applications and widgets).
	 * 
	 * @since 1.0.1
	 * 	Inline style for popular post.
	 * @reference
	 * 	[Child]/lib/color.php
	 * 	[Child]/lib/controller.php
	 * 	[Child]/lib/model/ranking.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/utility/general.php
	*/
	// Add multiple properties at once.
	$php_css->set_selector('.ranking');
	$php_css->add_properties(array(
		'list-style-type' => 'none',
		'counter-reset' => 'number',
	));

	// Add a single property.
	$php_css->set_selector('.ranking li');
	$php_css->add_property('position','relative');

	// Add multiple properties at once.
	$php_css->set_selector('.ranking li:before');
	$php_css->add_properties(array(
		'position' => 'absolute',
		'display' => 'block',
		'padding-top' => '1rem',
		'text-align' => 'center',
		'font-size' => FONT['large'],
		'color' => COLOR['white'],
		'width' => '3.5rem',
		'height' => '3.5rem',
		'counter-increment' => 'number',
		'content' => 'counter(number)',
		'z-index' => '5',
	));

	// Add a single property.
	$php_css->set_selector('.ranking li:nth-child(1):before');
	$php_css->add_property('background',COLOR['gold']);

	// Add a single property.
	$php_css->set_selector('.ranking li:nth-child(2):before');
	$php_css->add_property('background',COLOR['silver']);

	// Add a single property.
	$php_css->set_selector('.ranking li:nth-child(3):before');
	$php_css->add_property('background',COLOR['bronz']);

	// Add a single property.
	$php_css->set_selector('.ranking li .list-title');
	$php_css->add_property('font-size',FONT['medium']);

	// Add multiple properties at once.
	$php_css->set_selector('.ranking li .list-title:hover');
	$php_css->add_properties(array(
		'color' => __utility_get_option('color_link'),
		'transition' => '0.8s',
		'opacity' => '0.8',
	));

	// Add a single property.
	$php_css->set_selector('.ranking li .updated, .ranking li .updated');
	$php_css->add_property('font-size',FONT['small']);


	/**
	 * [CASE]
	 * 	2. Add new modules (applications and widgets).
	 * 
	 * @since 1.0.1
	 * 	Inline style for CTA.
	 * @reference
	 * 	[Child]/lib/controller.php
	 * 	[Child]/lib/model/cta.php
	 * 	[Parent]/inc/setup/constant.php
	*/
	if(is_singular('post')){
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		// Add a single property.
		$php_css->set_selector('.cta .cta');
		$php_css->add_property('background',COLOR['overlay']);
	}


	/**
	 * [CASE]
	 * 	5. Apply one column template for archive page.
	 * 
	 * @since 1.0.1
	 * 	Inline style for one-column archive template.
	 * @reference
	 * 	[Child]/template/archive.php
	 * 	[Child]/template-part/content-archive.php
	 * 	[Parent]/inc/setup/constant.php
	*/
	// Add a single property.
	$php_css->set_selector('.one-column .post-title');
	$php_css->add_property('font-size',FONT['large']);


	/**
	 * [CASE]
	 * 	4. Add sticky footer bar.
	 * 
	 * @since 1.0.1
	 * 	Inline style for tailbar (sticky footer).
	 * @reference
	 * 	[Child]/lib/controller.php
	 * 	[Child]/template/tailbar.php
	 * 	[Parent]/inc/customizer/option.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/utility/general.php
	*/
	if(__utility_get_option('fixed_footer')){
		// Add multiple properties at once.
		$php_css->set_selector('#tailbar');
		$php_css->add_properties(array(
			'position' => 'fixed',
			'bottom' => '0',
			'left' => '0',
			'right' => '0',
			'transition' => '0.3s',
			'background' => COLOR['overlay'],
			'z-index' => '100',
		));
	}


	/**
	 * @since 1.0.1
	 * 	Modify inline style of parent theme.
	 * @reference
	 * 	[Parent]/asset/inline/base.php
	 * 	[Parent]/render/structure/header.php
	 * 	[Parent]/inc/customizer/option.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/template/header/header.php
	*/
	// Add a single property.
	$php_css->set_selector('.site-title a');
	$php_css->add_property('color',__utility_get_option('color_link'));


	/**
	 * @since 1.0.1
	 * 	Register the handle of inline css.
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	*/
	wp_register_style(__utility_make_handle('inline'),trailingslashit(get_stylesheet_directory_uri()) . 'asset/style/dummy.min.css');
	wp_enqueue_style(__utility_make_handle('inline'));


	/**
	 * @reference (WP)
	 * 	Add extra CSS styles to a registered stylesheet.
	 * 	https://developer.wordpress.org/reference/functions/wp_add_inline_style/
	 * @param (string) $handle
	 * 	Name of the stylesheet to add the extra styles to.
	 * @param (string) $data
	 * 	String containing the CSS styles to be added.
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	*/
	wp_add_inline_style(__utility_make_handle('inline'),$php_css->css_output());
