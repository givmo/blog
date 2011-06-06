<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

		<div id="primary" class="unit widget-area" role="complementary">
			<ul class="xoxo">
			  <li class="widget-container follow-us clearfix">
			    <h5 class="widget-title">Follow Us</h5>
			    <a href="<?php bloginfo('rss2_url')?>" class="unit"><img src="<?php bloginfo('template_url') ?>/images/rss_32.gif" /></a>
			    <a href="https://twitter.com/#!/givmo" class="follow twitter">Twitter</a>
			    <a href="https://www.facebook.com/pages/Givmo/168806286481136" class="follow facebook">Facebook</a>
			  </li>
			  <li class="widget-container">
			    <h5>About</h5>
			    <p>Givmo is like an online Goodwill or Freecycle on steroids with a charitable twist: give away stuff you don't want and get stuff you do; $1 goes to charity for every item given!</p>
			  </li>


<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

			<li id="search" class="widget-container widget_search">
				<?php get_search_form(); ?>
			</li>

			<li id="archives" class="widget-container">
				<h3 class="widget-title"><?php _e( 'Archives', 'twentyten' ); ?></h3>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</li>

			<li id="meta" class="widget-container">
				<h3 class="widget-title"><?php _e( 'Meta', 'twentyten' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</li>

		<?php endif; // end primary widget area ?>
			</ul>
		</div><!-- #primary .widget-area -->

<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

		<div id="secondary" class="widget-area" role="complementary">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
			</ul>
		</div><!-- #secondary .widget-area -->

<?php endif; ?>
