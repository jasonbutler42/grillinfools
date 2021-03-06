<?php
/**
 * Clean up the_excerpt()
 */
function roots_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'roots') . '</a>';
}
add_filter('excerpt_more', 'roots_excerpt_more');

/**
 * Manage output of wp_title()
 */
function roots_wp_title($title) {
  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  return $title;
}
add_filter('wp_title', 'roots_wp_title', 10);


/**********************************/
/*        Custom Login Page       */
/**********************************/

// Custom css

add_filter( 'style_loader_src', 'hijack_login_src', 10, 2 );
function hijack_login_src( $src, $handle ) {
    if( 'login' == $handle ) {
     	if (WP_ENV === 'development') {
		$assets = array(
    		'css'       => '/assets/css/main.css',
    	);
  	} else {
    	$get_assets = file_get_contents(get_template_directory() . '/assets/manifest.json');
    	$assets     = json_decode($get_assets, true);
    	$assets     = array(
      		'css'       => '/assets/css/main.min.css?' . $assets['assets/css/main.min.css']['hash'],
    	);
  	}
         //$src = VP_URL . 'voodoo-login.css';
  		$src = get_template_directory_uri() . $assets['css'];
     }
     return $src;
 }



  
// Custom URL if you click the logo on the login page
function gf_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'gf_login_logo_url' );

// Custom title for the login page logo
function gf_login_logo_url_title() {
	return 'Get back to Grillin\'';
}
add_filter( 'login_headertitle', 'gf_login_logo_url_title' );

/**********************************/
/*       Custom Admin Stuff       */
/**********************************/
/*
 * Remove the WordPress Logo from the WordPress Admin Bar
 */
function remove_wp_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'remove_wp_logo' );

/*
 * Change the Admin Bar logo
 */
function change_adminbar_logo() {
	$change_adminbar_logo = '<style type="text/css">
	.wp-admin #wpadminbar #wp-admin-bar-site-name > .ab-item:before {
		content:"";
		background-position: center 4px;
		background-repeat: no-repeat;
		padding: 0;
		display: block;
		background-image: url(\'/favicon-32x32.png\') !important;
		-webkit-background-size: 20px;
		background-size: 20px;
		height: 24px;
		width: 20px;
	}
	</style>';
	echo $change_adminbar_logo;
}
/* wp-admin area */
if ( is_admin() ) {
	add_action( 'admin_head', 'change_adminbar_logo' );
}
/* websites */
if ( !is_admin() ) {
	add_action( 'wp_head', 'change_adminbar_logo' );

}

/**********************************/
/*      Featured Image Stuff      */
/**********************************/
// homepage featured four columns

add_image_size( 'Home Image', 350, 250, array('left','top') ); 




function featured_image($post_id, $featured_width=400, $featured_height = 1170, $quality = 60, $url=false) {
	//mad props to this blog post: http://spotlesswebdesign.com/blog.php?id=1 for helping me figure out the logic.

	// Get thumbnail ID
	$post_thumbnail_id = get_post_thumbnail_id($post_id);
	 
	// Find thumbnail locations
	$image_src = wp_get_attachment_image_src($post_thumbnail_id, 'fullsize');
	$image_src_path = dirname($image_src[0]);
	$image_src_filename = basename($image_src[0]);
	 
	/****************************************/
	/*    Create featured image filename    */
	/****************************************/
	
	// get extention location
	$image_src_extention_loc = (strripos($image_src_filename, '.') - strlen($image_src_filename));
	
	// create the full filename (filename-300x150_featured.png)
	$featured_image_filename = substr($image_src_filename, 0, $image_src_extention_loc) . '-' . $featured_width . 'x' . $featured_height . '_featured' . substr($image_src_filename, $image_src_extention_loc);
	
	//get the type of file
	$source_image_ext = substr($image_src_filename,$image_src_extention_loc+1);
	
	// Get the local path of the image
	$wpcontent_image_path = dirname(get_attached_file($post_thumbnail_id));




// Let's only do this stuff if the file doesn't already exist
if (!file_exists($wpcontent_image_path . '/' . $featured_image_filename)) {
	/****************************************/
	/*  Determine some stuff about resizing */
	/****************************************/
	// Create image to be manipulated from source image
	switch ($source_image_ext) {
		case 'jpg':
		case 'jpeg':
			$source_image = imagecreatefromjpeg($wpcontent_image_path . '/' . $image_src_filename);
			break;
		case 'png':
			$source_image = imagecreatefrompng($wpcontent_image_path . '/' . $image_src_filename);
			break;
	}	

 	$source_width = imagesx($source_image); 
 	$source_height = imagesy($source_image);
    // Set the aspect ratio for original
	$source_aspect_ratio = $source_width / $source_height;
	
	$featured_aspect_ratio = $featured_width / $featured_height;
	
	if ($source_aspect_ratio > $featured_aspect_ratio) { 
        // source has a wider ratio 
    
        $temp_width = (int)($source_height * $featured_aspect_ratio); 
        $temp_height = $source_height; 
    
        $source_x = (int)(($source_width - $temp_width) / 2); 
        $source_y = 0; 
    
    } else { 
        // source has a taller ratio 
    
        $temp_width = $source_width; 
        $temp_height = (int)($source_width / $featured_aspect_ratio); 
    
        $source_x = 0; 
        $source_y = (int)(($source_height - $temp_height) / 2); 
    
    } 
    $featured_x = 0; 
    $featured_y = 0; 
    
    $source_width = $temp_width; 
    
    $source_height = $temp_height; 
    
    $new_featured_width = $featured_width; 
    
    $new_featured_height = $featured_height; 
    

	/****************************************/
	/*       Build the actual image         */
	/****************************************/

	$featured_image = imagecreatetruecolor($featured_width, $featured_height); 
     
    imagecopyresampled($featured_image, $source_image, $featured_x, $featured_y, $source_x, $source_y, $new_featured_width, $new_featured_height, $source_width, $source_height); 

	if ($source_width < $featured_width || $source_height < $featured_height) {
		imagefilter($featured_image, IMG_FILTER_GAUSSIAN_BLUR);
	}
	// Save the image.
	imagejpeg($featured_image, $wpcontent_image_path . '/' . $featured_image_filename, $quality);
 	// Destroy the image object to free up memory
    imagedestroy($featured_image);
}

	// Output either the image path...
	if ($url) {
		return $image_src_path . '/' . $featured_image_filename;
	} else {
		// ...or the actual HTML itself
		$thumb_id = get_post_thumbnail_id(get_the_ID());
		$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
		echo '<img src="'  . $image_src_path . '/' . $featured_image_filename . '" alt="' . $alt . '" class="featured-image">';
	}
}

