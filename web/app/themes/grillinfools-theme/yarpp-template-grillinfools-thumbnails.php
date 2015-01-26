<?php 
/*
YARPP Template: Grillin' Fools Thumbnails
Author: mitcho (Michael Yoshitaka Erlewine)
Description: A simple example YARPP template.
*/
?><h3 class="yarpp-title">Related Posts</h3>
<section class="yarpp-posts">
	
<?php if (have_posts()):?>
	<?php while (have_posts()) : the_post(); ?>
		<a href="<?php the_permalink() ?>" class="yarpp-post" rel="bookmark">
			<section class="yarpp-post-thumbnail">
			<?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
				<?php echo featured_image($post->ID, 150, 150, 60); ?>
		<?php else: ?>
				<img src="<?php echo get_template_directory_uri() . "/assets/img/logo-large.png"; ?>" alt="" class="yarpp-default-image featured-image">
		<?php endif; ?>
			</section>
			<section class="yarpp-post-title"><?php the_title(); ?><!-- (<?php the_score(); ?>)--></section>
		</a>
	<?php endwhile; ?>
<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>
</section>