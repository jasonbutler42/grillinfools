<h4>This is the jumbo tron</h4>
<?php
$args = array( 'posts_per_page' => 3, 'orderby' => 'date', 'category' => get_cat_ID(featured_category()) );
$postslist = get_posts( $args );
foreach ( $postslist as $post ) :
  setup_postdata( $post ); ?> 
	<div>
		<?php //the_date(); ?>
		<br />
		<p><?php the_title(); ?>   </p>
		<?php //the_excerpt(); ?>
	</div>
<?php
endforeach; 
wp_reset_postdata();
?>