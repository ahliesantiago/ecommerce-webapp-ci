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
    $(document).ready(function() {
    })
</script>
<body>
    <div class="wrapper">
<?php $this->load->view('partials/header'); ?>
        <aside>
            <a href="/products"><img src="/assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
            <!-- <ul>
                <li class="active"><a href="#"></a></li>
                <li><a href="#"></a></li>
            </ul> -->
        </aside>
        <section >
            <form action="" method="post" class="search_form">
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <a class="show_cart" href="/cart">Cart (0)</a>
            <form action="" method="post" class="categories_form">
                <h3>Categories</h3>
                <ul>
                    <li>
                        <button type="submit" class="active">
                            <span>36</span><img src="/assets/images/all_products.png" alt="#"><h4>All Products</h4>
                        </button>
                    </li>
<?php
foreach($categories as $category){
?>                  <li>
                        <button type="submit">
                            <span>36</span><img src="<?=$category['image_dir']?>" alt="<?=$category['type_name']?> icon"><h4><?=$category['type_name']?></h4>
                        </button>
                    </li>
<?php    
}
?>              </ul>
            </form>
            <div>
                <h3>All Products (46)</h3>
                <ul>
                    <li>
                        <a href="product_view.html">
                            <img src="/assets/images/food.png" alt="#">
                            <h3>Vegetables</h3>
                            <ul class="rating">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <span>36 Rating</span>
                            <span class="price">$ 10</span>
                        </a>
                    </li>
                    <li>
                        <a href="product_view.html">
                            <img src="/assets/images/food.png" alt="#">
                            <h3>Vegetables</h3>
                            <ul class="rating">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <span>36 Rating</span>
                            <span class="price">$ 10</span>
                        </a>
                    </li>
                    <li>
                        <a href="product_view.html">
                            <img src="/assets/images/food.png" alt="#">
                            <h3>Vegetables</h3>
                            <ul class="rating">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <span>36 Rating</span>
                            <span class="price">$ 10</span>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
    </div>
</body>
</html>