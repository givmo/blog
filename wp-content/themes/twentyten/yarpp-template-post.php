<?php if ($related_query->have_posts()):?>
</div>
<div class="ctnr widget_yarpp_widget">
  <h4>Related Posts</h4>
  <ul>
    <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
      <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><!-- (<?php the_score(); ?>)--></li>
    <?php endwhile; ?>
  </ul>
<?php endif; ?>