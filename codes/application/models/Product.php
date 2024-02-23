<?php
class Product extends CI_Model{
    public function get_products(){
        return $this->db->query("SELECT *, JSON_EXTRACT(images_json, ?) AS image FROM products", '$."1"')->result_array();
    }

    public function get_products_filtered($product_type_id, $limit = null){
        $query = "SELECT *, JSON_EXTRACT(images_json, ?) AS image
            FROM products
            WHERE product_type_id = ?";
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

    public function get_products_and_types($id = null){
        if($id == null){
            return $this->db->query("SELECT *, products.id AS product_id, JSON_EXTRACT(images_json, ?) AS image
                FROM products
                JOIN product_types
                ON products.product_type_id = product_types.id
                ORDER BY product_id", '$."1"')->result_array();
        }else{
            $query = "SELECT *, products.id AS product_id, JSON_EXTRACT(images_json, ?) AS image
                FROM products
                JOIN product_types
                ON products.product_type_id = product_types.id
                WHERE product_type_id = ?
                ORDER BY product_id";
            $values = array('$."1"', $id);
            return $this->db->query($query, $values)->result_array();
        }
    }

    public function add_product($input){
        $images = '';
        if(!empty($uploaded_images)){
            $uploaded_images = $input['image'];
            $images = '{';
            foreach($uploaded_images as $image){
                $i = 1;
                $images[] =  '"' . $i . '": "' . $image_dir . '"';
                // {"1": "/assets/images/products/Lettuce.jpg", "2": "/assets/images/products/Lettuce2.jpg", "3": "/assets/images/products/Lettuce3.webp"}
            }
            $images = '}';
        }else{
            $images = '{"1": "/assets/images/products/Placeholder - Food.png"}';
        }
        $query = "INSERT INTO products (product_type_id, name, price, description, images_json, inventory, sold_qty, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values = array($input['category'], $input['product_name'], $input['price'], $input['description'], $images, $input['inventory'], 0, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        return $this->db->query($query, $values);
    }

    public function edit_product($input, $product_id){
        $query  = "UPDATE products
            SET product_type_id = ?, name = ?, price = ?, description = ?, inventory = ?, updated_at = ?
            WHERE id = ?";
        $values = array($input['category'], $input['product_name'], $input['price'], $input['description'], $input['inventory'], 0, date('Y-m-d H:i:s'), $product_id);
        // $images = '';
        // if(!empty($uploaded_images)){
        //     // to add images later
        // }else{
        //     $images = '{"1": "/assets/images/products/Placeholder - Food.png"}';
        // }
        return $this->db->query($query, $values);
    }
}
?>