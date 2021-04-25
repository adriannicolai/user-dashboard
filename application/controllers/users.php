<?php
defined('BASEPATH') OR exit('ni direct script access allowed');

class users extends CI_Controller
{
    public function index()
    {
        if($this->session->userdata('user_level') == 'Normal')
        {
            redirect('/users/show_homepage');
        }
        else if($this->session->userdata('user_level') == 'Admin')
        {
            redirect('/users/show_homepage');
        }
        else
        {
            $this->load->view('/signin/index');
        }
    }
    /* This code hales the signin for all of the user levels */
    public function signin()
    {
        if($this->session->userdata('user_level') == 'Normal')
        {
            redirect('/users/index');
        }
        else if($this->session->userdata('user_level') == 'Admin')
        {
            // $this->load->view('/admin/index');
        }
        else
        {
            $this->load->view('/signin/signin');
        }
    }
    /* The code here is to validate the signin form */
    public function validate_signin()
    {
        $result = $this->user->validate_signin();
        if($result != NULL)
        {
            $this->session->set_flashdata('errors', $result);
            redirect('/signin');
        }
        else
        {
            $user_details['details'] = $this->user->get_user_loggedin_details($this->input->post(NULL, TRUE));
            if($user_details['details'] == NULL)
            {
                $this->session->set_flashdata('errors', '<p class="error">Invalid username and/or password</p>');
                redirect('/signin');
            }
            else
            {
                foreach ($user_details as $index)
                {
                    $this->session->set_userdata('id', $index['user_id']);
                    $this->session->set_userdata('user_level', $index['name']);
                    $this->session->set_userdata('email', $index['email']);
                    $this->session->set_userdata('first_name', $index['first_name']);
                    $this->session->set_userdata('last_name', $index['last_name']);
                }
                redirect('/users/show_homepage');
            }
        }
    }
    public function logoff()
    {
        /* Destroys the session and then redirects it back to the gome page */
        $this->session->sess_destroy();
        redirect('/users/index');
    }
    public function register()
    {
        $this->load->view('/signin/register');
    }
    public function show_homepage()
    {
        if($this->session->userdata('user_level') == 'Normal')
        {
            $all_users['all_users'] = $this->user->get_all_users();
            $this->load->view('/users/index', $all_users);
        }
        else if($this->session->userdata('user_level') == 'Admin')
        {
            $all_users['all_users'] = $this->user->get_all_users();
            $this->load->view('/admin/index', $all_users);
        }
        else
        {
            redirect('/users/index');
        }

    }
    public function add_user_admin()
    {
        $this->load->view('/admin/add_user');
    }
    public function add_user()
    {
        /* Get the number of users in the database to determine if this is the first user to register */
        $number_of_users = $this->user->get_number_of_registered_users();

        /* This code gets all the information in the form register/add_user only if input post is set and runs them is xss filter before inserting them in the database*/        
        $result = $this->user->validate_registration();

        if($result != NULL)
        {
            $this->session->set_flashdata('errors', $result);
            if($this->session->userdata('user_level') == 'Admin')
            {
                redirect('/users/add_user_admin');
            }
            else
            {
                redirect('/users/register');
            }
        }
        else
        {
            if($number_of_users > 0)
            {
                $this->user->add_user($this->input->post(NULL, TRUE));
                $user_details['details'] = $this->user->get_user_loggedin_details($this->input->post(NULL, TRUE));
                if($this->session->userdata('user_level') == 'Admin')
                {
                    redirect('/users/show_homepage');
                }
                else
                {
                    foreach ($user_details as $index)
                    {
                        $this->session->set_userdata('id', $index['user_id']);
                        $this->session->set_userdata('user_level', $index['name']);
                        $this->session->set_userdata('email', $index['email']);
                        $this->session->set_userdata('first_name', $index['first_name']);
                        $this->session->set_userdata('last_name', $index['last_name']);
                    }
                    redirect('/users/index');
                }
            }
            else
            {
                $this->user->make_admin($this->input->post(NULL, TRUE));
                $user_details['details'] = $this->user->get_user_loggedin_details($this->input->post(NULL, TRUE));
                foreach ($user_details as $index)
                {
                    $this->session->set_userdata('id', $index['user_id']);
                    $this->session->set_userdata('user_level', $index['name']);
                    $this->session->set_userdata('email', $index['email']);
                    $this->session->set_userdata('first_name', $index['first_name']);
                    $this->session->set_userdata('last_name', $index['last_name']);
                }
                redirect('/users/show_homepage');
            }
        }
    }
    /* This displays the edit for and gets the selected user */
    public function edit($id)
    {
        $this->session->set_userdata('selected_user_to_view', $id);
        $selected_user['selected_user'] = $this->user->get_user_by_id($id);
        $selected_user['user_level'] = $this->user->get_user_levels();
        $this->load->view('/admin/edit_user', $selected_user);
    }
    /* validates and then updates user if it passes the validation script */
    public function update_user()
    {
        $result = $this->user->validate_update_user();
        if($result != NULL)
        {
            $this->session->set_flashdata('errors', $result);
            redirect('/users/edit/'.$this->session->userdata('selected_user_to_view').'');
        }
        else
        {
            $this->user->update_user();
            redirect('/users/show_homepage');
        }
    }
    /*Verifies the update password form and then updates password */
    public function update_user_password()
    {
        $result = $this->user->verify_update_password();
        if($result != NULL)
        {
            $this->session->set_userdata('errors', $result);
            redirect('/users/edit/'.$this->session->userdata('selected_user_to_view').'');
        }
        else
        {
            $this->user->update_password($this->input->post('password1', TRUE));
            redirect('/users/show_homepage');
        }
        
    }
    public function delete($to_delete)
    {
        $this->user->delete_user($this->security->xss_clean($to_delete));
        redirect('/users/show_homepage');
    }
    public function edit_my_profile($id)
    {
        $this->session->set_userdata('selected_user_to_view', $id);
        $selected_user['selected_user'] = $this->user->get_user_by_id($id);
        $this->load->view('/profile/edit_profile', $selected_user);
    }
    public function update_my_profile()
    {
        $result = $this->user->verify_update_profile();
        if($result != NULL)
        {
            $this->session->set_userdata('errors', $result);
            redirect('/users/edit_my_profile/'.$this->session->userdata('selected_user_to_view').'');
        }
        else
        {
            $this->user->update_profile();
            redirect('/users/show_homepage');
        }
    }
    public function update_description()
    {
        $result = $this->user->verify_description();
        if($result != NULL)
        {
            $this->session->set_userdata('errors', $result);
            redirect('/users/edit_my_profile/'.$this->session->userdata('selected_user_to_view').'');
        }
        else
        {
            $this->user->update_description();
            redirect('/users/show_homepage');
        }
    }
}
?>