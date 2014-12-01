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












function featured_image($post_id, $featured_width=400, $featured_height = 1170, $quality = 60, $url=false) {
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


	if ($url) {
		return $image_src_path . '/' . $featured_image_filename;
	} else {
		echo '<img src="'  . $image_src_path . '/' . $featured_image_filename . '" alt="" class="featured-image">';
	}
}

add_action('body_class', 'if_featured_image_class' );
function if_featured_image_class($classes) {
	if ( has_post_thumbnail() && strlen($img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ) {
		array_push($classes, 'has-featured-image');
	}
	return $classes;
}