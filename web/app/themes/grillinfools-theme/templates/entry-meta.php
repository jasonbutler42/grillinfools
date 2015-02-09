<div class="byline">
<?php if ( function_exists( 'coauthors_posts_links' ) && count( get_coauthors( get_the_id() ) ) > 1) : ?>
<span class="meta meta-author meta-authors vcard"><?php echo __('authors', 'roots'); ?> <?php coauthors_posts_links(); ?><span class="org">GrillinFools</span><span class="role">Author</span></span>
<?php else: ?>
    <span class="meta meta-author vcard"><?php echo __('author', 'roots'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="url fn"><?php the_author_meta( 'display_name' ); ?></a><span class="org">GrillinFools</span><span class="role">Author</span></span>
<?php endif; ?>
	<span class="meta meta-time"><?php echo __('posted', 'roots'); ?> <time class="updated" datetime="<?php echo get_the_time('c'); ?>"><i><?php echo get_the_date(); ?></i></time></span>
	<span class="meta meta-comment"><a href="<?php comments_link(); ?>"> <?php comments_number( '<i>no comments</i>', '<i>one</i> comment', '<i>%</i> comments' ); ?></a></span>
</div>