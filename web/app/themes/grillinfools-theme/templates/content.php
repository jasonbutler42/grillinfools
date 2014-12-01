<article <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
		<?php echo featured_image($post->ID, 550, 320, 90); ?>
	<?php endif; ?>
  <header class="container">
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
