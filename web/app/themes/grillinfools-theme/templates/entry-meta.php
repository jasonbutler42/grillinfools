<div class="byline">
<?php if ( function_exists( 'coauthors_posts_links' ) && count( get_coauthors( get_the_id() ) ) > 1) : ?>
<span class="meta meta-author meta-authors vcard"><?php echo __('authors', 'roots'); ?> <i><?php coauthors_posts_links(); ?></i></span>
<?php else: ?>
    <span class="meta meta-author vcard"><?php echo __('author', 'roots'); ?> <i><?php the_author_posts_link(); ?></i></span>
<?php endif; ?>
	<span class="meta meta-time"><?php echo __('posted', 'roots'); ?> <time class="updated" datetime="<?php echo get_the_time('c'); ?>"><i><?php echo get_the_date(); ?></i></time></span>
	<span class="meta meta-comment"><a href="<?php comments_link(); ?>"> <?php comments_number( '<i>no comments</i>', '<i>one</i> comment', '<i>%</i> comments' ); ?></a></span>
</div>