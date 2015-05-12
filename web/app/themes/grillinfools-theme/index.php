<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'roots'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php //************** Line 1/2 of TripleLIft Code ***************// ?>
<?php $tl_count = 0; $tl_offset = 2; $tl_interval = 5; $tl_script = '<script src="https://ib.3lift.com/ttj?inv_code=grillinfools_main_feed"></script>'; ?>
<?php while (have_posts()) : the_post(); ?>
      <?php //************** Line 2/2 of TripleLIft Code ***************// ?>
    <?php $tl_count++; if( ($tl_count-$tl_offset) % $tl_interval == 0) { echo $tl_script; } ?>
  <?php get_template_part('templates/content', get_post_format()); ?>
<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li>
    </ul>
  </nav>
<?php endif; ?>
