<?php if ( function_exists( 'coauthors_posts_links' ) && count( get_coauthors( get_the_id() ) ) > 1) : ?>
<?php
$coauthors = get_coauthors();
$author_count = count($coauthors);
?>
  <div class="author-pic">
<?php foreach( $coauthors as $coauthor ):
    $avatar_url = get_avatar_url ( $coauthor->user_email, $size = '175' ); 
    echo '<div class="author-pic-slice" style="width: ' . 100 / $author_count . '%; background-image:url(' . $avatar_url . ');"></div>';
  endforeach;  ?>
  <span class="meta meta-author meta-authors vcard"><i><?php coauthors_posts_links(); ?></i></span>
  </div>
<?php else: ?>
      <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="author-pic">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 175 ); ?>
        <span class="meta meta-author vcard"><i><?php echo get_the_author(); ?></i></span>
      </a>
<?php endif; ?>