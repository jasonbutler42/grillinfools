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





function featured_image($post_id, $url=false) {
	// Get thumbnail ID
	$post_thumbnail_id = get_post_thumbnail_id($post_id);
	 
	// Find thumbnail locations
	$image_src = wp_get_attachment_image_src($post_thumbnail_id, 'fullsize');
	$image_src_path = dirname($image_src[0]);
	$image_src_filename = basename($image_src[0]);
	 
	// Create greyscale filename
	$image_src_extention_loc = (strripos($image_src_filename, '.') - strlen($image_src_filename));
	//echo "image_src_filename: " . $image_src_filename . "<br>";
	//echo "image_src_extention_loc: " . $image_src_extention_loc . "<br>";
	$featured_width = 1170;
	$featured_height = 400;
	$featured_image_filename = substr($image_src_filename, 0, $image_src_extention_loc) . '-' . $featured_width . 'x' . $featured_height . '_featured' . substr($image_src_filename, $image_src_extention_loc);
	$featured_image_ext = substr($image_src_filename,$image_src_extention_loc+1);
	//echo "type of file = " . $featured_image_ext;
	//echo "featured_image_filename: " . $featured_image_filename . "<br>";
	// Get the local path of the image
	$wpcontent_image_path = dirname(get_attached_file($post_thumbnail_id));


	if (!file_exists($wpcontent_image_path . '/' . $featured_image_filename)) {

		list($width, $height) = getimagesize($wpcontent_image_path . '/' . $image_src_filename);
		$percentage = $featured_width / $width;
		$new_height = $height * $percentage;
		/*
		echo "\nnew height = " . $new_height . "<br>\n";
		echo "percentage = " . $percentage . "<br>\n";
		echo "width of original = " . $width . "<br>\n";
		echo "height of original = " . $height . "<br>\n";
		echo "width of new image = " . $featured_width . "<br>\n";
		echo "height of new image = " . $featured_height . "<br>\n";
		echo "featured_image_filename = " . $featured_image_filename . "<br>\n";
		echo "image_src_filename = " . $image_src_filename . "<br>\n";
*/
		$featured_image = imagecreatetruecolor($featured_width, $new_height);

		switch ($featured_image_ext) {
			case 'jpg':
				$image = imagecreatefromjpeg($wpcontent_image_path . '/' . $image_src_filename);
				break;
			case 'png':
				$image = imagecreatefrompng($wpcontent_image_path . '/' . $image_src_filename);
				break;
		}	

	 	imagecopyresampled($featured_image, $image, 0, 0, 0, 0, $featured_width, $new_height, $width, $height);
	 	//$new_y = $height/2 - $featured_height/2;
	 	$new_y = $featured_height/1.5;
	 	//echo "new_y = " . $new_y . "<br>/n";
	 	$to_crop_array = array('x' =>0 , 'y' => $new_y, 'width' => $featured_width, 'height'=> $featured_height);
		$featured_image = imagecrop($featured_image, $to_crop_array);
		// if the image is being stretch, blur it to reduce jpeg artifacting
		if ($width <= $featured_width) {
			imagefilter($featured_image, IMG_FILTER_GAUSSIAN_BLUR);
		}

		// Save the image.
	    imagejpeg($featured_image, $wpcontent_image_path . '/' . $featured_image_filename, 60);
	 
	    imagedestroy($featured_image);



	}
	//echo '<img src="'  . $image_src_path . '/' . $image_src_filename . '" />';
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





//grayscale_add_image_size('custom_size', 100, 100, true, true);