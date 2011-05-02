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

  <footer> 
    <div class="line"> 
      <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FGivmo%2F168806286481136&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="float:right; border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe> 
    </div> 
    <div class="ctnr clearfix"> 
      <h2>How does it work?
        <a href="https://www.givmo.com/pages/how_it_works">learn more &rarr;</a> 
      </h2> 

        <div class="panels"> 
          <a href="https://www.givmo.com/pages/how_it_works#hiw_1" class="unit thumb"> 
            <img alt="" src="https://www.givmo.com/images/hiw_small_1.jpg" /> 
            <span>To benefit a charity, Givers post stuff they want to give away, for free</span> 
  </a>      </div> 
        <div class="panels"> 
          <a href="https://www.givmo.com/pages/how_it_works#hiw_2" class="unit thumb"> 
            <img alt="" src="https://www.givmo.com/images/hiw_small_2.jpg" /> 
            <span>Users can request any item they want, also for free</span> 
  </a>      </div> 
        <div class="panels"> 
          <a href="https://www.givmo.com/pages/how_it_works#hiw_3" class="unit thumb"> 
            <img alt="" src="https://www.givmo.com/images/hiw_small_3.jpg" /> 
            <span>Karma and chance determine the Winner</span> 
  </a>      </div> 
        <div class="panels"> 
          <a href="https://www.givmo.com/pages/how_it_works#hiw_4" class="unit thumb"> 
            <img alt="" src="https://www.givmo.com/images/hiw_small_4.jpg" /> 
            <span>The Giver of the item ships it to the Winner</span> 
  </a>      </div> 
        <div class="panels"> 
          <a href="https://www.givmo.com/pages/how_it_works#hiw_5" class="unit thumb"> 
            <img alt="" src="https://www.givmo.com/images/hiw_small_5.jpg" /> 
            <span>The Winner pays only the discounted shipping cost, and a charity gets $1</span> 
  </a>      </div> 

      <nav class="unit"> 
        <ul> 
          <li><a href="https://www.givmo.com/pages/how_it_works">How it works</a></li> 
          <li><a href="https://www.givmo.com/pages/faq">FAQ</a></li> 
          <li><a href="http://blog.givmo.com">Blog</a></li> 
          <li><a href="https://www.givmo.com/pages/about">About</a></li> 
          <li><a href="https://www.givmo.com/pages/contact">Contact</a></li> 
        </ul> 
      </nav> 

    </div> 
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
