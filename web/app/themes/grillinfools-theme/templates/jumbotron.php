<div class="stage">
<a href="http://live.charbroil.com/articles/grillin-fools?utm_source=scott-thomas-web&utm_medium=article-link&utm_campaign=all-star-blogger" target="_blank" class="allstars seal"></a>
<a href="https://www.pinterest.com/grillinfools/" target="_blank" class="ambassador seal"></a>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
<?php
$jumbotron_posts = jumbotron_number();
$postcount = 0;
for ($i=0; $i < $jumbotron_posts; $i++) { 
	echo '<li data-target="#carousel-example-generic" data-slide-to="' . $i . '"' . ($i==0 ? 'class="active"':"") . '></li>';
}
?>
</ol>
      <div class="carousel-inner" role="listbox">
		<?php
		$args = array( 'posts_per_page' => $jumbotron_posts, 'orderby' => 'date', 'category' => get_cat_ID(featured_category()) );
		$postslist = get_posts( $args );
		foreach ( $postslist as $post ) :
		  setup_postdata( $post ); 
			$postcount++;
		?> 
		<div class="item<?php echo ($postcount == 1 ? ' active':''); ?>">
		<div class="featured-image-wrapper">
			<?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
				<a href="<?php the_permalink(); ?>"><?php featured_image($post->ID, 1170, 600, 80); ?></a>
		    <?php else : ?>
		      		<a href="<?php the_permalink(); ?>" class="featured-image featured-image-default"></a>
		   	<?php endif; ?>
    	</div>
	    <div class="entry-meta-wrap">
<?php get_template_part('templates/author-image'); ?>
	        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	        <?php get_template_part('templates/entry-meta'); ?>
	    </div>
		</div>
<?php
endforeach; 
wp_reset_postdata();
?>
	</div>
	<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>
</div>