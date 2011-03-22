<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->

  <footer class="ctnr clearfix">
    <h5><a href="https://www.givmo.com/pages/how_it_works">How does it work?</a></h5>
      <div class="panels">
        <a href="https://www.givmo.com/pages/how_it_works#hiw_1" class="unit thumb">
          <img alt="Hiw_small_1" src="http://www.givmo.com/images/hiw_small_1.jpg?1300813162" />
          <span>People upload pictures of items they no longer want</span>

  </a>    </div>
      <div class="panels">
        <a href="https://www.givmo.com/pages/how_it_works#hiw_2" class="unit thumb">
          <img alt="Hiw_small_2" src="http://www.givmo.com/images/hiw_small_2.jpg?1300813162" />
          <span>Users browse the listings to find items they want</span>
  </a>    </div>
      <div class="panels">
        <a href="https://www.givmo.com/pages/how_it_works#hiw_3" class="unit thumb">

          <img alt="Hiw_small_3" src="http://www.givmo.com/images/hiw_small_3.jpg?1300813162" />
          <span>Karma determines who wins each item</span>
  </a>    </div>
      <div class="panels">
        <a href="https://www.givmo.com/pages/how_it_works#hiw_4" class="unit thumb">
          <img alt="Hiw_small_4" src="http://www.givmo.com/images/hiw_small_4.jpg" />
          <span>The Giver of the item ships it to the Winner</span>
  </a>    </div>

      <div class="panels">
        <a href="https://www.givmo.com/pages/how_it_works#hiw_5" class="unit thumb">
          <img alt="Hiw_small_5" src="http://www.givmo.com/images/hiw_small_5.jpg" />
          <span>The Winner of the item pays only the discounted shipping cost</span>
  </a>    </div>

    <nav class="unit">
      <ul>
        <li><a href="https://www.givmo.com/">Home</a></li>

        <li><a href="https://www.givmo.com/pages/faq">FAQ</a></li>
        <li><a href="https://www.givmo.com/pages/about">About</a></li>
        <li><a href="https://www.givmo.com/pages/contact">Contact</a></li>
      </ul>
    </nav>
  </footer>
  
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
