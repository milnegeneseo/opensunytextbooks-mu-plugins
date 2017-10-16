<?php 
/*Plugin Name: Register Multiple Taxonomies
Description: This plugin allows for multiple taxonomies.
Version: 1.0
License: GPLv2
*/
/**
 * Function @author Bill Erickson
 * @link http://www.billerickson.net/code/register-multiple-taxonomies/
 */
function be_register_taxonomies()
{
    $taxonomies = array(

        array(
            'slug' => 'sunyaffiliation',
            'single_name' => 'SUNY Affiliation',
            'plural_name' => 'SUNY Affiliation',
			'post_type'    => array( 'post','sunyoercourses','dlm_download' ),
            'capabilities' => array(
                'manage_terms' => 'manage_categories',
                'edit_terms' => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_posts',
                'hierarchical' => false,
                'public' => true,
                'show_in_nav_menus' => true,
            )
        ),
		array(
			'slug'         => 'booktype',
			'single_name'  => 'Book Type',
			'plural_name'  => 'Book Types',
			'post_type'    => array( 'post','sunyoercourses','dlm_download' ),
			'hierarchical' => false,
		),
		array(
			'slug'         => 'cartridgetype',
			'single_name'  => 'Course Cartridge Type',
			'plural_name'  => 'Course Cartridge Types',
			'post_type'    => array('sunyoercourses','dlm_download' ),
		),
    );
    foreach ($taxonomies as $taxonomy) {
        $labels = array(
            'name' => $taxonomy['plural_name'],
            'post_type' => array('post', 'sunyoercourses','dlm_download'),
            'singular_name' => $taxonomy['single_name'],
            'search_items' => 'Search ' . $taxonomy['plural_name'],
            'all_items' => 'All ' . $taxonomy['plural_name'],
            'parent_item' => 'Parent ' . $taxonomy['single_name'],
            'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
            'edit_item' => 'Edit ' . $taxonomy['single_name'],
            'update_item' => 'Update ' . $taxonomy['single_name'],
            'add_new_item' => 'Add New ' . $taxonomy['single_name'],
            'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
            'show_in_nav_menus' => true,
            'hierarchical' => false,
            'menu_name' => $taxonomy['plural_name']
        );

        $rewrite = isset($taxonomy['rewrite']) ? $taxonomy['rewrite'] : array('slug' => $taxonomy['slug']);
        $hierarchical = isset($taxonomy['hierarchical']) ? $taxonomy['hierarchical'] : false;

        register_taxonomy($taxonomy['slug'], $taxonomy['post_type'], array(
            'hierarchical' => $hierarchical,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => $rewrite,
        ));
    }

}

add_action('init', 'be_register_taxonomies');
?>