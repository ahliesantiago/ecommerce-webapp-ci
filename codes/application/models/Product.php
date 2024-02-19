<?php
class Product extends CI_Model{
    public function get_products(){
        return $this->db->query("SELECT * FROM products")->result_array();
    }

    public function get_products_filtered($id){
        return $this->db->query("SELECT * FROM products WHERE product_type_id = ?", $id)->result_array();
    }
}
?>