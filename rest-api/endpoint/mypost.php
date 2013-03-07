<?php
/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *  @date Date: 2/26/13
 *  @time: 1:52 AM
 *
 *   REST API ENDPOINT : ( mypost )
 **/

class mypost{

    /**
     * REST API GET method
     * @return array
     */
    public function get(){
        if(isset($_GET['post_name'])){
            global $wpdb;
            $result = array();

            $sql = "SELECT
                        ID,post_title,post_content,post_excerpt
                        FROM $wpdb->posts
                        WHERE post_name ='".$_GET['post_name']."' ";

            $post = $wpdb->get_row($sql);
            if($post){
                return $result[] = $post;
            }
            return $result;
        }
        else{
            $args = array( 'numberposts' => 10 ,
                'post_type'=> "post"
            );

            $id = get_query_var("wbf_id");
            if($id)
                $args['include'] = $id;


            $myposts = get_posts( $args );

            $result = array();
            foreach( $myposts as $post ) :
                $post_data = array('id' => $post->ID,
                    'title' => $post->post_title,
                    'content' =>  $post->post_content,
                    'post_name' =>  $post->post_name,
                    'post_excerpt' => substr($post->post_content, 0 , 200)
                );
                $result[]=$post_data;
            endforeach;
            return $result;
        }
    }

    /**
     * REST API  POST Method : (create and update)
     * @return array
     */
    public function post(){

        if(is_user_logged_in()){
            $result = array();
            $id = get_query_var("wbf_id");

            // create
            if(isset($_POST['method']) && $_POST['method'] == "create"){

                $my_post = array();
                $my_post['post_content'] = $_POST['content'];
                $my_post['post_excerpt'] = $_POST['excerpt'];
                $my_post['post_title'] = $_POST['title'];
                $my_post['post_status'] = "publish";
                $my_post['post_type'] = "post";



                $post_id = wp_insert_post($my_post);

                if($post_id){
                    $post_detail = get_post($post_id);
                    $result['id'] = $post_id;
                    $result['post_name'] = $post_detail->post_name;
                }
                else
                    $result[] = 0;

                return $result;



            }

            // update
            if(isset($_POST['method']) && $_POST['method'] == "update"){

                $my_post = array();
                $my_post['ID'] = $_POST['id'];
                $my_post['post_content'] = $_POST['content'];
                $my_post['post_excerpt'] = $_POST['excerpt'];
                $my_post['post_title'] = $_POST['title'];

                $post_id = wp_update_post( $my_post );
                if($post_id)
                    $result[] = $post_id;
                else
                    $result[] = 0;

                return $result;
            }


        }

    }

    /**
     * REST API DELETE method
     * @return array
     */

    public function delete(){
        if(is_user_logged_in()){
            $id = get_query_var("wbf_id");
            if(!wp_delete_post($id)){
                return array('error' => "Can't Delete This ");
            }else{
                return array('success' => $id);
            }
        }
    }
}
