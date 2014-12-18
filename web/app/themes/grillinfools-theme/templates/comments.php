<?php
  if (post_password_required()) {
    return;
  }
?>

<section id="comments" class="comments">
  <?php if (have_comments()) : ?>
    <h2 class="comments-number"><?php comments_number( '<i>no comments</i>', '<i>one</i> comment', '<i>%</i> comments' ); ?></h2>
      
      <?php wp_list_comments(array(
        'style' => 'div', 
        'short_ping' => true,
        'avatar_size' => 75,
        'max_depth' => 2,
        'walker' => new gf_comment_walker()
      )); ?>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav>
        <ul class="pager">
          <?php if (get_previous_comments_link()) : ?>
            <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'roots')); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'roots')); ?></li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  <?php endif; // have_comments() ?>

  <?php if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert alert-warning">
      <?php _e('Comments are closed.', 'roots'); ?>
    </div>
  <?php endif; ?>

  <?php comment_form(); ?>
</section>
