<?php
error_reporting(1);
ini_set('display_errors', true);
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
 
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
	
defined('BASEPATH') OR exit('No direct script access allowed');
require (APPPATH . '/libraries/REST_Controller.php');
require (APPPATH . '/libraries/Format.php');
class jsc_api extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("M_api");
    }

    public function users_get()
    {
        // Users from a data store e.g. database
        $users = [
            ['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
            ['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
        ];

        $id = $this->get( 'id' );

        if ( $id === null )
        {
            // Check if the users data store contains users
            if ( $users )
            {
                // Set the response and exit
                $this->response( $users, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No users were found'
                ], 404 );
            }
        }
        else
        {
            if ( array_key_exists( $id, $users ) )
            {
                $this->response( $users[$id], 200 );
            }
            else
            {
                $this->response( [
                    'status' => false,
                    'message' => 'No such user found'
                ], 404 );
            }
        }
    }
    public function article_get() {
        $datalist = $this->M_api->get_article();
        // print_r($datalist);
        if ($datalist) {
            $respon = array(
                'code'	=> '200',
                'message'	=> 'sukses',
                'data'		=> $datalist
            );
            $this->response($respon, 200);
        } else {
            $respon = array(
                'code'	=> '404',
                'status'	=> 'Tidak ada data article',
                'data'		=> ''
            );
            $this->response($respon, 502);
        }
    }

    public function article_post() {
        
        $datalist = $this->M_api->get_article_by_id($_POST['id']);
        // print_r($datalist);
        if ($datalist) {
            $respon = array(
                'code'	=> '200',
                'message'	=> 'sukses',
                'data'		=> $datalist
            );
            $this->response($respon, 200);
        } else {
            $respon = array(
                'code'	=> '404',
                'status'	=> 'Tidak ada data article',
                'data'		=> ''
            );
            $this->response($respon, 502);
        }
    }
}