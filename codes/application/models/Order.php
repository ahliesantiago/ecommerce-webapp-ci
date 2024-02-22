<?php
class Order extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->model('User');
        $this->load->model('Product');
    }

    public function get_all_orders(){
        return $this->db->query("SELECT * FROM orders")->result_array();
    }

    public function get_orders_with_info(){
        $orders = $this->db->query("SELECT * FROM orders WHERE is_checked_out = 1")->result_array();
        $order_details = array();
        foreach($orders as $order){
            $user = $this->User->get_user_by_id($order['user_id']);
            $order_details[] = array(
                'id' => $order['id'],
                'user_id' => $order['user_id'],
                'order_status' => $order['order_status'],
                'checked_out_at' => $order['checked_out_at'],
                'total_amount' => $this->Order->get_total_price($order['id']),
                'address' => "TBA BY DEV",
                'name' => $user['first_name'] . " " . $user['last_name']
            );
        }
        return $order_details;
    }

    public function get_current_order_id($user_id){
        /* This will query the current existing order (an order
        not yet checked out) of the logged in user. */
        $query = "SELECT * FROM orders
            WHERE user_id = ? AND is_checked_out = 0";
        $order = $this->db->query($query, $user_id)->row_array();
        return $order['id'];
    }

    public function get_current_order($user_id){
        /* This will query the current existing order (an order
        not yet checked out) of the logged in user. */
        $query = "SELECT *, JSON_EXTRACT(images_json, ?) AS image
            FROM orders
            JOIN order_products
            ON orders.id = order_products.order_id
            JOIN products
            ON order_products.product_id = products.id
            WHERE user_id = ? AND is_checked_out = 0";
        $values = array('$."1"', $user_id);
        return $this->db->query($query, $values)->result_array();
    }

    /* This will be used on the admin's Orders dashboard. */
    public function get_orders_by_status($status){

    }

    public function create_cart($user_id){
        $query = "INSERT into orders (user_id, is_checked_out, order_status, created_at, updated_at)
            VALUES(?, 0, 'In Cart', now(), now())";
        return $this->db->query($query, $user_id)->row_array();
    }

    public function get_cart_by_id($order_id){
        $query = "SELECT * FROM orders
            JOIN order_products
            ON orders.id = order_products.order_id
            JOIN products
            ON order_products.product_id = products.id
            WHERE orders.id = ?";
        return $this->db->query($query, $order_id)->result_array();
    }

    public function get_item_in_cart($order_id, $product_id){
        $query = "SELECT * FROM orders
            JOIN order_products
            ON orders.id = order_products.order_id
            JOIN products
            ON order_products.product_id = products.id
            WHERE orders.id = ?
            AND product_id = ?";
        $values = array($order_id, $product_id);
        return $this->db->query($query, $values)->row_array();
    }

    public function add_item_to_order($order_id, $product_id, $quantity){
        /* This will first check if the product being added is already in the cart. */
        $current_cart_products = $this->Order->get_cart_by_id($order_id);
        $current_products_ids = array();
        foreach($current_cart_products as $product){
            $current_products_ids[] = $product['product_id'];
        }
        /* If the item is already in the cart, the new quantity will
        just be added to the quantity. */
        if(in_array($product_id, $current_products_ids)){
            $item_in_cart = $this->Order->get_item_in_cart($order_id, $product_id);
            $current_quantity = $item_in_cart['quantity'];
            $new_quantity = $current_quantity + $quantity;
            return $this->Order->update_item_in_cart($order_id, $product_id, $new_quantity);
        }else{ /* If not in the cart, this will add the product and the quantity. */
            $query = "INSERT INTO order_products (order_id, product_id, quantity, created_at, updated_at)
                VALUES(?, ?, ?, ?, ?)";
            $values = array($order_id, $product_id, $quantity, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
            return $this->db->query($query, $values);
        }
    }

    /* This function is used on the cart page when changing the quantity of the items,
    and also used when adding an already-added item to the cart. */
    public function update_item_in_cart($order_id, $product_id, $quantity){
        $query = "UPDATE order_products
            SET quantity = ?,
            updated_at = ?
            WHERE order_id = ?
            AND product_id = ?";
        $values = array($quantity, date('Y-m-d H:i:s'), $order_id, $product_id);
        return $this->db->query($query, $values);
    }

    public function get_item_qty_price($order_id){
        $query = "SELECT product_id, price, quantity, (price * quantity) AS item_total
            FROM order_products
            JOIN products
            ON order_products.product_id = products.id
            WHERE order_id = ?";
        return $this->db->query($query, $order_id)->result_array();
    }

    public function get_total_price($order_id){
        $query = "SELECT SUM((price * quantity)) AS total
            FROM order_products
            JOIN products
            ON order_products.product_id = products.id
            WHERE order_id = ?
            GROUP BY order_id";
        $total = $this->db->query($query, $order_id)->row_array();
        return $total['total'];
    }

    public function delete_item($order_id, $product_id){
        $query = "DELETE FROM order_products
            WHERE order_id = ?
            AND product_id = ?";
        $values = array($order_id, $product_id);
        return $this->db->query($query, $values);
    }

    public function delete_order(){
        
    }

    public function checkout(){

    }
}
?>