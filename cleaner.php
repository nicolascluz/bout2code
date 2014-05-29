<?php
/**
* fonctions inutiles de l'entête
*/
function clean_head() {
   // remove_action('wp_head', 'feed_links', 2); // liens des flux RSS
    remove_action('wp_head', 'feed_links_extra', 3); //  liens des flux RSS supplémentaires
    remove_action('wp_head', 'rsd_link'); // le lien RSD.
    remove_action('wp_head', 'wlwmanifest_link'); //le lien xml Windows Live Writer
    //remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // articles suivants et précédents
    remove_action('wp_head', 'wp_generator'); // Affiche la version de WordPress
   // remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); // Affiche l'url raccourcie

}
add_action('init', 'clean_head');

/* Remove The rel="category" from Category Links */ 
function wpstores_remove_category_rel( $output ) {
// Remove rel attribute from the category list
    return str_replace( ' rel="category tag"', ' rel="tag"', $output );
}
add_filter( 'wp_list_categories', 'wpstores_remove_category_rel' );
add_filter( 'the_category', 'wpstores_remove_category_rel' );

function dequeue_devicepx() {
wp_dequeue_script( 'devicepx' );
}
add_action( 'wp_enqueue_scripts', 'dequeue_devicepx', 20 );
// remove jetpack open graph tags
remove_action('wp_head','jetpack_og_tags');

/*Blacklist Jetpack Modules https://gist.github.com/ParhamG/6494979*/
function blacklist_jetpack_modules( $modules ){
    $jp_mods_to_disable = array(
       //'shortcodes',
         'widget-visibility',
       //'contact-form',
       //'shortlinks',
         'infinite-scroll',
         'wpcc',
         'tiled-gallery',
         'json-api',
       //'publicize',
         'vaultpress',
         'custom-css',
         'post-by-email',
         'widgets',
         'comments',
         'minileven',
         'latex',
         'gravatar-hovercards',
         'enhanced-distribution',
         'notes',
         'subscriptions',
         'stats',
         'after-the-deadline',
       //'carousel',
         'photon',
         'sharedaddy',
         'omnisearch',
         'mobile-push',
         'likes',
         'videopress',
         'gplus-authorship',
         'sso',
         'monitor',
         'markdown',
	 'related-posts',
	 'verification-tools'
    );
 
    foreach ( $jp_mods_to_disable as $mod ) {
        if ( isset( $modules[$mod] ) ) {
            unset( $modules[$mod] );
        }
    }
 
    return $modules;
}
add_filter( 'jetpack_get_available_modules', 'blacklist_jetpack_modules' );
/* query string */
function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
?>