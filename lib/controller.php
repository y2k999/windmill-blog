<?php
/**
 * Load applications according to the settings and conditions.
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
 * 	_widget_cta()
 * 	_widget_ranking()
 * 	_app_ticker()
 * 	__windmill_blog_elapsed_date()
 * 	__windmill_blog_estimated_time()
 * 	fixed_footer
 * 
 * @reference (Beans)
 * 	Set beans_add_action() using the callback argument as the action ID.
 * 	https://www.getbeans.io/code-reference/functions/beans_add_smart_action/
*/


	/**
	 * [CASE]
	 * 	2. Add new modules (applications and widgets).
	 * @since 1.0.1
	 * 	Render the CTA widget on posts.
	 * @reference
	 * 	[Child]/lib/model/cta.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/template-part/content/content.php
	*/
	beans_add_smart_action(HOOK_POINT['single']['body']['append'],function()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(is_singular('post')){

			/**
			 * @since 1.0.1
			 * 	Call CTA widget.
			 * @reference (WP)
			 * 	Output an arbitrary widget as a template tag.
			 * 	https://developer.wordpress.org/reference/functions/the_widget/
			*/
			the_widget('_widget_cta');
		}
	},PRIORITY['mid-low']);


	/**
	 * [CASE]
	 * 	2. Add new modules (applications and widgets).
	 * @since 1.0.1
	 * 	Render the popular posts widget on sidebar.
	 * @reference
	 * 	[Child]/lib/model/ranking.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/template/sidebar/sidebar.php
	*/
	beans_add_smart_action(HOOK_POINT['secondary']['append'],function()
	{
		/**
		 * @since 1.0.1
		 * 	Call Popular posts widget.
		 * @reference (WP)
		 * 	Output an arbitrary widget as a template tag.
		 * 	https://developer.wordpress.org/reference/functions/the_widget/
		*/
		the_widget('_widget_ranking');
	});


	/**
	 * [CASE]
	 * 	2. Add new modules (applications and widgets).
	 * @since 1.0.1
	 * 	Render the ticker application on topbar.
	 * @reference
	 * 	[Child]/lib/model/ticker.php
	*/
	beans_add_smart_action('_column[_structure_header][branding]_after_markup',function()
	{
		/**
		 * @since 1.0.1
		 * 	Echo news ticker besides the site title on topbar.
		 * @hook target
		 * 	_column[_structure_header][branding]_after_markup
		 * @reference
		 * 	[Parent]/controller/structure/header.php
		 * 	[Parent]/model/wrap/branding.php
		*/

		/**
		 * @since 1.0.1
		 * 	Check if the setting is activated on theme customizer.
		 * @reference (WP)
		 * 	Retrieves theme modification value for the current theme.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mod/
		 * @reference
		 * 	[Child]/lib/customizer.php
		*/
		if(get_theme_mod('setting_WB_header_ticker')){
			_app_ticker::__the_template();
		}
	},99);


	/**
	 * [CASE]
	 * 	3. Add new post meta.
	 * @since 1.0.1
	 * 	In this child theme, render new meta items(elapsed date).
	*/
	beans_add_smart_action("_item[_fragment_meta][single][updated]_after_markup",'__windmill_blog_elapsed_date');
	beans_add_smart_action("_item[_fragment_meta][archive][updated]_after_markup",'__windmill_blog_elapsed_date');
	beans_add_smart_action("_item[_fragment_meta][home][updated]_after_markup",'__windmill_blog_elapsed_date');
	if(function_exists('__windmill_blog_elapsed_date') === FALSE) :
	function __windmill_blog_elapsed_date()
	{
		/**
		 * @since 1.0.1
		 * 	Add the elapsed date in post meta list after the last updated time.
		 * @hook target
		 * 	_item[_fragment_meta][{$post_type}][updated]_after_markup
		 * @reference
		 * 	[Parent]/controller/fragment/meta.php
		 * 	[Parent]/model/app/meta.php
		*/

		/**
		 * @since 1.0.1
		 * 	Check if the setting is activated on theme customizer.
		 * @reference (WP)
		 * 	Retrieves theme modification value for the current theme.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mod/
		 * @reference
		 * 	[Child]/lib/customizer.php
		*/
		if(!get_theme_mod('setting_WB_meta_elapsed')){return;}

		/**
		 * @since 1.0.1
		 * 	Get icon's html.
		 * @reference
		 * 	[Parent]/inc/utility/general.php
		 * 	[Parent]/model/data/icon.php
		*/
		$icon = __utility_get_icon('clock');

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_item[windmill-blog][elapsed]",'li',array('class' => 'uk-width-auto uk-margin-small-top elapsed'));

			$time_string = '<span class="elapsed-date">%1$s</span>';
			$time_string = sprintf($time_string,
				/**
				 * @reference (WP)
				 * 	Determines the difference between two timestamps.
				 * 	https://developer.wordpress.org/reference/functions/human_time_diff/
				 * 	Retrieve the time at which the post was written.
				 * 	https://developer.wordpress.org/reference/functions/get_the_time/
				 * 	Retrieves the current time based on specified type.
				 * 	https://developer.wordpress.org/reference/functions/current_time/
				*/
				human_time_diff(get_the_time('U'),current_time('timestamp')) . esc_html__('ago','windmill'),
			);
			$elapsed = sprintf(
				/* translators: %s: post date */
				__('<span class="screen-reader-text">Elapsed date</span> %s','windmill'),
				'<a href="' . esc_url(get_permalink()) . '" target="_blank" rel="bookmark">' . $time_string . '</a>'
			);

			/* WPCS: XSS OK. */
			beans_open_markup_e("_label[windmill-blog][elapsed]",'span',array('class' => 'elapsed-date'));
				beans_output_e("_output[windmill-blog][elapsed]",$icon . $elapsed);
			beans_close_markup_e("_label[windmill-blog][elapsed]",'span');

		beans_close_markup_e("_item[windmill-blog][elapsed]",'li');

	}// Method
	endif;


	/**
	 * [CASE]
	 * 	3. Add new post meta.
	 * @since 1.0.1
	 * 	In this child theme, render new meta items(estimated time).
	 * @reference
	 * 	[Parent]/controller/fragment/meta.php
	 * 	[Parent]/model/app/meta.php
	*/
	beans_add_smart_action("_item[_fragment_meta][single][updated]_after_markup",'__windmill_blog_estimated_time');
	beans_add_smart_action("_item[_fragment_meta][archive][updated]_after_markup",'__windmill_blog_estimated_time');
	beans_add_smart_action("_item[_fragment_meta][home][updated]_after_markup",'__windmill_blog_estimated_time');
	if(function_exists('__windmill_blog_estimated_time') === FALSE) :
	function __windmill_blog_estimated_time()
	{
		/**
		 * @since 1.0.1
		 * 	Add the estimated time to read in post meta list after the last updated time.
		 * @hook target
		 * 	_item[_fragment_meta][{$post_type}][updated]_after_markup
		 * @reference
		 * 	[Parent]/controller/fragment/meta.php
		 * 	[Parent]/inc/utility/general.php
		 * 	[Parent]/model/app/meta.php
		*/

		/**
		 * @since 1.0.1
		 * 	Check if the setting is activated on theme customizer.
		 * @reference (WP)
		 * 	Retrieves theme modification value for the current theme.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mod/
		 * @reference
		 * 	[Child]/lib/customizer.php
		*/
		if(!get_theme_mod('setting_WB_meta_estimated')){return;}

		// Get current post data.
		$post = __utility_get_post_object();

		$letter = mb_strlen(strip_tags($post->post_content));
		$time = array();
		$m = floor($letter / 600) + 1;
		$s = floor($letter % 600 / (600 / 60));

		$time['min'] = $m === 0 ? '' : $m;
		$time['sec'] = $s === 0 ? '' : $s;

		/**
		 * @since 1.0.1
		 * 	Get icon's html.
		 * @reference
		 * 	[Parent]/inc/utility/general.php
		 * 	[Parent]/model/data/icon.php
		*/
		$icon = __utility_get_icon('download');

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_item[windmill-blog][estimated]",'li',array('class' => 'uk-width-auto uk-margin-small-top estimated'));
			$time_string = '<span class="estimated-time">%1$s</span>';
			$time_string = sprintf($time_string,
				esc_html($time['min']) . esc_html__('minute','windmill') . esc_html($time['sec']) . esc_html__('second','windmill'),
			);
			$estimated = sprintf(
				/* translators: %s: post date */
				__('<span class="screen-reader-text">Elapsed date</span> %s','windmill'),
				'<a href="' . esc_url(get_permalink()) . '" target="_blank" rel="bookmark">' . $time_string . '</a>'
			);

			/* WPCS: XSS OK. */
			beans_open_markup_e("_label[windmill-blog][estimated]",'span',array('class' => 'estimated-time'));
				beans_output_e("_output[windmill-blog][elapsed]",$icon . $estimated);
			beans_close_markup_e("_label[windmill-blog][estimated]",'span');

		beans_close_markup_e("_item[windmill-blog][estimated]",'li');

	}// Method
	endif;


	/**
	 * [CASE]
	 * 	4. Add sticky footer bar.
	 * @since 1.0.1
	 * 	Load the footer bar after colophone (site footer) section.
	 * @reference
	 * 	[Child]/template/tailbar.php
	 * 	[Parent]/inc/customizer/option.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/utility/general.php
	*/
	if(__utility_get_option('fixed_footer')){
		beans_add_smart_action(HOOK_POINT['colophone']['after'],function(){
			/**
			 * @reference (WP)
			 * 	Loads a template part into a template.
			 * 	https://developer.wordpress.org/reference/functions/get_template_part/
			*/
			get_template_part('template/tailbar');
		});
	}


	/**
	 * @reference (Beans)
	 * 	Hooks a function or method to a specific filter action.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_filter/
	 * @reference (WP)
	 * 	Removes a callback function from a filter hook.
	 * 	https://developer.wordpress.org/reference/functions/remove_filter/
	*/
	remove_filter('_property[section][masthead]',['_render_section','__the_masthead'],PRIORITY['mid-low']);
	beans_add_filter('_property[section][masthead]',function()
	{
		$html = array(
			'class' => 'uk-section-secondary uk-section-xsmall uk-padding-remove uk-margin-remove'
		);
		echo ' ' . __utility_markup($html);

	});

