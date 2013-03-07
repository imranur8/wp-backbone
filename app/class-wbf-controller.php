<?php

/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *  @date Date: 2/26/13
 *  @time: 6:24 PM
 *
 *    main controller file for the
 *    wp-backbone
 **/


class WBF_Controller{

    /**
     * _instance class variable
     *
     * Class instance
     *
     * @var null | object
     **/
    private static $_instance = NULL;


    /**
     * get_instance function
     *
     * Return singleton instance
     *
     * @return object
     **/
    static function get_instance() {
        if( self::$_instance === NULL ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     *  Constructs the controller and assigns protected variables to be
     * @param array $params
     */
    public function __construct( array $params = array() ){
        // add shortcode
        add_shortcode("WP-BACKBONE", array(&$this, "wbf_shortcode"));

        // actions
        add_action('admin_notices', array(&$this, "wbf_adminnotice"));

       /**
            * wp-backbone
            * activating actions
            */
        register_activation_hook( WBF_PATH . "/index.php" , array( &$this, 'wbf_plugin_install' ) );

    }

    public function wbf_shortcode($attr){
        $this->wp_backbone_init();
        return  "<div id='wfp_backbone_shortcode'></div>";
    }

    function wp_backbone_init(){

        // load scripts
        if (!is_admin()) {


            // load style
            $id = 'wbf_style';
            $file = sprintf( '%s/style.css', WBF_CSS_URL );
            wp_register_style( $id, $file );
            wp_enqueue_style( $id );



            wp_enqueue_script('jquery');
            wp_enqueue_script('underscore');
            wp_enqueue_script('backbone');


            wp_enqueue_script(
                'app_run',
                WBF_JS_URL . '/app.run.js',
                array(
                    'jquery',
                    'underscore',
                    'backbone'
                ), false, true
            );


            wp_localize_script('app_run', 'WBF_globals', array(
                    'isLogin' => is_user_logged_in(),
                    'domain' => site_url(),
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'jsurl' => WBF_JS_BACKBONE_URL ,
                    'imageurl' => WBF_IMAGES_URL,
                    'backbone_nonce' => wp_create_nonce('backbone_nonce')
                )
            );

        }

    }

   /**
     *
     */
    public function wbf_plugin_install(){

        $page = get_page_by_title( 'WP-BACKBONE' );
        if(empty($page)){

            // Create page object
            $my_post = array(
                'post_title' => 'WP-BACKBONE',
                'post_status' => 'publish',
                'post_type' => "page",
                'post_content' => "[WP-BACKBONE]"
            );

            // Insert the post into the database
            wp_insert_post( $my_post );
        }

        global $wp_rewrite;
        $wp_rewrite->flush_rules();

    }

    function wbf_adminnotice(){

        global $wp_rewrite;
        if ($wp_rewrite->permalink_structure == ''){
            echo '<div class="updated">
                <p>Please use pretty permalinks  to work WP-BACKBONE. <a href="'.site_url().'/wp-admin/options-permalink.php"> Permalinks </a></p></div>';
        }
    }


}
