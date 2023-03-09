<?php

class ILConfiguration {
    
    function __construct() {
        /* add_filter( "single_template", array($this, "il_func_custom_cat_template") ) ; */
        add_action( "wp_enqueue_scripts", array($this, "il_func_enqueue_scripts"));
        add_action( 'init', array($this, 'il_func_register_my_menus' ) );
        add_filter( 'nav_menu_link_attributes', array($this, 'il_func_nav_menu_link_atts'), 10, 4 );
    }
    
    function il_func_nav_menu_link_atts( $atts, $item, $args, $depth ){
        //if( 'backlink' == $atts['href'] ){
        global $il_plugin_path;
        if(strpos($atts['href'], 'backlink') !== FALSE) {
            $atts['href'] = $_SERVER['HTTP_REFERER'];
        }
        return $atts;
    }

    
    function il_func_register_my_menus() {
        register_nav_menus(
            array(
                'iframe-menu' => __( 'iFrame Menu' )
            )
        );
    }   
    
    function il_func_custom_cat_template($single_template) {
        global $il_plugin_path;
        global $post;
        if ( in_category( 'storyline' ) or in_category( 'rise' ) ) {
           $single_template = $il_plugin_path . 'templates/cat_storyline.php';
        } else if ( in_category( 'newsfeed-learning' )) {
           $single_template = $il_plugin_path . 'templates/cat_storyline.php';
        } else if ( in_category( '360-interactive' )) {
           $single_template = $il_plugin_path . 'templates/cat_storyline.php';
        } else if ( in_category( 'newsfeed-lesson')) {
            $single_template = $il_plugin_path . 'templates/cat_newsfeed-lesson.php';
        }
        return $single_template;
    } 
    
    
    function il_func_enqueue_scripts() {
        global $il_plugin_url;
		if ( in_category( 'storyline' ) || in_category( 'newsfeed-learning' ) || in_category( '360-interactive' ) || in_category( 'newsfeed-lesson' ) || in_category( 'rise' ) ) {
			wp_enqueue_style("iframe_learningx", $il_plugin_url."css/iframe_learningx.css");
			wp_enqueue_script('iframe_learningx', $il_plugin_url."js/iframe_learningx.js", array("jquery"));
		}
    }

    
}