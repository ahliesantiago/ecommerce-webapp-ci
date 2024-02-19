<?php
class Users extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('User');
    }

    public function index(){
        if($this->session->userdata('user_id')){
            redirect('/products/catalog');
        }else{
            redirect('/users/login');
        }
    }

    public function login(){
        if($this->session->userdata('user_id')){
            redirect('/products');
        }else{
            $this->output->enable_profiler(true);
            $this->load->view('/users/login');
        }
    }

    public function process_login(){
        $input = $this->input->post(null, true);
        $result = $this->User->validate_login($input);
        if($result == null){
            /* <- success - input is good and signed-in user session will be started */
            $signed_in_user = $this->User->get_user_by_email($input['email']);
            $this->session->set_flashdata('signin', 'success');
            $this->session->set_userdata(array(
                'user_id' => $signed_in_user['id'],
                'user_level' => $signed_in_user['is_admin'],
                'first_name' => $signed_in_user['first_name']
            ));
            redirect("/dashboard");
        }else{
            $this->session->set_flashdata('errors', $result);
            redirect("/login");
        }
    }

    public function signup(){
        $this->load->view('/users/signup');
    }

    public function register(){
        $input = $this->input->post(null, true);
        $result = $this->User->validate_registration($input);
        if($result == null){ // <- success - user will get added to the database
            $this->User->add_user($input);
            $this->session->set_flashdata('registered', 'success');
            redirect("/users/login");
        }else{
            $this->session->set_flashdata('errors', $result);
            redirect("/users/signup");
        }
    }

    /* Work in progress */
    public function profile(){
        if($this->session->userdata('user_id')){
            $this->load->view('/users/profile');
        }else{
            redirect('/users/login');
        }
    }

    public function logoff(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_level');
        $this->session->unset_userdata('first_name');
        redirect("/");
    }
}
?>