<?php
class Carts extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if($this->session->userdata('user_id')){
            // add if admin option
            // this is if not admin option
            $this->load->view('products/cart');
        }else{
            redirect('/users/login');
        }
    }

    public function add_to_cart(){

    }

    public function checkout(){

    }

    public function remove(){
        
    }
}
?>