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

  <div id="footer_container">
    <footer>    
      <div id="nav_extra">
        <a href="https://www.givmo.com/pages/how_it_works">How it works</a> | 
        <a href="https://www.givmo.com/pages/faq">FAQ</a> | 
        <a href="https://www.givmo.com/pages/about">About</a> | 
        <a href="https://www.givmo.com/pages/contact">Contact</a> |
        <a href="http://blog.givmo.com">Blog</a>
      </div>

      <div id="connect">
        <a class="facebook" href="http://www.facebook.com/pages/Givmo/168806286481136">Facebook</a></a>
        <a class="twitter" href="http://www.twitter.com/givmo">Twitter</a>
      </div>

      <br class="clear" />  

      <iframe src="http://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FGivmo%2F168806286481136&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>

    </footer>
  </div>
  
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
