<?php
$args = array( 'posts_per_page' => 2, 'offset' => jumbotron_number(), 'orderby' => 'date', 'category' => get_cat_ID(featured_category()) );
$postslist = get_posts( $args );
foreach ( $postslist as $post ) :
  setup_postdata( $post ); ?> 
	<article <?php post_class( 'featured-post' ); ?>>
    	<div class="featured-image-wrapper">
	<?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
		<a href="<?php the_permalink(); ?>"><?php featured_image($post->ID, 550, 325, 80); ?></a>
    <?php else : ?>
      		<a href="<?php the_permalink(); ?>" class="featured-image featured-image-default"></a>
   	<?php endif; ?>
   	<!--
      		<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="author-pic">
	        	<?php echo get_avatar( get_the_author_meta( 'ID' ), 175 ); ?>
	        	<span class="meta meta-author vcard"><i><?php echo get_the_author(); ?></i></span>
    		</a>   	

    		-->




    		<?php get_template_part('templates/author-image'); ?>






    	</div>
	    <div class="entry-meta-wrap">
	        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	        <?php get_template_part('templates/entry-meta'); ?>
			<div class="entry-summary">
	    		<?php the_excerpt(); ?>
	  		</div>
	    </div>
	</article>
<?php
endforeach; 
wp_reset_postdata();
?>