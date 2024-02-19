<?php
class Type extends CI_Model{
    public function get_categories(){
        return $this->db->query("SELECT * FROM product_types")->result_array();
    }

    public function get_categories_and_count_products($id){
        $query = "SELECT product_types.id, product_types.type_name AS 'type_name', product_types.image_dir, COUNT(products.id) AS 'product_count' FROM products
            JOIN product_types
            ON products.product_type_id = product_types.id
            GROUP BY product_type_id";
        $value = "";
        if($id != "all"){
            $query = $query . " HAVING product_type_id = ?";
            return $this->db->query($query, $id)->row_array();   
        }else{
            return $this->db->query($query, $value)->result_array();   
        }     
    } 

    public function get_category_by_id($id){
        return $this->db->query("SELECT * FROM product_types WHERE id = ?", $id)->row_array();
    }
}
?>