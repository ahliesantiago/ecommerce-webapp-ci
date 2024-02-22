<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="shortcut icon" href="/assets/images/organic_shop_fav.ico" type="image/x-icon">
    <script src="/assets/js/vendor/jquery.min.js"></script>
    <script src="/assets/js/vendor/popper.min.js"></script>
    <script src="/assets/js/vendor/bootstrap.min.js"></script>
    <script src="/assets/js/vendor/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap-select.min.css">
    <link rel="stylesheet" href="/assets/css/custom/global.css">
    <link rel="stylesheet" href="/assets/css/custom/product_dashboard.css">
</head>
<script>
    $(document).ready(function(){
    });
</script>
<body>
    <div class="wrapper">
<?php $this->load->view('partials/header'); ?>
        <aside>
            <a href="/products"><img src="/assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
        </aside>
        <section>
            <form action="" method="post" class="search_form">
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <a class="show_cart" href="/cart">Cart (<?=$item_count?>)</a>
            <form action="/products/category/" method="post" class="categories_form">
                <h3>Categories</h3>
                <ul>
                    <li>
                        <button type="submit" class="active">
                            <span><?=count($all_products)?></span><img src="/assets/images/all_products.png" alt="#"><h4>All Products</h4>
                        </button>
                    </li>
<?php
foreach($all_categories as $category){
?>                  <li>
                        <button type="submit" name="category" value="<?=$category['id']?>">
                            <span><?=$category['product_count']?></span><img src="<?=$category['image_dir']?>" alt="<?=$category['type_name']?> icon"><h4><?=$category['type_name']?></h4>
                        </button>
                    </li>
<?php } ?>      </ul>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
            </form>
            <div>
                <h3>All <?=$selected_category['type_name']?> (<?=$selected_category['product_count']?>)</h3>
                <ul>
<?php
foreach($products as $product){
?>                  <li>
                        <a href="/product/<?=$product['id']?>">
                            <img src=<?=$product['image']?> alt="product image">
                            <h3><?=$product['name']?></h3>
                            <ul class="rating">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <span>36 Rating</span>
                            <span class="price">₱ <?=$product['price']?></span>
                        </a>
                    </li>
<?php } ?>      </ul>
            </div>
        </section>
        <section id="nav">
            <nav>
                <!-- <a href="/"><img src="/assets/images/left.svg" data-nav="previous" alt=""></a> -->
<?php for($i = 1; $i <= $page_count; $i++){ ?>
                <a href="/products/category<?=($selected_category['id'] != null) ? "/" . $selected_category['id'] : $selected_category['id'] ?>?page=<?=$i?>" <?= ($i == $page_number) ? '"id=selected"' : '' ?>><?=$i?></a>
<?php } ?>      <!-- <a href="/"><img src="/assets/images/right.svg" data-nav="next" alt=""></a> -->
            </nav>
        </section>
    </div>
</body>
</html>