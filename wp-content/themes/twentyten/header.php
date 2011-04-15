<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="http://www.givmo.com/assets/app.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<!--[if lt IE 9]>
  <link href="https://www.givmo.com/stylesheets/ie/application.css?1302367281" media="screen" rel="stylesheet" type="text/css" />
  <script src="https://www.givmo.com/javascripts/ie/html5.js?1302367281" type="text/javascript"></script>
<![endif]-->
<?php include_once("analytics.php") ?>
</head>

<body <?php body_class(); ?>>
  <header>
    <div class="inner clearfix">
      <a href="https://www.givmo.com" id="logo">Givmo Home</a>
      <nav id="item_nav_2" class="item_nav clearfix">
        <div class="unit">
          <a href="https://www.givmo.com">Back to Givmo &rarr;</a>    
        </div>
      </nav>
    </div>
  </header>  
  
  <div id="main" class="clearfix">
    <div id="page_heading" class="clearfix"><h1><a href="/"><?php bloginfo('name')?></a></h1></div>