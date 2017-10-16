<?php 
/*Plugin Name: Create SUNY OER Courses Post Type
Description: This plugin registers the 'atd' post type.
Version: 1.0
License: GPLv2
*/

// register custom post type to work with
function sunyoercourses_create_post_type() {
	// set up labels
	$labels = array(
 		'name' => 'SUNY OER Courses',
    	'singular_name' => 'SUNY OER Course',
    	'add_new' => 'Add New SUNY OER Course',
    	'add_new_item' => 'Add New SUNY OER Course',
    	'edit_item' => 'Edit SUNY OER Course',
    	'new_item' => 'New SUNY OER Course',
    	'all_items' => 'All SUNY OER Courses',
    	'view_item' => 'View SUNY OER Course',
    	'search_items' => 'Search SUNY OER Courses',
    	'not_found' =>  'No SUNY OER Courses Found',
    	'not_found_in_trash' => 'No SUNY OER Courses found in Trash', 
    	'parent_item_colon' => '',
    	'menu_name' => 'SUNY OER Courses',
    );
    //register post type
	register_post_type( 'sunyoercourses', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'author', 'excerpt', 'custom-fields', 'thumbnail','revisions', 'post-formats'),
		'taxonomies' => array( 'post_tag', 'category' ),	
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'suny-oer-courses' ),
		'menu_position'  => 5,
		)
	);
}
add_action( 'init', 'sunyoercourses_create_post_type' );

?>