<?php while (have_posts()) : the_post(); ?>
  
  <article <?php post_class(); ?>>
    <header>
      <!--<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="author-pic"><?php echo get_avatar( get_the_author_meta( 'ID' ), 175 ); ?></a>-->
      <div class="entry-meta-wrap">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php get_template_part('templates/entry-meta'); ?>
      </div>
    </header>
    <div class="article-body-wrap">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
      <footer>
        <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
      </footer>
      <?php comments_template('/templates/comments.php'); ?>
    </div>
  </article>
<?php endwhile; ?>
