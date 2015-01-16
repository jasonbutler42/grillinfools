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
    <?php if(is_home()):  ?>
    <?php get_template_part('templates/jumbotron'); ?>
    <div class="home-widget">
    <?php if(is_home() && !is_paged()):  ?>
    <?php dynamic_sidebar('home-widget'); ?>
    <?php endif;?>
    </div>
    <?php endif;?>

      <div class="content">
      <?php if (!is_category() && !is_search() && !is_archive() && !is_home()): ?>
      <?php get_template_part('templates/featured-image'); ?>
      <?php endif; ?>
        <main class="main" role="main">
        <?php if(is_home() && !is_paged()):  ?>
          <?php get_template_part('templates/featured'); ?>
        <?php endif;?>
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