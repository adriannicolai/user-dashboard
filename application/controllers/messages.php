<?php
defined('BASEPATH') OR exit('no direct script access allowed!');

class messages extends CI_Controller
{
    public function index($id)
    {
        $cleaned_id = $this->security->xss_clean($id);
        $this->session->set_userdata('selected_user_to_view', $cleaned_id);

        /* Get all messages in the database */

        $data_to_pass['all_messages'] = $this->message->get_all_messages($cleaned_id);
        $data_to_pass['selected_user'] = $this->user->get_user_by_id($cleaned_id);
        $data_to_pass['comments'] = $this->message->get_comments();

        $this->load->view('/messages/index', $data_to_pass);
    }
    /* This will add new messages in the database
       the user_id in the post is the owner of the message */
    public function add_message()
    {
        $result = $this->message->verify_message();
        if($result != NULL)
        {
            $this->session->set_flashdata('errors', $result);
            redirect('/messages/'.$this->session->userdata("selected_user_to_view").'');
        }
        else
        {
            $this->message->add_message($this->input->post(NULL, TRUE));
            redirect('/messages/'.$this->session->userdata("selected_user_to_view").'');
        }
    }
    /* this code is to verify the add comment form and add comments to the database */
    function add_comments()
    {
        $result = $this->comment->verify_comment();
        if($result != NULL)
        {
            $this->session->set_flashdata('errors', $result);
            redirect('/messages/'.$this->session->userdata("selected_user_to_view").'');
        }
        else
        {
            $this->comment->add_comment($this->input->post(NULL, TRUE));
            redirect('/messages/'.$this->session->userdata("selected_user_to_view").'');
        }

    }
}
?>