add_action('body_class', 'if_featured_image_class' );
function if_featured_image_class($classes) {
	if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) {
		array_push($classes, 'has-featured-image');
	} else {
		//$alt_featured = 'featured-random-' . rand(1,5);
		$alt_featured = 'featured-random-' . (1 + (get_the_ID() % 5));
		array_push($classes, $alt_featured);
	}
	return $classes;
}
//$featured_category = 'Featured Recipes';
/****************************************/
/*           Featured Content           */
/****************************************/

function jumbotron_number() {
	/* set number of slides in jumbotron - this should probably be done with a plugin or something */
	$jumbotron_number = 7;
	return $jumbotron_number;
}

function featured_category() {
	/* set featured category for global use - this should probably be done with a plugin or something */
	$category = 'Featured Recipes';
	return $category;
}

function exclude_category_home( $query ) {
	// Set the category to be listed on the front page	
	$featured = featured_category();
	$featured_category_id = get_cat_ID($featured);
	

	/* remove posts in the set category from showing on the homepage */
	if ( $query->is_home ) {
		$query->set( 'cat', '-' . $featured_category_id );
	}
	return $query;
}
add_filter( 'pre_get_posts', 'exclude_category_home' );


// Get src URL from avatar <img> tag
// function get_avatar_url($author_id, $size){
    // $get_avatar = get_avatar( $author_id, $size );
    // preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    // return ( $matches[1] );
// }

add_action( 'template_redirect', 'wpsites_attachment_redirect' );
function wpsites_attachment_redirect(){
	global $post;
	if ( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent != 0) ) {
		wp_redirect(get_permalink($post->post_parent), 301); // permanent redirect to post/page where image or document was uploaded
		exit;
	} elseif ( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent < 1) ) {   // for some reason it doesnt works checking for 0, so checking lower than 1 instead...
		wp_redirect(get_bloginfo('url'), 302); // temp redirect to home for image or document not associated to any post/page
		exit;       
    }
}

/****************************************/
/*         	     WP Stripe              */
/****************************************/

function sc_change_details( $html, $charge_response ) {
 
    // This is copied from the original output so that we can just add in our own details
    $html = '<div class="sc-payment-details-wrap">';
          
    $html .= '<p>' . __( 'Congratulations. Your payment went through!', 'sc' ) . '</p>' . "\n";
          
    if( ! empty( $charge_response->description ) ) {
        $html .= '<p>' . __( "Thanks for Registering!", 'sc' ) . '</p>';
    }
          

      
    $html .= '<br><strong>' . __( 'Total Paid: $', 'sc' ) . sc_stripe_to_formatted_amount( $charge_response->amount, $charge_response->currency ) . ' ' . '</strong>' . "\n";
      
    $html .= '<p>Your transaction ID is: ' . $charge_response->id . '</p>';
   
    $html .= '<p>Card: ****-****-****-' . $charge_response->source->last4 . '<br>';
    $html .= 'Expiration: ' . $charge_response->source->exp_month . '/' . $charge_response->source->exp_year . '</p>';
      
    if( ! empty( $charge_response->metadata->name ) ) {
        $html .= '<p>Your Name: ' . str_replace('\\', '', $charge_response->metadata->name) . '</p>';
    }
    if( ! empty( $charge_response->metadata->team_name ) ) {
        $html .= '<p>Team Name: ' . str_replace('\\', '', $charge_response->metadata->team_name) . '</p>';
    }
    if( ! empty( $charge_response->metadata->email ) ) {
        $html .= '<p>Email: ' . $charge_response->metadata->email . '</p>';
    }
    if( ! empty( $charge_response->metadata->phone ) ) {
        $html .= '<p>Phone: ' . $charge_response->metadata->phone . '</p>';
    }
    if( ! empty( $charge_response->metadata->additional_comments ) ) {
        $html .= '<p>Additional Comments: ' . str_replace('\\', '', $charge_response->metadata->additional_comments) . '</p>';
    }
      
    $html .= '</div>';
      
    return $html;
      
}
add_filter( 'sc_payment_details', 'sc_change_details', 20, 2 );


