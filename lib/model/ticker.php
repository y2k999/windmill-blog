<?php
/**
 * Render News ticker on topbar.
 * @package Windmill Blog
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by Eggnews WordPress theme.
 * @link https://themeegg.com/themes/eggnews/
 * @see ThemeEgg
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
if(class_exists('_app_ticker') === FALSE) :
class _app_ticker
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_icon()
 * 	__the_template()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $_icon
			Icon for this application.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private static $_icon = '';

	/**
	 * Traits.
	*/
	use _trait_singleton;
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (public)
				Send to Constructor.
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param();

		// Get icon's html.
		self::$_icon = $this->set_icon(self::$_index);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_param()
	{
		/**
			@access (private)
				Set parameters for the application component.
			@return (array)
				_filter[_app_ticker][param]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		return array(
			'perpage' => get_option('posts_per_page'),
			// 'perpage' => 5,
			'orderby' => 'rand',
			// 'format'		 => 'list',
			'ignore_sticky_posts' => TRUE,
		);

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_template($args = array())
	{
		/**
			[CASE]
				2. Add new modules (applications and widgets).
			@access (public)
				Display news ticker on topbar.
				In this theme, we use BxSlider(https://bxslider.com/) for content slider.
				If necessary, you need to enqueue bxslider library and script.
			@param (array) $args
				Additional arguments passed to this application.
			@return (void)
			@reference
				[Child]/controller/render.php
				[Child]/lib/enqueue.php
				[Parent]/controller/structure/header.php
				[Parent]/inc/utility/general.php
				[Parent]/template/header/header.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Merge user defined arguments into defaults array.
		// $args = wp_parse_args();

		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (Beans)
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		*/
		$before = beans_open_markup("_tag[{$class}]",'span',array('class' => 'uk-margin-small-left'));
		$after = beans_close_markup("_tag[{$class}]",'span');

		/**
		 * @reference (Beans)
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		// beans_open_markup_e("_column[{$class}]",'div',array('class' => 'uk-width-auto uk-padding-small uk-overflow-hidden uk-visible@m ' . self::$_index));
		beans_open_markup_e("_column[{$class}]",'div',array('class' => 'uk-padding-small uk-overflow-hidden uk-visible@m ' . self::$_index));

			beans_open_markup_e("_list[{$class}]",'ul',array('id' => self::$_index));
				/**
				 * @reference (WP)
				 * 	Filter the beans loop query.
				 * 	This can be used for custom queries.
				 * 	https://developer.wordpress.org/reference/classes/wp_query/
				 * @since 4.9.0
				 * 	Added the `$instance` parameter.
				 * @see WP_Query::get_posts()
				 * @param (array) $args
				 * 	An array of arguments used to retrieve the recent posts.
				*/
				$r = new WP_Query(array(
					'post_type' => 'post',
					// 'posts_per_page' => self::$_param['perpage'],
					'posts_per_page' => NULL,
					'orderby' => self::$_param['orderby'],
					'ignore_sticky_posts' => TRUE,
				));

				/**
				 * @since 1.0.1
				 * 	Display a message that posts cannot be found.
				 * @reference
				 * 	[Parent]/inc/trait/theme.php
				*/
				if(!$r->have_posts()) :
					self::__the_nopost();
				endif;

				while($r->have_posts()) :	$r->the_post();
					beans_open_markup_e("_item[{$class}]",'li');
						/**
						 * @since 1.0.1
						 * 	Prints HTML with meta information for the current post-date/time.
						 * @reference
						 * 	[Parent]/inc/trait/theme.php
						 * 	[Parent]/model/app/meta.php
						*/
						self::__activate_application('meta',array(
							'type' => 'cat-links',
							'cat-all' => FALSE,
							'tags-all' => FALSE,
							'echo' => TRUE,
						));

						/**
						 * @since 1.0.1
						 * 	Display or retrieve the current post title with optional markup.
						 * @reference (WP)
						 * 	Sanitize the current title when retrieving or displaying.
						 * 	https://developer.wordpress.org/reference/functions/the_title_attribute/
						*/
						beans_open_markup_e("_link[{$class}]",'a',array(
							'href' => get_permalink($post->ID),
							'title' => the_title_attribute('echo=0'),
							'rel' => 'bookmark',
							'target' => '_self',
						));
							/**
							 * @reference (WP)
							 * 	Display or retrieve the current post title with optional markup.
							 * 	https://developer.wordpress.org/reference/functions/the_title/
							*/
							the_title($before,$after);
						beans_close_markup_e("_link[{$class}]",'a');

					beans_close_markup_e("_item[{$class}]",'li');
				endwhile;

				/**
				 * @since 1.0.1
				 * 	Only reset the query if a filter is set.
				 * @reference (WP)
				 * 	After looping through a separate query, this function restores the $post global to the current post in the main query.
				 * 	https://developer.wordpress.org/reference/functions/wp_reset_postdata/
				*/
				wp_reset_postdata();

			// </.ul>
			beans_close_markup_e("_list[{$class}]",'ul');

		beans_close_markup_e("_column[{$class}]",'div');

	}// Method


}// Class
endif;
// new _app_ticker();
_app_ticker::__get_instance();
