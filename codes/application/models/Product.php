<?php
class Product extends CI_Model{
    public function get_products(){
        return $this->db->query("SELECT *, JSON_EXTRACT(images_json, ?) AS image FROM products", '$."1"')->result_array();
    }

    public function get_products_filtered($product_type_id, $limit = null){
        $query = "SELECT *, JSON_EXTRACT(images_json, ?) AS image FROM products WHERE product_type_id = ?";
        if($limit != null && $limit == "limit"){
            $query = $query . " LIMIT 5";
        }
        $values = array('$."1"', $product_type_id);
        return $this->db->query($query, $values)->result_array();
    }

    public function paginate($pulled, $pageNum){
        $total_item_count = count($pulled);
        $page_count = ceil($total_item_count/12); // To limit number of items per page to 12
        $twelve_items = array();
        for($item = 0; $item <= $total_item_count; $item++){
            /* My logic here is that each Page# will contain the items within range:
            (Page# * 12) - 11 UP TO (Page# * 12), -1 due to index starting at 0 */
            if($item >= ($pageNum * 12)-11 && $item <= ($pageNum * 12)){
                $twelve_items[] = $pulled[$item-1];
            }
        }
        return array('data' => $twelve_items, 'page_count' => $page_count);
    }

    public function get_product_by_id($id){
        $query = "SELECT *, JSON_EXTRACT(images_json, ?) AS image FROM products WHERE id = ?";
        $values = array('$."1"', $id);
        return $this->db->query($query, $values)->row_array();
    }

    public function get_images_by_id($id){
        $images = array();
        for ($i = 1; $i <= 4; $i++){
            $query = "SELECT JSON_EXTRACT(images_json, ?) AS image FROM products WHERE id = ?";
            $values = array('$."' . $i . '"', $id);
            $image_dir = $this->db->query($query, $values)->row_array();
            if($image_dir['image'] != null){
                $images[] = $image_dir;
            }
        }
        return $images;
    }

    /* This function will be used to get the Product Type ID,
    which will be used to suggest "similar items". */
    public function get_category_of_item($id){
        return $this->db->query("SELECT product_type_id FROM products WHERE id = ?", $id)->row_array();
    }
}
?>