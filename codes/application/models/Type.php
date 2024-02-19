<?php
class Type extends CI_Model{
    public function get_categories(){
        return $this->db->query("SELECT * FROM product_types")->result_array();
    }
}
?>