<?php
/**
 * Template part for displaying posts.
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
$index = str_replace(substr(basename(__FILE__,'.php'),0,8),'',basename(__FILE__,'.php'));

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
 * @since 1.0.1
 * 	Copy from original archive template ([Parent]/template-part/content/content-archive.php) and modify it.
 * 	 - Set "uk-card" to post_class() for always card grid displaying.
 * 	 - Set "uk-card-xxx" properties to each sections.
 * @reference (Uikit)
 * 	https://getuikit.com/docs/card
 * @reference
 * 	[Child]/template/archive.php
 * 	[Parent]/inc/setup/constant.php
 * 	[Parent]/model/data/css.php
 * 	[Parent]/model/data/schema.php
 * 	[Parent]/template-part/content/content-archive.php
*/
?>
<!-- ====================
	<article>
 ==================== -->
<article id="post-<?php the_ID(); ?>" <?php post_class('uk-card'); ?>>

	<!-- =============== 
		<entry-header>
	 =============== -->
	<?php do_action(HOOK_POINT[$index]['header']['before']); ?>

	<header class="uk-card-header uk-margin-remove-top entry-header">
		<?php
		do_action(HOOK_POINT[$index]['header']['prepend']);

		/**
		 * @hooked
		 * 	_fragment_title::__the_archive()
		 * @reference
		 * 	[Parent]/controller/fragment/title.php
		*/
		do_action(HOOK_POINT[$index]['header']['main']);

		/**
		 * @hooked
		 * 	_fragment_meta::__the_archive()
		 * @reference
		 * 	[Parent]/controller/fragment/meta.php
		*/
		do_action(HOOK_POINT[$index]['header']['append']);
		?>
	</header>

	<?php do_action(HOOK_POINT[$index]['header']['after']); ?>

	<!-- =============== 
		<entry-content>
	 =============== -->
	<?php do_action(HOOK_POINT[$index]['body']['before']); ?>

	<div class="uk-card-body uk-margin-remove-top uk-position-relative entry-content">
		<?php
		do_action(HOOK_POINT[$index]['body']['prepend']);

		/**
		 * @hooked
		 * 	_structure_archive::__the_excerpt()
		 * @reference
		 * 	[Parent]/controller/structure/archive.php
		*/
		do_action(HOOK_POINT[$index]['body']['main']);
		do_action(HOOK_POINT[$index]['body']['append']);
		?>
	</div><!-- /.entry-content -->

	<?php do_action(HOOK_POINT[$index]['body']['after']); ?>

	<?php do_action(HOOK_POINT[$index]['footer']['before']); ?>

	<?php if(has_action(HOOK_POINT[$index]['footer']['prepend']) || has_action(HOOK_POINT[$index]['footer']['main']) || has_action(HOOK_POINT[$index]['footer']['append'])) : ?>
		<!-- =============== 
			<entry-footer>
		 =============== -->
		<footer class="uk-card-footer uk-margin-remove-top entry-footer">
			<?php
			do_action(HOOK_POINT[$index]['footer']['prepend']);
			do_action(HOOK_POINT[$index]['footer']['main']);
			do_action(HOOK_POINT[$index]['footer']['append']);
			?>
		</footer>
	<?php endif; ?>

	<?php do_action(HOOK_POINT[$index]['footer']['after']); ?>
</article>
