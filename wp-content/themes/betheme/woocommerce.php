<?php
/**
 * The template for displaying all pages.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();
?>
<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

				<?php woocommerce_content(); ?>

		</div>
		
		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags