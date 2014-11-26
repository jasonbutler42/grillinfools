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





function featured_image($post_id) {
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
	 //echo "featured_image_filename: " . $featured_image_filename . "<br>";
	// Get the local path of the image
	$wpcontent_image_path = dirname(get_attached_file($post_thumbnail_id));
	 
	if (!file_exists($wpcontent_image_path . '/' . $featured_image_filename)) {

		list($width, $height) = getimagesize($wpcontent_image_path . '/' . $image_src_filename);
		$percentage = $featured_width / $width;
		$new_height = $height * $percentage;
		/*
		echo $new_height;
		echo "percentage = " . $percentage . "<br>";
		echo "width of original = " . $width . "<br>";
		echo "height of original = " . $height . "<br>";
		echo "width of new image = " . $featured_width . "<br>";
		echo "height of new image = " . $featured_height . "<br>";
		echo "featured_image_filename = " . $featured_image_filename . "<br>";
		echo "image_src_filename = " . $image_src_filename . "<br>";
*/
		$featured_image = imagecreatetruecolor($featured_width, $new_height);
		$image = imagecreatefrompng($wpcontent_image_path . '/' . $image_src_filename);


	 	imagecopyresized($featured_image, $image, 0, 0, 0, 0, $featured_width, $new_height, $width, $height);
	 	$new_y = $height/2 - $featured_height/2;
	 	$to_crop_array = array('x' =>0 , 'y' => $new_y, 'width' => $featured_width, 'height'=> $featured_height);
		$featured_image = imagecrop($featured_image, $to_crop_array);

		imagefilter($featured_image, IMG_FILTER_GAUSSIAN_BLUR);

		// Save the image.
	    imagejpeg($featured_image, $wpcontent_image_path . '/' . $featured_image_filename, 30);
	 
	    imagedestroy($featured_image);



	}
	//echo '<img src="'  . $image_src_path . '/' . $image_src_filename . '" />';
	echo '<img src="'  . $image_src_path . '/' . $featured_image_filename . '" alt="" class="featured-image">';
}





//grayscale_add_image_size('custom_size', 100, 100, true, true);