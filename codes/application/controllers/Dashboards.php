<?php
class Dashboards extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        redirect("dashboards/orders");
    }

    public function orders(){
        //add for admin only condition
        $this->load->view('admin/orders');
    }

    public function products(){
        //add for admin only condition
            $this->load->view('admin/products');
    }

    public function add_product(){
        /* This function is triggered when clicking Save in the
        Add Product modal on the admin's dashboard.
        Only admins can navigate to this URL. */
        if($this->session->userdata('user_level') === 1){
            
        }else{ // Redirect back to catalog if signed in user is not an admin.
            redirect("/products/catalog");
        }
    }
}
?>