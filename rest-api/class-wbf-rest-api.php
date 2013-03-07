<?php
/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *  @date Date: 2/26/13
 *  @time: 1:07 AM
 *
 *   REST API controller  for the
 *   WP-BACKBONE
 *
 **/


class WBF_Rest_Api{

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

        // filters
        add_filter( 'rewrite_rules_array', array(&$this, 'wp_backbone_plugin_rewrite_rules') );
        add_filter( 'query_vars', array(&$this, 'wp_backbone_plugin_insert_query_vars' ) );


        // actions
        add_action("template_redirect", array(&$this, "wbf_rest_api_template"));

    }

    /**
     * Adding new rewrite rules for REST API expose
     * @param $rules
     * @return array
     */
    public function wp_backbone_plugin_rewrite_rules( $rules )
    {

        $base = 'api';

        $json_api_rules = array(
            "$base/(.+)\/(\d*)$" => 'index.php?wbf_endpoint=$matches[1]&wbf_id=$matches[2]',
            "$base/(.+)$" => 'index.php?wbf_endpoint=$matches[1]'

        );

        return array_merge($json_api_rules, $rules);

    }


    /**
     * Adding the id var so that WP recognizes it
     * @param $vars
     * @return array
     */
    function wp_backbone_plugin_insert_query_vars( $vars )
    {
        array_push($vars, 'wbf_endpoint');
        array_push($vars, 'wbf_id');
        return $vars;
    }

    // define the endpoint route
    public function wbf_rest_api_template(){

        $end_point = get_query_var("wbf_endpoint");

        if ($end_point && file_exists(WBF_END_POINT_PATH."/".$end_point.".php")){

            include(WBF_END_POINT_PATH."/".$end_point.".php");
            $method = strtolower($_SERVER['REQUEST_METHOD']);
            if($method){
                $api_endpoint =  new $end_point();
                $this->render_response($api_endpoint->$method());
                exit;
            }
        }
    }

    public function render_response($response){
        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
