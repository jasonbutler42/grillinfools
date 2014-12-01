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
	list($source_width, $source_height) = getimagesize($wpcontent_image_path . '/' . $image_src_filename);
	//echo "\n<p>Debugging things</p>\n";
	
	// Set the aspect ratio for original
	$source_aspect_ratio = $source_width / $source_height;

	if ($source_width / $featured_width > $source_height / $featured_height) {
		$resizing_ratio = $source_width / $featured_width;
	} else {
		$resizing_ratio = $source_height / $featured_height;
	}

	$resized_width = $source_width / $resizing_ratio;
	$resized_height = $source_height / $resizing_ratio;

	//check to see if our dimensions are enough to cover the full featured image
	if ($resized_width < $featured_width) {
		$resized_width = $featured_width;
		$resized_height = $resized_width / $source_aspect_ratio; 
	} else if ($resized_height > $featured_height) {
		$resized_height = $featured_height;
		$resized_width = $resized_height / $source_aspect_ratio;
	}

	/****************************************/
	/*       Build the actual image         */
	/****************************************/

	// Create the blank new featured image object
	$featured_image = imagecreatetruecolor($resized_width, $resized_height);
	
	// Create image to be manipulated from source image
	switch ($source_image_ext) {
		case 'jpg':
			$image = imagecreatefromjpeg($wpcontent_image_path . '/' . $image_src_filename);
			break;
		case 'png':
			$image = imagecreatefrompng($wpcontent_image_path . '/' . $image_src_filename);
			break;
	}	
	// resize the created source image and put it in the feature image object
	imagecopyresampled($featured_image, $image, 0, 0, 0, 0, $resized_width, $resized_height, $source_width, $source_height);

	// create crop array (source x, source y, featured x, featured y)
	$new_x = ($resized_width - $featured_width) / 2;
	$new_y = ($resized_height - $featured_height) / 2;
	$to_crop_array = array('x' => $new_x , 'y' => $new_y, 'width' => $featured_width, 'height'=> $featured_height);

	// crop the image
	$featured_image = imagecrop($featured_image, $to_crop_array);

	// if we are enlarging a small image, blur it to reduce jpeg artifacting
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