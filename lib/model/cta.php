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
 * 
 * Inspired by 4536 WordPress theme.
 * @link https://4536.jp
 * @see Chef
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
		register_widget('_widget_cta');
	});


if(class_exists('_widget_cta') === FALSE) :
class _widget_cta extends _widget_base
{
/**
 * [TOC]
 * 	__construct()
 * 	set_field()
 * 	widget()
 * 	 - get_param()
 * 	 - the_image()
 * 	 - the_name()
 * 	 - the_message()
 * 	 - the_icon()
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
	*/
	private static $_class = '';
	private static $_index = '';

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
				Class constructor.
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/widget/base.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$widget_options = array(
			'classname' => 'widget' . self::$_class,
			'description' => '[Windmill Blog]' . ' ' . ucfirst(self::$_index),
			'customize_selective_refresh' => TRUE,
		);

		/**
		 * [CASE]
		 * 	2. Add new modules (applications and widgets).
		 * 	In this case, define and register CTA application that extends parent widget class;
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
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Retrieves a page given its path.
		 * 	https://developer.wordpress.org/reference/functions/get_page_by_path/
		*/
		$page = get_page_by_path('contact',OBJECT,'page');
		if(!is_null($page)){
			$url = get_page_by_path('contact',OBJECT,'page')->ID;
		}
		else{
			/**
			 * @reference (WP)
			 * 	Retrieves the URL for the current site where the front end is accessible.
			 * 	https://developer.wordpress.org/reference/functions/home_url/
			*/
			$url = home_url();
		}

		$user_id = __utility_get_user_id();

		return array(
			'title' => array(
				'label' => esc_html__('Title:','windmill'),
				'type' => 'text',
				'default' => esc_html__('CTA Window','windmill'),
			),
			'message' => array(
				'label' => esc_html__('Message:','windmill'),
				'type' => 'textarea',
				/**
				 * @reference (WP)
				 * 	Retrieves information about the current site.
				 * 	"description" - Site tagline (set in Settings > General)
				 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
				*/
				'default' => get_the_author_meta('description',$user_id),
			),
			'url' => array(
				'label' => esc_html__('Target Link:','windmill'),
				'type' => 'url',
				'default' => $url,
			),
			'image' => array(
				'label' => esc_html__('Image:','windmill'),
				'type' => 'image',
				'default' => __utility_get_option('media_profile'),
			),
			'button' => array(
				'label' => esc_html__('Text on Button:','windmill'),
				'type' => 'text',
				'default' => esc_html__('Get More Info','windmill'),
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
				[Parent]/template/content/singular.php
				[Parent]/template-part/content/content-single.php
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
				// echo $args['before_title'] . $param['title'] . $args['after_title'];
				self::__the_title($param['title']);
			}

			/**
			 * @since 1.0.1
			 * 	widget content.
			 * @reference
			 * 	[Parent]/inc/utility/theme.php
			*/
			beans_open_markup_e("_grid[{$class}]",'div',__utility_get_grid('even',array('class' => self::$_index)));
				// CTA image.
				$this->the_image($param);
				// CTA description.
				$this->the_description($param);
			beans_close_markup_e("_grid[{$class}]",'div');

		/**
		 * @since 1.0.1
		 * 	echo $args['after_widget'];
		*/
		beans_close_markup_e("_section[{$class}]",'div');

	}// Method


	/**
		@access (private)
			Echoes the image.
		@return (void)
		@reference (Uikit)
			https://getuikit.com/docs/image
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
	*/
	private function the_image($param)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Configure the parameter for the application.
		$args = array(
			// 'class' => 'uk-padding-remove-left',
			'width' => '100%',
			'height' => 'auto',
			/* Automatically escaped. */
			'alt' => esc_attr($param['title']),
			'itemprop' => 'image',
		);

		if(__utility_is_uikit()){
			/* Automatically escaped. */
			$args['data-src'] = $param['image'];
			$args['uk-img'] = '';
		}
		else{
			/* Automatically escaped. */
			$args['src'] = $param['image'];
		}

		/**
		 * @reference (Beans)
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_selfclose_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_figure[{$class}][{$function}]",'figure',array('class' => 'uk-padding-remove'));
			beans_open_markup_e("_link[{$class}][{$function}]",'a',array('href' => $param['url']));
				beans_selfclose_markup_e("_src[{$class}][{$function}]",'img',$args);
			beans_close_markup_e("_link[{$class}][{$function}]",'a');
		beans_close_markup_e("_figure[{$class}][{$function}]",'figure');

	}// Method


	/**
		@access (private)
			Echoes the description/message.
		@return (void)
		@reference (Uikit)
			https://getuikit.com/docs/text
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function the_description($param)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_wrapper[{$class}][{$function}]",'div',array('class' => 'uk-padding ' . $function));
			// Message
			beans_open_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'),array('class' => 'uk-text-lead uk-text-success uk-text-small'));
				/**
				 * @reference (WP)
				 * 	Trims text to a certain number of words.
				 * 	https://developer.wordpress.org/reference/functions/wp_trim_words/
				*/
				// beans_output_e("_output[{$class}][{$function}]",mb_strimwidth($param['message'],0,__utility_get_option('excerpt_length'),'c','UTF-8'));
				beans_output_e("_output[{$class}][{$function}]",wp_trim_words($param['message'],__utility_get_option('excerpt_length'),'c'));
			beans_close_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'));

			// Button
			$this->the_button($param);

		beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');

	}// Method


	/**
		@access (private)
			Echoes the button.
		@return (void)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/data/icon.php
	*/
	private function the_button($param)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$icon = __utility_get_icon('phone');

		/**
		 * @reference (Beans)
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_wrapper[{$class}][{$function}]",'div');
			beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
				'class' => __utility_get_option('skin_button_tertiary'),
				'href' => $param['url'],
			));
				beans_output_e("_output[{$class}][{$function}]",$icon . ' ' . $param['button']);

			beans_close_markup_e("_link[{$class}][{$function}]",'a');
		beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');

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
new _widget_cta();
