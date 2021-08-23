<?php
/**
 * This is child class that extends _widget_base (parrent).
 * @link https://codex.wordpress.org/Widgets_API
 * @package Windmill Blog
 * @license GPL3.0+
 * @since 1.0.1
*/


/**
 * Inspired by Core class used to implement WP_Widget.
 * @link https://codex.wordpress.org/Widgets_API
 * @see WP_Widget
 * 
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
 * 
 * Inspired by Magazine Plus WordPress theme.
 * @link https://wenthemes.com/item/wordpress-themes/magazine-plus/
 * @see WEN Themes
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

	/**
	 * @reference (Beans)
	 * 	Set beans_add_action() using the callback argument as the action ID.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_smart_action/
	 * @reference (WP)
	 * 	Fires after all default WordPress widgets have been registered.
	 * 	https://developer.wordpress.org/reference/hooks/widgets_init/
	*/
	beans_add_smart_action('widgets_init',function()
	{
		/**
		 * @reference (WP)
		 * 	Register Widget
		 * 	https://developer.wordpress.org/reference/functions/register_widget/
		*/
		register_widget('_widget_ranking');
	});


if(class_exists('_widget_ranking') === FALSE) :
class _widget_ranking extends _widget_base
{
/**
 * [TOC]
 * 	__construct()
 * 	set_field()
 * 	widget()
 * 	 - get_param()
 * 	 - __the_nopost()
 * 	 - get_template_part()
 * 	form()
 * 	update()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $meta_key
			Custom field for the PV.
	*/
	private static $_class = '';
	private static $_index = '';
	private $meta_key = '';

	/**
	 * Traits.
	*/
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	public function __construct()
	{
		/**
			@access (public)
				Class Constructor.
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/widget/base.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		/**
		 * @since 1.0.1
		 * 	Custom field for the PV.
		 * @reference
		 * 	[Plugin]/beans_extension/admin/tab/app/column.php
		*/
		$this->meta_key = 'post_views_count';

		$widget_options = array(
			'classname' => 'widget' . self::$_class,
			'description' => '[Windmill Blog]' . ' ' . ucfirst(self::$_index),
			'customize_selective_refresh' => TRUE,
		);

		/**
		 * [CASE]
		 * 	2. Add new modules (applications and widgets).
		 * 		In this case, define and register popular post application that extends parent widget class;
		*/
		parent::__construct(
			self::$_index,
			ucfirst(self::$_index),
			$widget_options,
			array(),
			$this->set_field()
		);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_field()
	{
		/**
			@access (private)
				Helper function that holds widget fields.
				Array is used in update and form functions.
			@return (array)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		return array(
			'title' => array(
				'label' => esc_html__('Title:','windmill'),
				'type' => 'text',
				'default' => esc_html__('Popular Posts','windmill'),
			),
			'number' => array(
				'label' => esc_html__('Number of posts to show:','windmill'),
				'type' => 'number',
				'default' => 3,
			),
			'format' => array(
				'label' => esc_html__('Format:','windmill'),
				'type' => 'select',
				'option' => __utility_get_format(),
				'default' => 'list',
			),
		);

	}// Method


	/* Method
	_________________________
	*/
	public function widget($args,$instance)
	{
		/**
			@access (public)
				Echoes the widget content.
			@param (array) $args
				Display arguments including 'before_title', 'after_title','before_widget', and 'after_widget'.
			@param (object) $instance
				The settings for the particular instance of the widget.
			@return (void)
			@reference
				[Child]/lib/controller.php
				[Parent]/controller/widget.php
				[Parent]/controller/fragment/widget.php
				[Parent]/inc/setup/constant.php
				[Parent]/template/sidebar/sidebar.php
		*/
		$class = self::$_class;

		/**
		 * @since 1.0.1
		 * 	Get the widget parameters via parent class (_widget_base) method.
		 * @reference
		 * 	[Parent]/model/widget/base.php
		*/
		$param = $this->get_param($instance);

		/**
		 * @since 1.0.1
		 * 	echo $args['before_widget'];
		 * @reference (Beans)
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_section[{$class}]",'div',array('class' => self::$_index));

			/**
			 * @since 1.0.1
			 * 	echo $args['before_title'] . $param['title'] . $args['after_title'];
			 * @reference
			 * 	This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
			*/
			if(!empty($param['title'])){
				self::__the_title($param['title']);
			}

			$r = new WP_Query(
				/**
				 * @since 3.4.0
				 * 	Filters the arguments for the widget.
				 * 	https://developer.wordpress.org/reference/classes/wp_query/
				 * @since 4.9.0
				 * 	Added the `$instance` parameter.
				 * @see WP_Query::get_posts()
				 * @param (array) $args
				 * 	An array of arguments used to retrieve the recent posts.
				 * @param (array) $instance
				 * 	Array of settings for the current widget.
				*/
				array(
					'posts_per_page' => esc_attr($param['number']),
					'meta_key' => $this->meta_key,
					'orderby' => 'meta_value_num',
					'ignore_sticky_posts' => TRUE,
					'no_found_rows' => TRUE,
				),$instance);

			/**
			 * @since 1.0.1
			 * 	Display a message that posts cannot be found.
			 * @reference
			 * 	[Parent]/inc/trait/theme.php
			*/
			if(!$r->have_posts()){
				self::__the_nopost();
			}

			/**
			 * @since 1.0.1
			 * 	Apply css attribute for template-part file.
			 * @reference (Beans)
			 * 	Hooks a function or method to a specific filter action.
			 * 	https://www.getbeans.io/code-reference/functions/beans_add_filter/
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/card
			 * 	https://getuikit.com/docs/overlay
			 * @reference
			 * 	[Parent]/template-part/item/card.php
			 * 	[Parent]/template-part/item/gallery.php
			 * 	[Parent]/template-part/item/general.php
			 * 	[Parent]/template-part/item/list.php
			*/
			$format = $param['format'];
			beans_add_filter("_class[{$format}][item][unit]",'uk-card uk-inline');

			remove_filter("_class[{$format}][item][image]",['_render_item',"__the_image_list"],PRIORITY['mid-low']);
			beans_add_filter("_class[{$format}][item][image]",'uk-card-media uk-align-center');

			remove_filter("_class[{$format}][item][header]",['_render_item','__the_header'],PRIORITY['mid-low']);
			beans_add_filter("_class[{$format}][item][header]",'uk-card-header uk-padding-small uk-overlay uk-overlay-primary uk-position-bottom');

			/**
			 * @since 1.0.1
			 * 	Widget content.
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/list
			*/
			beans_open_markup_e("_list[{$class}]",'ol',array('class' => 'uk-list uk-padding'));

				// Start the loop.
				while($r->have_posts()) :	$r->the_post();
					get_template_part(SLUG['item'] . $format);
				endwhile;

				/**
				 * @since 1.0.1
				 * 	Only reset the query if a filter is set.
				 * @reference (WP)
				 * 	After looping through a separate query, this function restores the $post global to the current post in the main query.
				 * 	https://developer.wordpress.org/reference/functions/wp_reset_postdata/
				*/
				wp_reset_postdata();

			beans_close_markup_e("_list[{$class}]",'ol');

		/**
		 * @since 1.0.1
		 * 	echo $args['after_widget'];
		*/
		beans_close_markup_e("_section[{$class}]",'div');

	}// Method


	/**
	 * [NOTE]
	 * 	form() method and update() method are defined in the parent class.
	 * @reference
	 * 	[Parent]/controller/widget.php
	 * 	[Parent]/model/widget/base.php
	*/


}// Class
endif;
new _widget_ranking();
