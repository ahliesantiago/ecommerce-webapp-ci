<?php
class Products extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Order');
        $this->load->model('Product');
        $this->load->model('Type');
    }

    /* This is for viewing the selected items. Not having a valid product ID in the URL
    will redirect to the catalog homepage. */
    public function index($id = null){
        if($id == null){
        /* Navigating to this URL directly in the address bar without
        a valid product ID will just redirect back to the catalog page.*/
            redirect("/products/category");
        }else{
            $item = $this->Product->get_product_by_id($id);
            if($item == null){
                redirect("/products/category");
            }else{
                $view_data['item'] = $item;
                $view_data['images'] = $this->Product->get_images_by_id($id);
                $category = $this->Product->get_category_of_item($id);
                $view_data['similar_products'] = $this->Product->get_products_filtered($category, "limit");
                
                /* This just checks if the current user already has items in their cart. */
                $current_orders = $this->Order->get_current_order($this->session->userdata('user_id'));
                if($current_orders != null){
                    $view_data['item_count'] = count($current_orders);
                }else{
                    $view_data['item_count'] = "0";
                }
                $this->load->view('products/details', $view_data);
            }
        }
    }

    /* This is used for navigating through the catalog while categorized. */
    public function category($id = null){
        /* This checks the URL for any page parameter/value. */
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
                redirect("/products/category/$selected_category");
            }else{
                /* Else it will not filter by category and all products
                will be considered. */
                $query = $this->Product->get_products();
                $view_data['selected_category'] = array(
                    "id" => null,
                    "type_name" => "Products",
                    "product_count" => count($query)
                );
            }
        }else{
            /* This is triggered when a button navigating to a category
            is clicked - the filtering is set in the model's query. */
            $query = $this->Product->get_products_filtered($id);
            $view_data['selected_category'] = $this->Type->get_categories_and_count_products($id);
        }
        $paginated = $this->Product->paginate($query, $pageNum);
        $view_data['products'] = $paginated['data'];
        $view_data['page_count'] = $paginated['page_count'];
        $view_data['page_number'] = $pageNum;
        /* The below are used for certain parts (e.g. product count,
        category list) of the catalog page. */
        $current_orders = $this->Order->get_current_order($this->session->userdata('user_id'));
        if($current_orders != null){
            $view_data['item_count'] = count($current_orders);
        }else{
            $view_data['item_count'] = "0";
        }
        $view_data['all_categories'] = $this->Type->get_categories_and_count_products("all");
        $view_data['all_products'] = $this->Product->get_products();
        $this->load->view('products/catalog', $view_data);
    }
}
?>