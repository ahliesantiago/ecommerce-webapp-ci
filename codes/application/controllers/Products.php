<?php
class Products extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Type');
    }

    public function index(){
        $view_data['categories'] = $this->Type->get_categories();
        $this->load->view('products/catalog', $view_data);
    }

    public function category(){
        // TBA - should this be used instead of catalog?
        // apply filtering
    }

    public function details($id = null){
        if($id == null){
        /* Navigating to this URL directly in the address bar without
        a valid product ID will just redirect back to the catalog page.*/
            redirect("/products/catalog");
        }
        //guest user option
        $this->load->view('products/details');
    }
}
?>