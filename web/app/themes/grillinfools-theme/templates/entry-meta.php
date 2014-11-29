<div class="byline">
	<span class="meta meta-time"><?php echo __('posted', 'roots'); ?> <time class="updated" datetime="<?php echo get_the_time('c'); ?>"><i><?php echo get_the_date(); ?></i></time></span> |
	<span class="meta meat-author vcard"><?php echo __('author', 'roots'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><i><?php echo get_the_author(); ?></i></a></span> |
	<span class="meta meta-comment"><a href="<?php comments_link(); ?>"> <?php comments_number( '<i>no comments</i>', '<i>one</i> comment', '<i>%</i> comments' ); ?></a></span>
</div>