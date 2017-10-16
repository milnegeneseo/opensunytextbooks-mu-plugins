<?php 
/*Plugin Name: OST Custom Functions
Description: This plugin includes functions for Statistics Queries, Author Bios, File Upload MIMEType, and GravityForms validation.
Version: 1.0
License: GPLv2
*/
/**
 * Functions @author Leah M Root
 *
 */
//Allow ePub and mobi file type uploads  -- Leah M Root
add_filter('upload_mimes', 'add_custom_mime_types');
function add_custom_mime_types($mimes)
{

    $new_file_types = array(
        'zip' => 'application/zip',
        'mobi' => 'application/x-mobipocket-ebook',
        'epub' => 'application/epub+zip',
		'csv' => 'text/csv',
		'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
		'xml' => 'application/xml',
		'wxr' => 'application/wxr'
    );

    return array_merge($mimes, $new_file_types);
}

add_filter( 'mime_types', 'wpse_mime_types' );
function wpse_mime_types( $existing_mimes ) {
    // Add csv to the list of allowed mime types
    $existing_mimes['csv'] = 'text/csv';

    return $existing_mimes;
}

add_filter('upload_mimes', 'custom_upload_xml');
 
function custom_upload_xml($mimes) {
    $mimes = array_merge($mimes, array('xml' => 'application/xml'));
    return $mimes;
}
/**********************Added LMRoot for showing ALL tags in WP Editor, not just popular tags *******/
add_filter( 'get_terms_args', 'themeprefix_show_tags' );
 // Show Tags
 function themeprefix_show_tags ( $args ) {
 if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] === 'get-tagcloud' ) {
 unset( $args['number'] );
 $args['hide_empty'] = 0;
 }
 return $args;
 }
 
//Custom Search form that can be inserted into page content via shortcode   - Leah M Root
function wpbsearchform($form)
{

    $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
    <div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="' . esc_attr__('Search') . '" />
    </div>
    </form>';

    return $form;
}

add_shortcode('wpbsearch', 'wpbsearchform');

//Custom Author Bio Excerpt Function  Leah M Root 
function author_excerpt()
{
    $word_limit = 50; // Limit the number of words
    $more_txt = 'read more about:'; // The read more text
    $txt_end = '...'; // Display text end
    $authorName = get_the_author();
    $authorUrl = get_author_posts_url(get_the_author_meta('ID'));
    $authorDescriptionShort = wp_trim_words(strip_tags(get_the_author_meta('description')), $word_limit, $txt_end . '<br /> ' . $more_txt . ' <a href="' . $authorUrl . '">' . $authorName . '</a>');
    return $authorDescriptionShort;
}

//Custom Connection Type Function for Posts to Posts plugin  - Scribu
function my_connection_types()
{
    p2p_register_connection_type(array(
        'name' => 'posts_to_dlm_downloads',
        'from' => 'post',
        'to' => 'dlm_download'
    ));
}

add_action('p2p_init', 'my_connection_types');

//Custom Function for 'Combined Download Counts' of PDF and EPUB file types on single posts (individual book titles) - requires Posts to Posts and Download Monitor plugins  - Leah M Root

function combined_downloads($post_id)
{
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare(
        "SELECT SUM( meta_value ) FROM $wpdb->postmeta AS m
    LEFT JOIN $wpdb->posts AS p 
       ON m.post_id = p.ID
    INNER JOIN {$wpdb->prefix}p2p AS r 
       ON m.post_id = r.p2p_to   
    WHERE m.meta_key = '_download_count'
    AND p.post_type='dlm_download'            
    AND p.post_status = 'publish'
    AND r.p2p_from = %d
    ", $post_id));
}

//Custom Gravity Forms filter to validate Email and limit to .edu domains - INTAKE FORM  - Leah M Root
add_filter('gform_validation_3', 'edu_validation');
function edu_validation($validation_result)
{
    $form = $validation_result["form"];
    if ($_POST['input_12'] != filter_var($_POST['input_12'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.(edu)$/i")))) {
        $validation_result["is_valid"] = false;
        foreach ($form["fields"] as &$field) {
            if ($field["id"] == "12") {
                $field["failed_validation"] = true;
                $field["validation_message"] = "Email address must end in .edu";
                break;
            }
        }
    }

    $validation_result["form"] = $form;
    return $validation_result;
}


//Custom Gravity Forms filter to validate Email and limit to .edu domains - REVIEWER FORM  - Leah M Root
add_filter('gform_validation_4', 'reviewer_edu_validation');
function reviewer_edu_validation($validation_result)
{
    $form = $validation_result["form"];
    if ($_POST['input_12'] != filter_var($_POST['input_12'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.(edu)$/i")))) {
        $validation_result["is_valid"] = false;
        foreach ($form["fields"] as &$field) {
            if ($field["id"] == "12") {
                $field["failed_validation"] = true;
                $field["validation_message"] = "Email address must end in .edu";
                break;
            }
        }
    }

    $validation_result["form"] = $form;
    return $validation_result;
}
?>