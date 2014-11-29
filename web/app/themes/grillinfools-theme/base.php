<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->
  <div class="mega-wrapper">

    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>

    <div class="wrap container" role="document">

      <div class="content">
      <?php while (have_posts()) : the_post(); ?>
        <?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
          <div class="featured-image" style="background-image: url('<?php echo featured_image($post->ID, true); ?>')"></div>
          <?php //echo featured_image($post->ID); ?>
        <?php endif; ?>
      <?php endwhile; ?>
        <main class="main" role="main">
          <?php include roots_template_path(); ?>
        </main><!-- /.main -->
        <?php if (roots_display_sidebar()) : ?>
          <aside class="sidebar" role="complementary">
            <?php include roots_sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->

  <?php get_template_part('templates/footer'); ?>
  <?php wp_footer(); ?>
  </div><!-- /.mega-wrapper -->
</body>
</html>