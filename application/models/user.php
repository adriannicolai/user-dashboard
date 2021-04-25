<?php
defined('BASEPATH') OR exit('no direct script access allowed!');

class user extends CI_Model
{
    /* This code returns the number of users registered in our database
        author: Adrian */
    function get_number_of_registered_users()
    {
        return $this->db->query('SELECT * FROM thewallv2.users')->num_rows();
    }
    /* this is to validate the registration form */
    function validate_registration()
    {
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[users.email]',
                                           array('required' => 'Email cannot be blank', 'valid_email' => 'Please enter a valid email', 'is_unique' => 'This email already exists'));
        $this->form_validation->set_rules('first_name', 'first_name', 'trim|required|alpha_numeric_spaces',
                                           array('required' => 'First Name cannot be blank', 'alpha_numeric_spaces' => 'First Name cannot contain any numbers'));
        $this->form_validation->set_rules('last_name', 'last_name', 'trim|required|alpha_numeric_spaces',
                                           array('required' => 'Last Name cannot be blank', 'alpha_numeric_spaces' => 'Last Name cannot contain any numbers'));
        $this->form_validation->set_rules('password1', 'password1', 'trim|min_length[8]|required',
                                           array('required' => 'Password cannot be blank', 'min_length' => 'Password must be at least 8 characters long'));
        $this->form_validation->set_rules('password2', 'password2', 'trim|matches[password1]',
                                           array('matches' => 'Both passwords should match'));
        if($this->form_validation->run() == FALSE)
        {
            return validation_errors();
        }   
    }
    /* This is to valdiate the singin form */
    function validate_signin()
    {
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email',
                                           array('required' => 'Email cannot be blank', 'valid_email' => 'Please enter a valid email'));
        $this->form_validation->set_rules('password1', 'password1', 'trim|required',
                                            array('required' => 'Password cannot be blank'));
        if($this->form_validation->run() == FALSE)
        {
            return validation_errors();
        }
    }
    /* Add users here */
    function add_user($post)
    {
        $query = 'INSERT INTO users (user_level_id, first_name, last_name, email, description, password, created_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?)';
        $values = array(2, $post['first_name'], $post['last_name'], $post['email'], '', md5($post['password1']), date('Y/m/d H:i:s'));
        return $this->db->query($query, $values);
    }
    /* this is executed when the first user registers */
    function make_admin($post)
    {
        $query = 'INSERT INTO users (user_level_id, first_name, last_name, email, description, password, created_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?)';
        $values = array(1, $post['first_name'], $post['last_name'], $post['email'], '', md5($post['password1']), date('Y/m/d H:i:s'));
        return $this->db->query($query, $values);
    }
    /* After registration, login the use and put its details on the session variable */
    function get_user_loggedin_details($post)
    {
        return $this->db->query('SELECT *, users.id AS user_id from users 
                                 INNER JOIN user_levels ON user_levels.id = users.user_level_id
                                 WHERE email = ? AND password = ?', array($this->security->xss_clean($post['email']), md5($this->security->xss_clean($post['password1']))))->row_array();
    }
    /* return a user with the user id of the selected value */
    function get_user_by_id($id)
    {
        $this->security->xss_clean($id);
        return $this->db->query('SELECT *, users.id AS user_id FROM users
                                 INNER JOIN user_levels ON user_levels.id = users.user_level_id
                                 WHERE users.id = ?', array($id))->row_array();
    }
    /* Get all users frpm users table */
    function get_all_users()
    {
        return $this->db->query('SELECT *, users.id AS user_id FROM users
                                 INNER JOIN user_levels ON user_levels.id = users.user_level_id')->result_array();
    }
    function get_user_levels()
    {
        return $this->db->query('SELECT * FROM user_levels')->result_array();
    }
    /* this is to validate the update user form for admin only */
    function validate_update_user()
    {
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email',
                                           array('required' => 'Email cannot be blank', 'valid_email' => 'Please enter a valid email'));
        $this->form_validation->set_rules('first_name', 'first_name', 'trim|required|alpha_numeric_spaces',
                                           array('required' => 'First Name cannot be blank', 'alpha_numeric_spaces' => 'First Name cannot contain any numbers'));
        $this->form_validation->set_rules('last_name', 'last_name', 'trim|required|alpha_numeric_spaces',
                                           array('required' => 'Last Name cannot be blank', 'alpha_numeric_spaces' => 'Last Name cannot contain any numbers'));
        if($this->form_validation->run() == FALSE)
        {
            return validation_errors();
        }
    }
    /* This is to u pdate the user after verificattion
        Note: the id is in the session[selected_user]*/
    function update_user()
    {
        date_default_timezone_set('ASIA/Manila');
        $date = date('Y/m/d H:i:s');
        $this->db->set('first_name', $this->input->post('first_name',TRUE));
        $this->db->set('last_name', $this->input->post('last_name',TRUE));
        $this->db->set('email', $this->input->post('email',TRUE));
        $this->db->set('user_level_id', $this->input->post('user_level',TRUE));
        $this->db->set('updated_at', $this->security->xss_clean($date));
        $this->db->where('id', $this->security->xss_clean($this->session->userdata('selected_user_to_view')));
        $this->db->update('users');
    }
    function verify_update_password()
    {
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        $this->form_validation->set_rules('password1', 'password1', 'trim|min_length[8]|required',
                                           array('required' => 'Password cannot be blank', 'min_length' => 'Password must be at least 8 characters long'));
        $this->form_validation->set_rules('password2', 'password2', 'trim|matches[password1]',
                                           array('matches' => 'Both passwords should match'));
        if($this->form_validation->run() == FALSE)
        {
            return validation_errors();
        }
    }
    function update_password($password)
    {      
        date_default_timezone_set('ASIA/Manila');
        $date = date('Y/m/d H:i:s');
        $this->db->set('password', md5($password));
        $this->db->where('id', $this->security->xss_clean($this->session->userdata('selected_user_to_view')));
        $this->db->update('users');
    }
    function delete_user($user_id)
    {
        $this->db->delete('users', array('id' => $this->security->xss_clean($user_id))); 
    }
    function verify_update_profile()
    {
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email',
                                           array('required' => 'Email cannot be blank', 'valid_email' => 'Please enter a valid email'));
        $this->form_validation->set_rules('first_name', 'first_name', 'trim|required|alpha_numeric_spaces',
                                           array('required' => 'First Name cannot be blank', 'alpha_numeric_spaces' => 'First Name cannot contain any numbers'));
        $this->form_validation->set_rules('last_name', 'last_name', 'trim|required|alpha_numeric_spaces',
                                           array('required' => 'Last Name cannot be blank', 'alpha_numeric_spaces' => 'Last Name cannot contain any numbers'));
        if($this->form_validation->run() == false)
        {
            return validation_errors();
        }
    }
    function update_profile()
    {
        date_default_timezone_set('ASIA/Manila');
        $date = date('Y/m/d H:i:s');
        $this->db->set('first_name', $this->input->post('first_name',TRUE));
        $this->db->set('last_name', $this->input->post('last_name',TRUE));
        $this->db->set('email', $this->input->post('email',TRUE));
        $this->db->set('updated_at', $this->security->xss_clean($date));
        $this->db->where('id', $this->security->xss_clean($this->session->userdata('selected_user_to_view')));
        $this->db->update('users');
    }
    function verify_description()
    {
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        $this->form_validation->set_rules('message', 'message', 'trim|required',
                                           array('required' => 'Description cannot be blank'));
        if($this->form_validation->run() == false)
        {
            return validation_errors();
        }
    }
    function update_description()
    {
        date_default_timezone_set('ASIA/Manila');
        $date = date('Y/m/d H:i:s');
        $this->db->set('description', $this->input->post('message',TRUE));
        $this->db->set('updated_at', $this->security->xss_clean($date));
        $this->db->where('id', $this->security->xss_clean($this->session->userdata('selected_user_to_view')));
        $this->db->update('users');
    }
}
?>