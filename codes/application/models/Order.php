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
                'total_amount' => "TBA BY DEV",
                'address' => "TBA BY DEV",
                'name' => $user['first_name'] . " " . $user['last_name']
            );
        }
        return $order_details;
    }

    public function get_current_order($order_id){
        return $this->db->query("SELECT * FROM orders WHERE id = ?", $order_id)->row_array();
    }

    public function get_order_by_status($status){

    }
}
?>