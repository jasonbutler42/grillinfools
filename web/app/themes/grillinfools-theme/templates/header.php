<?php if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) : ?>
<header class="banner navbar navbar-default navbar-static-top navbar-mobile" role="banner" style="background-image: url(<?php echo featured_image($post->ID, 768, 600, 60, true); ?>);">
<?php else : ?>
<header class="banner navbar navbar-default navbar-static-top navbar-mobile" role="banner">
  <?php endif; ?>
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="logo"><?php include(get_template_directory() . "/assets/img/logo-min.svg"); ?><img class="logo-svg-alt" src="<?php echo get_template_directory_uri() . "/assets/img/logo-large.png"; ?>" alt="logo" title=""><?php bloginfo('name'); ?></span></a>
      <div class="tagline"><?php echo get_bloginfo ( 'description' ); ?></div>
    </div>
    <nav class="collapse navbar-collapse navbar-primary" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>
    <nav class="collapse navbar-collapse navbar-category" role="navigation">
      <?php
        if (has_nav_menu('category_navigation')) :
          wp_nav_menu(array('theme_location' => 'category_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>
  </div>
</header>

<header class="banner navbar navbar-static-top navbar-full" role="banner">
  <nav class="navbar-primary" role="navigation">
    <?php get_template_part('templates/searchform'); ?>
    <div class="container">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </div>

  </nav>
  <nav class="navbar-category" role="navigation">
    <div class="container">
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="logo"><?php include(get_template_directory() . "/assets/img/logo-min.svg"); ?><img class="logo-svg-alt" src="<?php echo get_template_directory_uri() . "/assets/img/logo-large.png"; ?>" alt="logo" title=""><?php bloginfo('name'); ?></span></a>
      <div class="category-navigation-wrap">
      <?php
        if (has_nav_menu('category_navigation')) :
          wp_nav_menu(array('theme_location' => 'category_navigation', 'menu_class' => 'nav nav-justified'));
        endif;
      ?>
      </div>
    </div>
  </nav>
  <div class="container"><div class="tagline"><?php echo get_bloginfo ( 'description' ); ?></div></div>
</header>