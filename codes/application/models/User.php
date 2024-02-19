<?php
class User extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function get_user_by_id($id){
        return $this->db->query("SELECT * FROM users WHERE id = ?", $id)->row_array();
    }

    public function get_user_by_email($email){
        return $this->db->query("SELECT * FROM users WHERE email = ?", $email)->row_array();
    }

    public function validate_registration($input){
        /* Code Igniter's form validation, based on specified rules */
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]', array('matches' => "Passwords do not match."));

        if(!$this->form_validation->run()){
            return validation_errors('<p class="errors">', '</p>');
        }else if($this->User->get_user_by_email($input['email'])==true){
        /* If initial validation is passed, this will next check if
        the user (email) already exists in the database.*/
            return '<p class="errors">Email already registered.</p>';
        }
    }

    public function add_user($input){
        $query = "INSERT INTO users (first_name, last_name, email, encrypted_password, salt, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?);";
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $encrypted_password = md5($input['password'] . '' . $salt);
        $values = array($input['first_name'], $input['last_name'], $input['email'], $encrypted_password, $salt, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"));
        return $this->db->query($query, $values);
    }

    /* This validation will check both the presence of required fields
    and if the email is found in the database with correct password provided. */
    public function validate_login($input){
        /* Code Igniter's form validation, based on specified rules */
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if(!$this->form_validation->run()){
            return validation_errors('<p class="errors">', '</p>');
        }else{
        /* If initial validation above is passed, this will next check if
        the email exists in the database and if the password matches.*/
            $db_user = $this->User->get_user_by_email($input['email']);
            if($db_user == true){ // if email is found, proceed to compare pw
                $encrypted_input_pw = md5($input['password'] . '' . $db_user['salt']);
                $stored_pw = $db_user['encrypted_password'];
                if($encrypted_input_pw !== $stored_pw){ // Incorrect password - warning is vague for further protection
                    return '<p class="errors">Email or password is incorrect.</p>';
                }
            }else{ // Email not found - warning is vague for further protection
                return '<p class="errors">Email or password is incorrect.</p>';
            }
        }
    }
}
?>