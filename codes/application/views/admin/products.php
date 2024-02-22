<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <script src="/assets/js/vendor/jquery.min.js"></script>
    <script src="/assets/js/vendor/popper.min.js"></script>
    <script src="/assets/js/vendor/bootstrap.min.js"></script>
    <script src="/assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap-select.min.css">
    <link rel="stylesheet" href="/assets/css/custom/admin_global.css">
    <script src="/assets/js/global/admin_products.js"></script>
</head>
<script>
    $(document).ready(function() {
        // $("form").submit(function(event) {
        //     event.preventDefault();
        //     return false;
        // });
    });
</script>
<body>
    <div class="wrapper">
        <header>
            <h1>Let’s provide fresh items for everyone.</h1>
            <h2>Products</h2>
            <div>
                <a class="switch" href="/products">Switch to Shop View</a>
                <button class="profile">
                    <img src="/assets/images/profile.png" alt="#">
                </button>
            </div>
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle profile_dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div class="dropdown-menu admin_dropdown" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/users/logoff">Logout</a>
                </div>
            </div>
        </header>
        <aside>
            <a href="#"><img src="/assets/images/organi_shop_logo_dark.svg" alt="Organic Shop"></a>
            <ul>
                <li><a href="/dashboards/orders">Orders</a></li>
                <li class="active"><a href="#">Products</a></li>
            </ul>
        </aside>
        <section>
            <form action="" method="post" class="search_form">
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <button class="add_product" data-toggle="modal" data-target="#add_product_modal">Add Product</button>
            <form action="/dashboards/products" method="post" class="categories_form">
                <h3>Categories</h3>
                <ul>
                    <li>
                        <button type="submit" <?= ($selected_category['id'] == null) ? 'class="active"' : ''?>>
                            <span><?=count($all_products)?></span><img src="/assets/images/all_products.png" alt="#"><h4>All Products</h4>
                        </button>
                    </li>
<?php
foreach($all_categories as $category){
?>                  <li>
                        <button type="submit" name="category" value="<?=$category['id']?>" <?= ($category['id'] == $selected_category['id']) ? 'class="active"' : ''?>>
                            <span><?=$category['product_count']?></span><img src="<?=$category['image_dir']?>" alt="<?=$category['type_name']?> icon"><h4><?=$category['type_name']?></h4>
                        </button>
                    </li>
<?php } ?>      </ul>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
            </form>
            <div>
                <table class="products_table">
                    <thead>
                        <tr>
                            <th><h3>All <?=$selected_category['type_name']?> (<?=$selected_category['product_count']?>)</h3></th>
                            <th>ID #</th>
                            <th>Price (₱)</th>
                            <th>Caregory</th>
                            <th>Inventory</th>
                            <th>Sold</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
foreach($products as $product){
?>                      <tr>
                            <td>
                                <span>
                                    <img src=<?=$product['image']?> alt="product image">
                                    <?=$product['name']?>
                                </span>
                            </td>
                            <td><span><?=$product['product_id']?></span></td>
                            <td><span><?=$product['price']?></span></td>
                            <td><span><?=$product['type_name']?></span></td>
                            <td><span><?=$product['inventory']?></span></td>
                            <td><span><?=$product['sold_qty']?></span></td>
                            <td>
                                <span>
                                    <button class="edit_product">Edit</button>
                                    <button class="delete_product">X</button>
                                </span>
                                <form class="delete_product_form" action="/dashboards/delete_product/<?=$product['product_id']?>" method="post">
                                    <p>Are you sure you want to remove this item?</p>
                                    <button type="button" class="cancel_remove">Cancel</button>
                                    <button type="submit">Remove</button>
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                </form>
                            </td>
                        </tr>
<?php } ?>          </tbody>
                </table>
            </div>
        </section>
        <div class="modal fade form_modal" id="add_product_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form class="add_product_form" action="/dashboards/product_update" method="post" data-modal-action="">
                        <input type="hidden" class="form_data_action" name="action" value="add_product">
                        <h2>Add a Product</h2>
                        <ul>
                            <li>
                                <input type="text" name="product_name" required>
                                <label>Product Name</label>
                            </li>
                            <li>
                                <textarea name="description" required></textarea>
                                <label>Description</label>
                            </li>
                            <li>
                                <label>Category</label>
                                <select class="selectpicker">
<?php
foreach($all_categories as $category){
?>                                  <option><?=$category['type_name']?></option>
<?php } ?>                      </select>
                            </li>
                            <li>
                                <input type="number" name="price" value="1" required>
                                <label>Price</label>
                            </li>
                            <li>
                                <input type="number" name="inventory" value="1" required>
                                <label>Inventory</label>
                            </li>
                            <li>
                                <label>Upload Images (4 Max)</label>
                                <ul class="image_preview_list">
                                    <li><button type="button" class="upload_image"></button></li>
                                </ul>
                                <input type="file" class="image_input" name="image" accept="image/*">
                            </li>
                        </ul>
                        <button type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit">Save</button>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                    </form>
                </div>
            </div>
        </div>
        <section id="nav">
            <nav>
                <!-- <a href="/"><img src="/assets/images/left.svg" data-nav="previous" alt=""></a> -->
<?php for($i = 1; $i <= $page_count; $i++){ ?>
                <a href="/dashboards/products<?=($selected_category['id'] != null) ? "/" . $selected_category['id'] : $selected_category['id'] ?>?page=<?=$i?>" <?= ($i == $page_number) ? '"id=selected"' : '' ?>><?=$i?></a>
<?php } ?>      <!-- <a href="/"><img src="/assets/images/right.svg" data-nav="next" alt=""></a> -->
            </nav>
        </section>
    </div>
    <div class="popover_overlay"></div>
</body>
</html>