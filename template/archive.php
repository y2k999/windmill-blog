<?php
/**
 * The template for displaying archive(card style/one column).
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
 * [CASE]
 * 5. Apply one column template for archive page.
 * 
 * @since 1.0.1
 * 	Copy from original archive template ([Parent]/template/content/archive.php) and modify it.
 * 	 - Remove get_sidebar() function call.
 * 	 - Adjust column width.
 * @reference (Uikit)
 * 	https://getuikit.com/docs/grid
 * @reference
 * 	[Child]/archive.php
 * 	[Parent]/controller/layout.php
 * 	[Parent]/controller/render/column.php
 * 	[Parent]/controller/render/container.php
 * 	[Parent]/controller/render/grid.php
 * 	[Parent]/controller/render/section.php
 * 	[Parent]/inc/setup/constant.php
*/
?>
<?php do_action(HOOK_POINT['content']['before']); ?>

<!-- ====================
	<site-content>
 ==================== -->
<section<?php echo apply_filters("_property[section][content]",''); ?>>
<div id="content"<?php echo apply_filters("_property[container][content]",esc_attr('site-content')); ?><?php echo apply_filters("_attribute[container][content]",''); ?>>

	<?php do_action(HOOK_POINT['content']['prepend']); ?>

	<div class="uk-grid uk-grid-small uk-child-width-expand"<?php echo apply_filters("_attribute[grid]",''); ?>>

		<?php do_action(HOOK_POINT['primary']['before']); ?>

		<!-- ====================
			<primary>
		 ==================== -->
		<main id="primary" class="site-main"<?php echo apply_filters("_attribute[column][primary]",''); ?>>
			<?php
			/**
				@hooked
					_fragment_title::__the_page()
				@reference
					[Parent]/controller/fragment/title.php
			*/
			do_action(HOOK_POINT['primary']['prepend']);

			/**
			 * @reference (WP)
			 * 	Determines whether current WordPress query has posts to loop over.
			 * 	https://developer.wordpress.org/reference/functions/have_posts/
			 * 	Iterate the post index in the loop.
			 * 	https://developer.wordpress.org/reference/functions/the_post/
			 * 	Loads a template part into a template.
			 * 	https://developer.wordpress.org/reference/functions/get_template_part/
			 * @reference
			 * 	[Child]/archive.php
			 * 	[Child]/template-part/content-archive.php
			 * 	[Parent]/template-part/content/content-none.php
			*/
			if(!have_posts()) :
				get_template_part(SLUG['content'] . 'content','none');
			endif;
			?>
			<div class="uk-grid-small uk-grid-match uk-child-width-1-3@m"<?php echo apply_filters("_attribute[grid]",''); ?>>
				<?php
				while(have_posts()) :	the_post();
					get_template_part(SLUG['content'] . 'content','archive');
				endwhile;
				?>
			</div><!-- .grid -->

			<?php
			/**
				@hooked
					_structure_archive::__the_pagination()
				@reference
					[Parent]/controller/structure/archive.php
			*/
			do_action(HOOK_POINT['primary']['append']);
			?>
		</main><!-- #primary -->

		<?php do_action(HOOK_POINT['primary']['after']); ?>

		<?php
		/**
			@since 1.0.1
				Unset get_sidebar() call for the one column view;
			// get_sidebar():
		*/
		?>
	</div><!-- .row -->

	<?php do_action(HOOK_POINT['content']['append']); ?>

</div><!-- #content-->
</section>

<?php do_action(HOOK_POINT['content']['after']); ?>
