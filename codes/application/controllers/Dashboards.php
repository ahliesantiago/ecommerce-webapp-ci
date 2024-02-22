<?php
class Dashboards extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Order');
        $this->load->model('Product');
        $this->load->model('Type');
    }

    public function index(){
        redirect("dashboards/orders");
    }

    public function orders(){
        if($this->session->userdata('user_level') == 1){
            $view_data['orders'] = $this->Order->get_orders_with_info();
            $this->output->enable_profiler(true);
            $this->load->view('admin/orders', $view_data);
        }else{ // Redirect back to catalog if signed in user is not an admin.
            redirect("/products");
        }
    }

    public function products($id = null){
        if($this->session->userdata('user_level') == 0){ // Redirect back to catalog if signed in user is not an admin.
            redirect("/products");
        }else{ // The below will only execute if the signed-in user is an admin.
            if($this->input->get()){
                $pageNum = $this->input->get('page', true);
            }else{
                $pageNum = 1;
            }
            /* This will check and adjust the page's contents according
            to the category selected or specified in the URL.*/
            if($id == null){
                if($this->input->post('category')){
                    /* If category is specified, it will redirect to
                    the chosen category. */
                    $selected_category = $this->input->post('category', true);
                    redirect("/dashboards/products/$selected_category");
                }else{
                    /* Else it will not filter by category and all products
                    will be considered. */
                    $query = $this->Product->get_products_and_types();
                    $view_data['selected_category'] = array(
                        "id" => null,
                        "type_name" => "Products",
                        "product_count" => count($query)
                    );
                }
            }else{
                /* This is triggered when a button navigating to a category
                is clicked - the filtering is set in the model's query. */
                $query = $this->Product->get_products_and_types($id);
                $view_data['selected_category'] = $this->Type->get_categories_and_count_products($id);
            }
            $paginated = $this->Product->paginate($query, $pageNum);
            $view_data['products'] = $paginated['data'];
            $view_data['page_count'] = $paginated['page_count'];
            $view_data['page_number'] = $pageNum;
            /* The below are used for certain parts (e.g. product count,
            category list) of the catalog page. */
            $view_data['all_categories'] = $this->Type->get_categories_and_count_products("all");
            $view_data['all_products'] = $this->Product->get_products();
            $this->load->view('admin/products', $view_data);
        }
    }

    public function product_update(){
        /* This function is triggered when clicking Save in the
        Add Product modal on the admin's dashboard.
        Only admins can navigate to this URL. */
        if($this->session->userdata('user_level') == 1){
            // $this->output->enable_profiler(true);
            if($this->input->post('action') == "add_product"){
                $this->output->enable_profiler(true);
            }else if($this->input->post('action') == "edit_product"){
            }else if($this->input->post('action') == "upload_image"){
                $this->load->view('partials/images');
            }
        }else{ // Redirect back to catalog if signed in user is not an admin.
            redirect("/products");
        }
    }
}
?>