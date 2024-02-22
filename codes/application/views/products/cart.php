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
    <link rel="stylesheet" href="/assets/css/custom/global.css">
    <link rel="stylesheet" href="/assets/css/custom/cart.css">
    <script src="/assets/js/global/cart.js"></script>
    <script>
        $(document).ready(function(){
            $(document).on('click', 'button.qty_change', function(){
                var item_id = $(this).attr('data-item');
                var current_qty = $('input[data-item="' + item_id + '"]').attr('value');
                var change = $(this).attr('value');
                var new_qty = parseInt(current_qty) + parseInt(change);
                if(new_qty >= 1){
                    $('input[data-item="' + item_id + '"]').attr('value', new_qty);
                    var amount = $('input[data-item="' + item_id + '"]').attr('data-price');
                    $('span[data-item="' + item_id + '"]').html("₱ " + (new_qty * amount).toFixed(2));
                    $('form[id="' + item_id + '"]').submit();
                };
            });
            $(document).on('change', 'input.product_quantity', function(){
                var item_id = $(this).attr('data-item');
                var new_qty = $(this).attr('value');
                var amount = $('input[data-item="' + item_id + '"]').attr('data-price');
                $('span[data-item="' + item_id + '"]').html("₱ " + (new_qty * amount).toFixed(2));
                $('form[id="' + item_id + '"]').submit();
            });
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Let’s order fresh items for you.</h1>
<?php if($this->session->userdata('user_id')){ ?>
            <div>
                <a id="signed_in_name" href=""><?=$this->session->userdata('first_name')?></a>
            </div>
<?php }else{ ?>
            <div>
                <a class="signup_btn" data-toggle="modal" data-target="#signup_modal">Signup</a>
                <a class="login_btn" data-toggle="modal" data-target="#login_modal">Login</a>
            </div>
<?php } ?>
        </header>
        <aside>
            <a href="/"><img src="/assets/images/organic_shop_logo.svg" alt="Organic Shop"></a>
            <!-- <ul>
                <li class="active"><a href="#"></a></li>
                <li><a href="#"></a></li>
            </ul> -->
        </aside>
        <section>
            <form class="search_form">
                <input type="text" name="search" placeholder="Search Products">
            </form>
            <button class="show_cart">Cart (<?=$item_count?>)</button>
<?php
if($current_orders !== null){
?>          <section>
                <div class="cart_items_form">
                    <ul>
<?php foreach($current_orders as $item){ ?>
                        <form id="<?=$item['product_id']?>" action="/cart/update_cart" method="post">
                            <li>
                                <a href="/product/<?=$item['product_id']?>"><img src=<?=$item['image']?> alt=""></a>
                                <a href="/product/<?=$item['product_id']?>"><h3><?=$item['name']?></h3></a>
                                <span>₱ <?=$item['price']?></span>
                                <ul>
                                    <li>
                                        <label>Quantity</label>
                                        <input name="item_qty" data-item="<?=$item['product_id']?>" data-price="<?=$item['price']?>" class="product_quantity" type="number" min-value="1" value="<?=$item['quantity']?>">
                                        <ul>
                                            <li><button type="button" class="increase_decrease_quantity qty_change" data-item="<?=$item['product_id']?>" value="1" data-quantity-ctrl="1"></button></li>
                                            <li><button type="button" class="increase_decrease_quantity qty_change" data-item="<?=$item['product_id']?>" value="-1" data-quantity-ctrl="0"></button></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <label>Total Amount</label>
                                        <span class="total_amount" data-item="<?=$item['product_id']?>">₱ <?=$item['price'] * $item['quantity']?></span>
                                    </li>
                                    <li>
                                        <button type="button" name="action" value="remove" class="remove_item"></button>
                                    </li>
                                </ul>
                                <div>
                                    <p>Are you sure you want to remove this item?</p>
                                    <button type="button" name="action" value="cancel-remove" class="cancel_remove">Cancel</button>
                                    <button type="button" type="submit" name="action" value="confirm-remove" class="remove">Remove</button>
                                </div>
                                <input type="hidden" name="item_id" value="<?=$item['product_id']?>">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                            </li>
                        </form>
<?php } ?>          </ul>
                </div>
                <form class="checkout_form">
                    <h3>Shipping Information</h3>
                    <ul>
                        <li>
                            <input type="text" name="first_name" required>
                            <label>First Name</label>
                        </li>
                        <li>
                            <input type="text" name="last_name" required>
                            <label>Last Name</label>
                        </li>
                        <li>
                            <input type="text" name="address_1" required>
                            <label>Address 1</label>
                        </li>
                        <li>
                            <input type="text" name="address_2" required>
                            <label>Address 2</label>
                        </li>
                        <li>
                            <input type="text" name="city" required>
                            <label>City</label>
                        </li>
                        <li>
                            <input type="text" name="state" required>
                            <label>State</label>
                        </li>
                        <li>
                            <input type="text" name="zip_code" required>
                            <label>Zip Code</label>
                        </li>
                    </ul>
                    <h3>Order Summary</h3>
                    <h4>Items <span id="items_total_price">₱ <?=$total?></span></h4>
                    <h4>Shipping Fee <span>₱ 250</span></h4>
                    <h4 class="total_amount">Total Amount <span>₱ <?=$total + 250?></span></h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#card_details_modal">Proceed to Checkout</button>
                </form>
            </section>
<?php
}else{
?>  <h4>Your cart is currently empty. Let’s <a href="/">order</a> fresh items for you.</h4>
<?php } ?>
        </section>
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#card_details_modal">
            Launch demo modal
        </button> -->
        <div class="modal fade form_modal" id="card_details_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form action="/TBA" method="post">
                        <h2>Card Details</h2>
                        <ul>
                            <li>
                                <input type="text" name="card_name" required>
                                <label>Card Name</label>
                            </li>
                            <li>
                                <input type="number" name="card_number" required>
                                <label>Card Number</label>
                            </li>
                            <li>
                                <input type="month" name="expiration" required>
                                <label>Exp Date</label>
                            </li>
                            <li>
                                <input type="number" name="cvc" required>
                                <label>CVC</label>
                            </li>
                        </ul>
                        <h3>Total Amount <span>$ 45</span></h3>
                        <button type="button">Pay</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade form_modal" id="login_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form action="process.php" method="post">
                        <h2>Login to order.</h2>
                        <button type="button" class="switch_to_signup">New Member? Register here.</button>
                        <ul>
                            <li>
                                <input type="text" name="email" required>
                                <label>Email</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                        </ul>
                        <button type="button">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade form_modal" id="signup_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button data-dismiss="modal" aria-label="Close" class="close_modal"></button>
                    <form action="process.php" method="post">
                        <h2>Signup to order.</h2>
                        <button type="button" class="switch_to_signup">Already a member? Login here.</button>
                        <ul>
                            <li>
                                <input type="text" name="email" required>
                                <label>Email</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                            <li>
                                <input type="password" name="password" required>
                                <label>Password</label>
                            </li>
                        </ul>
                        <button type="button">Signup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="popover_overlay"></div>
</body>
</html>