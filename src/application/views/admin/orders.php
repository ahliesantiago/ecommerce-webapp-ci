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
    <link rel="stylesheet" href="/assets/css/custom/admin_orders.css">
    <script src="/assets/js/global/admin_orders.js"></script>
</head>
<script>
    $(document).ready(function() {
        // $('.profile_dropdown').on('click', function() {
        //     let newTop = $(this).offset().top + $(this).outerHeight();
        //     let newLeft = $(this).offset().left;
            
        //     $('.admin_dropdown').css({
        //         'top': newTop + 'px',
        //         'left': newLeft + 'px'
        //     });
        // });
    });
</script>
<body>
    <div class="wrapper">
        <header>
            <h1>Let’s provide fresh items for everyone.</h1>
            <h2>Orders</h2>
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
                <li class="active"><a href="#">Orders</a></li>
                <li><a href="/dashboards/products">Products</a></li>
            </ul>
        </aside>
        <section>
            <form action="" method="post" class="search_form">
                <input type="text" name="search" placeholder="Search Orders">
            </form>
            <form action="" method="post" class="status_form">
                <h3>Status</h3>
                <ul>
<?php
foreach($type_details as $type){
?>                  <li>
                        <button type="submit">
                            <span><?=$type['count']?></span><img src="/assets/images/<?=$type['order_status']?>_icon.svg" alt="#"><h4><?=$type['order_status']?></h4>
                        </button>
                    </li>
<?php
}
?>
                </ul>
            </form>
            <div>
                <h3>All Orders (36)</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID #</th>
                            <th>Order Date</th>
                            <th>Receiver</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
foreach($orders as $order){
?>                      <tr>
                            <td><span><a href="#"><?=$order['id']?></a></span></td>
                            <td><span><?=date_format(date_create($order['checked_out_at']), 'm-d-o')?></span></td>
                            <td><span><?=$order['name']?><span><?=$order['address']?></span></span></td>
                            <td><span>₱ <?=$order['total_amount']?></span></td>
                            <td>
                                <form action="" method="post">
                                    <select class="selectpicker">
                                        <option <?= ($order['order_status'] == "Pending") ? "selected" : "" ?>>Pending</option>
                                        <option <?= ($order['order_status'] == "On-Process") ? "selected" : "" ?>>On-Process</option>
                                        <option <?= ($order['order_status'] == "Shipped") ? "selected" : "" ?>>Shipped</option>
                                        <option <?= ($order['order_status'] == "Delivered") ? "selected" : "" ?>>Delivered</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
<?php } ?>          </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>