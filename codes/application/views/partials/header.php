        <header>
            <h1>Let’s order fresh items for you.</h1>
<?php
if($this->session->userdata('user_id')){
?>
            <div>
                <a id="signed_in_name" href=""><?=$this->session->userdata('first_name')?></a>
            </div>
<?php
}else{
?>
            <div>
                <a class="signup_btn" href="/signup">Signup</a>
                <a class="login_btn" href="/login">Login</a>
            </div>
<?php
}
?>
        </header>
