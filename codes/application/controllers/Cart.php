<?php
class Cart extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Order');
    }

    /* This displays the user's cart. */
    public function index(){
        if($this->session->userdata('user_id')){
            $current_user_id = $this->session->userdata('user_id');
            $current_orders = $this->Order->get_current_order($current_user_id);
            $current_cart_id = $this->Order->get_current_order_id($current_user_id);
            if($current_orders != null){
                $view_data['current_orders'] = $current_orders;
                $view_data['item_count'] = count($current_orders);
                $view_data['total'] = $this->Order->get_total_price($current_cart_id);
            }else{
                /* Content of the page will be different if the user
                does not currently have any items in their cart. */
                $view_data['current_orders'] = null;
                $view_data['item_count'] = 0;
            }
            $this->load->view('products/cart', $view_data);
        }else{
            /* If a guest user attempts to go to this page, they
            will be redirected to the login page. */
            redirect('/users/login');
        }
    }

    public function add_to_cart(){
        $current_user_id = $this->session->userdata('user_id');
        $product_id = $this->input->post('item_id', true);
        $quantity = $this->input->post('item_qty', true);
        $current_cart_id = $this->Order->get_current_order_id($current_user_id);
        /* If there is no open cart (order that is ongoing / not yet checked out),
        adding an item to their cart will create a new order first. */
        if($current_cart_id == null){
            $this->Order->create_cart($current_user_id);
            $current_cart_id = $this->Order->get_current_order_id($current_user_id);
        }
        // This will add the item to the cart.
        $this->Order->add_item_to_order($current_cart_id, $product_id, $quantity);
        redirect("/product/$product_id");
    }

    /* This is used on the cart page when the quantity of an item is changed. */
    public function update_cart(){
        $current_user_id = $this->session->userdata('user_id');
        $order_id = $this->Order->get_current_order_id($current_user_id);
        $product_id = $this->input->post('item_id', true);
        if($this->input->post('action') == "delete_cart_item"){
            $this->Order->delete_item($order_id, $product_id);
            redirect("/cart");
        }else if($this->input->post('action') == null){
            $quantity = $this->input->post('item_qty', true);
            $this->Order->update_item_in_cart($order_id, $product_id, $quantity);
            redirect("/cart");
        }
    }

    public function checkout(){

    }
}
?>