<?php
class Products extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Type');
        $this->load->model('Product');
    }

    public function index(){
        redirect("/products/category/");
    }

    public function category($id = null){
        if($id == null){
            if($this->input->post('category')){
                $selected_type = $this->input->post('category', true);
                redirect("/products/category/$selected_type");
            }else{
                $view_data['products'] = $this->Product->get_products();
                $view_data['selected_category'] = array(
                    "type_name" => "Products",
                    "product_count" => count($view_data['products'])
                );
            }
        }else{
            $view_data['products'] = $this->Product->get_products_filtered($id);
            $view_data['selected_category'] = $this->Type->get_categories_and_count_products($id);
        }
        $view_data['categories'] = $this->Type->get_categories_and_count_products("all");
        $view_data['all_products'] = $this->Product->get_products();        
        $this->load->view('products/catalog', $view_data);
    }

    // WIP!!
    // Actual filtering of the table data
    public function changes($pageNum = 1){
        $filters = $this->input->post();
        if(!empty($filters)){
            $query = $this->filter->fetch_filtered($filters);
            $this->session->set_userdata('query', $query);
        }else{
            $query = $this->session->userdata('query');
        }

        $paginated = $this->filter->paginate($pageNum, $query);
        $view_data['items'] = $paginated['data'];
        $view_data['page_count'] = $paginated['page_count'];
        $view_data['page_number'] = $pageNum;
        $this->load->view('partials/table', $view_data);
    }

    public function details($id = null){
        if($id == null){
        /* Navigating to this URL directly in the address bar without
        a valid product ID will just redirect back to the catalog page.*/
            redirect("/products/catalog");
        }
        $this->load->view('products/details');
    }
}
?>