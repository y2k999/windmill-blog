<?php
/**
 * The template for displaying tailbar.
 * @link https://codex.wordpress.org/Template_Hierarchy
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
$index = basename(__FILE__,'.php');

/**
 * @reference (WP)
 * 	Retrieves name of the current stylesheet.
 * 	https://developer.wordpress.org/reference/functions/get_stylesheet/
*/
$theme = get_stylesheet();


/* Exec
______________________________
*/
?>
<?php
/**
 * [CASE]
 * 4. Add sticky footer bar.
 * 
 * @reference (Uikit)
 * 	https://getuikit.com/docs/container
 * 	https://getuikit.com/docs/grid
 * 	https://getuikit.com/docs/scrollspy
 * 	https://getuikit.com/docs/width
*/

	/**
	 * @reference (Beans)
	 * 	HTML markup.
	 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
	 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
	 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
	*/
	beans_open_markup_e("_nav[{$theme}][{$index}]",'aside',array(
		'id' => $index,
		'class' => 'uk-container uk-container-expand',
		'role' => 'navigation',
	));
		beans_open_markup_e("_grid[{$theme}][{$index}]",'div',array(
			'class' => 'uk-grid uk-child-width-1-4 uk-child-width-expand@m uk-padding-small',
			'uk-grid' => 'uk-grid',
			'uk-scrollspy' => 'cls: uk-animation-scale-down; target: > div > a; delay: 100',
		));
			if(is_callable('__windmill_blog_template_tailbar_page')) :
			// if(is_callable('__windmill_blog_template_tailbar_share')) :
				__windmill_blog_template_tailbar_page($theme,$index);
				// __windmill_blog_template_tailbar_share($theme,$index);
			endif;
		beans_close_markup_e("_grid[{$theme}][{$index}]",'div');
	beans_close_markup_e("_nav[{$theme}][{$index}]",'aside');


	/* Method
	_________________________
	*/
	// if(function_exists('__windmill_blog_template_tailbar_share') === FALSE) :
	function __windmill_blog_template_tailbar_share($theme = '',$index = '')
	{
		/**
		 * @access (public)
		 * 	Render the SNS follow icons on footer bar.
		 * @return (void)
		 * @reference
		 * 	[Parent]/inc/customizer/option.php
		 * 	[Parent]/inc/utility/general.php
		*/
		if(!isset($theme)){
			$theme = get_stylesheet();
		}
		if(!isset($index)){
			$index = basename(__FILE__,'.php');
		}

		foreach(__utility_get_value('follow') as $item){
			/**
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/icon
			*/
			beans_open_markup_e("_column[{$theme}][{$index}]",'div',array('class' => 'uk-text-center'));
				beans_open_markup_e("_icon[{$theme}][{$index}][{$item}]",'a',array(
					'href' => __utility_get_option('url_' . $item),
					'uk-icon' => 'icon: ' . $item . ' ; ratio: 2',
					'style' => 'color: ' . __utility_get_color($item) . ' ;',
				));
				beans_close_markup_e("_icon[{$theme}][{$index}][{$item}]",'a');
			beans_close_markup_e("_column[{$theme}][{$index}]",'div');
		}

	}// Method
	// endif;


	/* Method
	_________________________
	*/
	// if(function_exists('__windmill_blog_template_tailbar_page') === FALSE) :
	function __windmill_blog_template_tailbar_page($theme = '',$index = '')
	{
		/**
		 * @access (public)
		 * 	Render the static pages menue on footer bar.
		 * @return (void)
		 * @reference
		 * 	[Parent]/inc/utility/general.php
		*/
		if(!isset($theme)){
			$theme = get_stylesheet();
		}
		if(!isset($index)){
			$index = basename(__FILE__,'.php');
		}

		$array = array(
			'home' => array(
				'icon' => 'home',
				'label' => esc_html__('Home','windmill'),
				'url' => home_url('/'),
			),
			'blog' => array(
				'icon' => 'pencil',
				'label' => esc_html__('Blog','windmill'),
				'url' => home_url('/blog'),
			),
			'contact' => array(
				'icon' => 'mail',
				'label' => esc_html__('Contact','windmill'),
				'url' => home_url('/'),
			),
			'back' => array(
				'icon' => 'chevron-up',
				'label' => esc_html__('Back','windmill'),
				'url' => '#',
			),
		);

		foreach($array as $key => $value){
			/**
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/icon
			 * 	https://getuikit.com/docs/scroll
			*/
			beans_open_markup_e("_column[{$theme}][{$index}]",'div',array('class' => 'uk-text-center'));
				beans_open_markup_e("_icon[{$theme}][{$index}][{$key}]",'a',array(
					'href' => $value['url'],
					'uk-icon' => 'icon: ' . $value['icon'] . ' ; ratio: 2',
					'style' => 'color: ' . __utility_get_color($value['icon']) . ' ;',
				));
				beans_close_markup_e("_icon[{$theme}][{$index}][{$key}]",'a');
				beans_output_e("_output[{$theme}][{$index}][{$key}][br]",'<br>');

				if($key === 'back'){
					beans_open_markup_e("_link[{$theme}][{$index}][{$key}]",'a',array(
						'href' => $value['url'],
						'uk-scroll' => 'uk-scroll',
					));
				}
				else{
					beans_open_markup_e("_link[{$theme}][{$index}][{$key}]",'a',array(
						'href' => $value['url'],
					));
				}
					beans_open_markup_e("_label[{$theme}][{$index}][{$key}]",'span',array('class' => 'uk-text-center'));
						beans_output_e("_output[{$theme}][{$index}][{$key}][label]",$value['label']);
					beans_close_markup_e("_label[{$theme}][{$index}][{$key}]",'span');
				beans_close_markup_e("_link[{$theme}][{$index}][{$key}]",'a');

			beans_close_markup_e("_column[{$theme}][{$index}]",'div');
		}

	}// Method
	// endif;
