<?php
/**
 * Simple Social Bar
 * 
 * A simplified and more programattically efficient share bar plugin based off
 * the original work done by mdolon at:
 * 
 * http://wordpress.org/extend/plugins/sharebar/
 * 
 * This plugin functions much in the same, but does not use additional database
 * tables and sticks with WordPress' structure as well as a more efficient implementation
 * that gives greater control over where the plugin is activated and used.
 * 
 * @package dtLabs
 * 
 * @global    object    $wpdb
 * 
 * @author digital-telepathy
 * @version 1.0.1
 */
/*
Plugin Name: Simple Social Bar
Plugin URI: http://www.dtelepathy.com/
Description: A simple, easy to use, easy to configure social share bar that follows you down the page for sharing your posts.
Version: 1.0.1
Author: digital-telepathy
Author URI: http://www.dtelepathy.com
License: GPL2

Copyright 2010 digital-telepathy  (email : support@digital-telepathy.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class SimpleSocialBar {
    var $namespace = "simplesocialbar";
    var $friendly_name = "Simple Social Bar";
    var $version = "1.0.1";
    
    // Default plugin options
    var $defaults = array(
        'post_types' => array( 'post' ),
        'show_horizontal' => true,
        'side' => 'left'
    );
    
    // The buttons available for this plugin to create
    var $available_buttons = array(
        'Facebook' => 'http://developers.facebook.com/docs/reference/plugins/like/',
        'Twitter' => 'http://twitter.com/about/resources/tweetbutton',
        'Buzz' => 'http://www.google.com/buzz/api/admin/configPostWidget',
        'reddit' => 'http://www.reddit.com/buttons',
        'StumbleUpon' => 'http://www.stumbleupon.com/badges/'
    );
    
    // Simple model for new buttons
    var $button_model = array(
        'ID' => "",
        'order' => "",
        'enabled' => false,
        'type' => "",
        'verticaldisplay' => 'big',
        'horizontaldisplay' => 'small',
        'codesnippetbig' => "",
        'codesnippetsmall' => ""
    );
    
    // Additional allowed post tags for validation
    var $customallowedposttags = array(
        'script' => array(
            'type' => array(),
            'src' => array()
        ),
        'iframe' => array(
            'src' => array(),
            'scrolling' => array(),
            'frameborder' => array(),
            'style' => array(),
            'allowTransparency' => array()
        )
    );
    
    /**
     * Instantiation construction
     * 
     * @uses add_action()
     * @uses SimpleSocialBar::route()
     * @uses SimpleSocialBar::wp_register_scripts()
     * @uses SimpleSocialBar::wp_register_styles()
     */
    function __construct() {
        // Directory path to this plugin's files
        $this->dir_name = dirname( __FILE__ );
        // URL path to this plugin's files
        $this->url_path = WP_PLUGIN_URL . "/" . plugin_basename( dirname( __FILE__ ) );
        // Name of the option_value to store plugin options in
        $this->option_name = '_' . $this->namespace . '--options';
        
        add_filter( 'the_content', array( &$this, 'the_content' ) );
        
        add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
        add_action( 'wp_footer', array( &$this, 'wp_footer' ) );
        add_action( 'wp_print_scripts', array( &$this, 'wp_print_scripts' ) );
        add_action( 'wp_print_styles', array( &$this, 'wp_print_styles' ) );
        
        register_post_type( $this->namespace, array(
            'label' => $this->friendly_name,
            'public' => false
        ) );
        
        // Register all scripts for this plugin
        $this->wp_register_scripts();
        
        // Register all scripts for this plugin
        $this->wp_register_styles();
        
        // Route requests for form processing
        $this->route();
    }
    
    /**
     * Define the admin menu options for this plugin
     * 
     * @uses add_action()
     * @uses add_options_page()
     */
    function admin_menu() {
        $page_hook = add_options_page( $this->friendly_name, $this->friendly_name, 'administrator', $this->namespace, array( &$this, 'admin_options_page' ) );
        
        // Add print scripts and styles action based off the option page hook
        add_action( 'admin_print_scripts-' . $page_hook, array( &$this, 'admin_print_scripts' ) );
        add_action( 'admin_print_styles-' . $page_hook, array( &$this, 'admin_print_styles' ) );
    }
    
    
    /**
     * The admin section options page rendering method
     * 
     * @uses current_user_can()
     * @uses wp_die()
     */
    function admin_options_page() {
        if( !current_user_can( 'manage_options' ) ) {
            wp_die( 'You do not have sufficient permissions to access this page' );
        }
        
        $available_buttons = $this->available_buttons;
        $friendly_name = $this->friendly_name;
        $namespace = $this->namespace;
        $saved_buttons = $this->get();
        $url_path = $this->url_path;
        
        $data = get_option( $this->option_name, $this->defaults );
        
        $post_types = get_post_types( array(
            'public' => true
        ), 'objects' );
        
        $buttons = array();
        foreach( array_keys( $available_buttons ) as $available_button ) {
            $buttons[$available_button] = $this->button_model;
            $buttons[$available_button]['type'] = $available_button;
        }
        
        foreach( $saved_buttons as $button_key => $saved_button ) {
            $buttons[$button_key] = $saved_button;
        }
        
        uasort( $buttons, array( &$this, 'order_by_menu_order' ) );
        
        include( "{$this->dir_name}/views/options.php" );
    }
    
    /**
     * Process update page form submissions
     * 
     * @uses SimpleSocialBar::sanitize()
     * @uses wp_redirect()
     * @uses wp_verify_nonce()
     */
    private function admin_options_update() {
        // Verify submission for processing using wp_nonce
        if( wp_verify_nonce( $_REQUEST[$this->namespace . '_update_wpnonce'], $this->namespace . '_options' ) ) {
            $data = array();
            foreach( $_POST as $key => $val ) {
                $data[$key] = $this->sanitize( $val );
            }
            
            foreach( $data['button'] as $button ) {
                $button_meta = serialize( array(
                    'verticaldisplay' => $button['verticaldisplay'],
                    'horizontaldisplay' => $button['horizontaldisplay'],
                    'codesnippetbig' => $button['codesnippetbig'],
                    'codesnippetsmall' => $button['codesnippetsmall']
                ) );
                
                $button_data = array(
                    'ID' => $button['ID'],
                    'post_type' => $this->namespace,
                    'menu_order' => $button['order'],
                    'post_status' => isset( $button['enabled'] ) ? 'publish' : 'draft',
                    'post_title' => $button['type'],
                    'post_content' => $button_meta
                );
                
                wp_insert_post( $button_data );
            }
            
            $data['data']['show_horizontal'] = isset( $data['data']['show_horizontal'] );
            
            update_option( $this->option_name, $data['data'] );
            
            // Redirect back to the options page with the message flag to show the saved message
            wp_redirect( $data['_wp_http_referer'] . '&message=1' );
            exit;
        }
    }

    /**
     * Load JavaScript for the admin options page
     * 
     * @uses wp_enqueue_script()
     */
    function admin_print_scripts() {
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( "{$this->namespace}-admin" );
    }
    
    /**
     * Load Stylesheet for the admin options page
     * 
     * @uses wp_enqueue_style()
     */
    function admin_print_styles() {
        wp_enqueue_style( "{$this->namespace}-admin" );
    }
    
    /**
     * Get the buttons the user has created
     * 
     * Retrieves the buttons from the database stored as the custom post type and
     * returns them in a post-processed associative array format for use in this
     * plugin.
     * 
     * @uses WP_Query
     */
    private function get( $status = 'publish,draft' ) {
        $args = array(
            'post_type' => $this->namespace,
            'posts_per_page' => -1,
            'post_status' => $status,
            'nopaging' => true,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        
        $posts = new WP_Query( $args );
        
        $buttons = array();
        foreach( (array) $posts->posts as $post ) {
            $button_meta = unserialize( $post->post_content );
            $button_type = $post->post_title;
            
            $button = array(
                'ID' => $post->ID,
                'order' => $post->menu_order,
                'enabled' => (boolean) ( $post->post_status == 'publish' ),
                'type' => $button_type,
                'horizontaldisplay' => $button_meta['horizontaldisplay'],
                'verticaldisplay' => $button_meta['verticaldisplay'],
                'codesnippetbig' => $button_meta['codesnippetbig'],
                'codesnippetsmall' => $button_meta['codesnippetsmall']
            );
            
            $buttons[$button_type] = $button;
        }

        return $buttons;
    }
    
    /**
     * Retrieve the stored plugin option or the default if no user specified value is defined
     * 
     * @param string $option_name The name of the TrialAccount option you wish to retrieve
     * 
     * @uses get_option()
     * 
     * @return mixed Returns the option value or false(boolean) if the option is not found
     */
    private function get_option( $option_name ) {
        // Load option values if they haven't been loaded already
        if( !isset( $this->options ) || empty( $this->options ) ) {
            $this->options = get_option( $this->option_name, $this->defaults );
        }
        
        if( isset( $this->options[$option_name] ) ) {
            return $this->options[$option_name];    // Return user's specified option value
        } elseif( isset( $this->defaults[$option_name] ) ) {
            return $this->defaults[$option_name];   // Return default option value
        }
        return false;
    }
    
    /**
     * Initialization function to hook into the WordPress init action
     * 
     * Instantiates the class on a global variable and sets the class, actions
     * etc. up for use.
     */
    function instance() {
        global $SimpleSocialBar;
        
        $SimpleSocialBar = new SimpleSocialBar();
    }
    
    /**
     * Sort an array by menu_order
     * 
     * Accepts a keyed array and sorts by the menu_order value, called by the uasort
     * sorting method.
     * 
     * @param object $a first index of the array
     * @param object $b second index of the array
     */
    private function order_by_menu_order( $a, $b ) {
        return ( $a['order'] > $b['order'] );
    }
    
    /**
     * Route the user based off of environment conditions
     * 
     * This function will handling routing of form submissions to the appropriate
     * form processor.
     */
    private function route() {
        $uri = $_SERVER['REQUEST_URI'];
        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $url = "{$protocol}://{$hostname}{$uri}";
        $is_post = isset( $_POST ) && !empty( $_POST );

        if( $is_post && preg_match( "/options\-general\.php\?page\=" . $this->namespace . "/", $uri ) ) {
            $this->admin_options_update();
        }
    }
    
    /**
     * Sanitize data
     * 
     * @param mixed $str The data to be sanitized
     * 
     * @uses wp_kses()
     * 
     * @return mixed The sanitized version of the data
     */
    private function sanitize( $str ) {
        if ( !function_exists( 'wp_kses' ) ) {
            require_once( ABSPATH . 'wp-includes/kses.php' );
        }
        global $allowedposttags;
        global $allowedprotocols;
        
        $allowedposttags = $allowedposttags + $this->customallowedposttags;
        $allowedposttags['a']['data-count'] = array();
        $allowedposttags['a']['data-related'] = array();
        $allowedposttags['a']['data-via'] = array();
        $allowedposttags['a']['data-url'] = array();
        $allowedposttags['a']['data-button-style'] = array();
        
        if ( is_string( $str ) ) {
            $str = wp_kses( $str, $allowedposttags, $allowedprotocols );
        } elseif( is_array( $str ) ) {
            $arr = array();
            foreach( (array) $str as $key => $val ) {
                $arr[$key] = $this->sanitize( $val );
            }
            $str = $arr;
        }
        
        return $str;
    }
    
    /**
     * Hook into the the_content filter
     * 
     * Output the ShareBar horizontal code above the post for anchoring the
     * vertical ShareBar and displaying the horizontal ShareBar code.
     * 
     * @global $post;
     * 
     * @uses SimpleSocialBar::get_option()
     * @uses SimpleSocialBar::get()
     */
    function the_content( $content ) {
        global $post;
        
        $namespace = $this->namespace;
        $direction = "horizontal";
        $buttons = array();
        
        if( $this->get_option( 'show_horizontal' ) == true ) {
            if( in_array( $post->post_type, $this->get_option( 'post_types' ) ) ) {
                $buttons = $this->get( 'publish' );
            }
        }
        
        $html = "";
        // Don't prepend the share bar if this isn't a single post page
        if( is_single() ) {
            ob_start();
                include( "{$this->dir_name}/views/sharebar.php" );
                $html .= ob_get_contents();
            ob_end_clean();
        }
        
        return $html . $content;
    }
    
    /**
     * Hook into WordPress wp_print_styles action
     * 
     * Prints the appropriate stylesheets on public pages for valid post types
     * 
     * @global $post
     * 
     * @uses is_admin()
     * @uses SimpleSocialBar::get_option()
     * @uses wp_enqueue_style()
     */
    function wp_print_styles() {
        global $post;
        
        // Only enqueue these scripts on the front end
        if( is_admin() ) {
            return false;
        }
        
        // Only enqueue these styles if this is a post type we have specified
        if( in_array( $post->post_type, $this->get_option( 'post_types' ) ) ) {
            wp_enqueue_style( $this->namespace );
        }
    }
    
    /**
     * Hook into WordPress wp_print_scripts action
     * 
     * Prints the appropriate scripts on public pages for valid post types
     * 
     * @global $post
     * 
     * @uses is_admin()
     * @uses SimpleSocialBar::get_option()
     * @uses wp_enqueue_script()
     */
    function wp_print_scripts() {
        global $post;
        
        // Only enqueue these scripts on the front end
        if( is_admin() ) {
            return false;
        }
        
        // Only enqueue these scripts if this is a post type we have specified
        if( in_array( $post->post_type, $this->get_option( 'post_types' ) ) ) {
            wp_enqueue_script( $this->namespace );
        }
    }
    
    /**
     * Hook into WordPress wp_footer action
     * 
     * Outputs the share bar element for display on the page next to the post.
     * 
     * @uses is_admin()
     * @uses SimpleSocialBar::get_option()
     */
    function wp_footer() {
        global $wp_query;
        
        // Only enqueue these scripts on the front end
        if( is_admin() ) {
            return false;
        }
        
        if( in_array( $wp_query->post->post_type, $this->get_option( 'post_types' ) ) ) {
            $buttons = $this->get( 'publish' );
            $namespace = $this->namespace;
            $direction = "vertical";
            $side = $this->get_option( 'side' );
            $permalink = get_permalink( $wp_query->post->ID );
            
            foreach( (array) $buttons as $type => $button ) {
                switch( $type ) {
                    // Add the URL for the post to Facebook like buttons
                    case "Facebook":
                        $facebook_url_pattern = "/((http|https)\:\/\/www\.facebook\.com\/plugins\/like\.php*(($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*)/";
                        preg_match( $facebook_url_pattern, $button['codesnippetbig'], $codesnippetbig_matches );
                        preg_match( $facebook_url_pattern, $button['codesnippetsmall'], $codesnippetsmall_matches );

                        if( !empty( $codesnippetbig_matches ) ){
                            $url = $codesnippetbig_matches[0];
                            $parse_url = parse_url( $url );
                            parse_str( html_entity_decode( $parse_url['query'], ENT_QUOTES ), $query_vars );
                            
                            if( empty( $query_vars['href'] ) ) {
                                $query_vars['href'] = urlencode( $permalink );
                                $facebook_url_match = "{$parse_url['scheme']}://{$parse_url['host']}{$parse_url['path']}?" . http_build_query( $query_vars );
                                $buttons[$type]['codesnippetbig'] = preg_replace( $facebook_url_pattern, $facebook_url_match, $button['codesnippetbig'] );
                            }
                        }

                        if( !empty( $codesnippetsmall_matches ) ){
                            $url = $codesnippetsmall_matches[0];
                            $parse_url = parse_url( $url );
                            parse_str( html_entity_decode( $parse_url['query'], ENT_QUOTES ), $query_vars );
                            
                            if( empty( $query_vars['href'] ) ) {
                                $query_vars['href'] = urlencode( $permalink );
                                $facebook_url_match = "{$parse_url['scheme']}://{$parse_url['host']}{$parse_url['path']}?" . http_build_query( $query_vars );
                                $buttons[$type]['codesnippetsmall'] = preg_replace( $facebook_url_pattern, $facebook_url_match, $button['codesnippetsmall'] );
                            }
                        }
                    break;
                }
            }
            
            include( "{$this->dir_name}/views/sharebar.php" );
        }
    }
    
    /**
     * Register scripts used by this plugin for enqueuing elsewhere
     * 
     * @uses wp_register_script()
     */
    function wp_register_scripts() {
        // Admin JavaScript
        wp_register_script( "{$this->namespace}-admin", "{$this->url_path}/javascripts/{$this->namespace}-admin.js", array( 'jquery', 'jquery-ui-sortable' ), $this->version, true );
        
        // Public JavaScript
        wp_register_script( "{$this->namespace}", "{$this->url_path}/javascripts/{$this->namespace}.js", array( 'jquery' ), $this->version, true );
    }
    
    /**
     * Register styles used by this plugin for enqueuing elsewhere
     * 
     * @uses wp_register_style()
     */
    function wp_register_styles() {
        // Admin Stylesheet
        wp_register_style( "{$this->namespace}-admin", "{$this->url_path}/stylesheets/{$this->namespace}-admin.css", array(), $this->version, 'screen' );
        
        // Public Stylesheet
        wp_register_style( "{$this->namespace}", "{$this->url_path}/stylesheets/{$this->namespace}.css", array(), $this->version, 'screen' );
    }
}

// Initiatie the SimpleSocialBar class at the WordPress init action
add_action( 'init', array( 'SimpleSocialBar', 'instance' ) );
?>