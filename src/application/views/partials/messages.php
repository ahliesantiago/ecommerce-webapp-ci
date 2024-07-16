<?php echo $this->session->flashdata('errors');
if($this->session->flashdata('signin')){ ?>
    <p class="success">Welcome, <?=$this->session->userdata('first_name')?>!</p>
<?php }
if($this->session->flashdata('registered')){ ?>
    <p class="success">Registration successful. You can sign in now.</p>
<?php }
if($this->session->flashdata('item_edited')){ ?>
    <p class="success">Product successfully edited.</p>
<?php }
if($this->session->flashdata('item_added')){ ?>
    <p class="success">Product successfully added.</p>
<?php }
if($this->session->flashdata('item_deleted')){ ?>
    <p class="success">Product has been deleted.</p>
<?php }
if($this->session->flashdata('profile_updated')){ ?>
    <p class="success">You have successfully updated your profile.</p>
<?php }
if($this->session->flashdata('pw_updated')){ ?>
    <p class="success">Your password has been updated.</p>
<?php }
if($this->session->flashdata('review_posted')){ ?>
    <p class="success">Review has been posted.</p>
<?php }
if($this->session->flashdata('reply_posted')){ ?>
    <p class="success">Reply has been posted.</p>
<?php }
if($this->session->flashdata('logged_out')){ ?>
    <p class="success">You have been logged out.</p>
<?php } ?>