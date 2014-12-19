<?php while (have_posts()) : the_post(); ?>
	        <?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
	          <div class="featured-image" style="background-image: url('<?php echo featured_image($post->ID, 1170, 400, 60, true); ?>')"></div>
	      <?php else : ?>
	      		<div class="featured-image featured-image-default"></div>
        	<?php endif; ?>
    	<?php //endif; ?>
      <?php endwhile; ?>