<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
<?php get_template_part('templates/author-image'); ?>
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
      <aside class="more-home text-center">
        <p><a href="/" class="btn btn-info btn-lg" title="See all the new posts!">I bet you want to see more stuff, right?<br>Check out the homepage with all new posts!</a></p>
      </aside>
      <script src="https://ib.3lift.com/ttj?inv_code=grillinfools_article_sub"></script>
      <?php comments_template('/templates/comments.php'); ?>
    </div>
  </article>
<?php endwhile; ?>
