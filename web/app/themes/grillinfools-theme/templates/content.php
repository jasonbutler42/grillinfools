<article <?php post_class(); ?>>
	<section class="archive-content">
		<div class="thumbnail">
			<a href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
				<?php echo featured_image($post->ID, 150, 150, 60); ?>
		<?php else: ?>
				<img src="<?php echo get_template_directory_uri() . "/assets/img/logo-large.png"; ?>" alt="" class="featured-image featured-image-default">
		<?php endif; ?>
			</a>
		</div>
		<div class="archive-wrap">
	  		<header>
	    		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	    		<?php get_template_part('templates/entry-meta'); ?>
	  		</header>
	  		<div class="entry-summary">
	    		<?php the_excerpt(); ?>
	  		</div>
	  	</div>
	  </section>
</article>
