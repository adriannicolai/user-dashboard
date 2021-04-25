<?php
defined('BASEPATH') OR exit('no direct script access allowed!');

class message extends CI_Model
{
    function verify_message()
    {
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('message', 'message', 'trim|required',
                                           array('required' => 'Message cannot be blank'));
        if($this->form_validation->run() == FALSE)
        {
            return validation_errors();
        }   
    }
    /*the user_id field indicates who owns the message */
    function add_message($post)
    {
        date_default_timezone_set("ASIA/Manila");
        $date = date('Y/m/d H:i:s');
        $query = 'INSERT INTO messages (user_id, message, created_at) 
                                 VALUES (?, ?, ?)';
        $values =  array($post['message_sender_id'], $post['message'], $this->security->xss_clean($date));
        return $this->db->query($query, $values);
    }
    function get_all_messages()
    {
        return $this->db->query('SELECT *, TIMESTAMPDIFF(SECOND,messages.created_at, NOW()) AS date_difference, messages.id AS message_id FROM messages
                                 INNER JOIN users ON users.id = messages.user_id ORDER BY messages.id DESC')->result_array();
    }
    function get_comments()
    {
        return $this->db->query('SELECT *, concat(users.first_name," ",users.last_name) AS full_name, TIMESTAMPDIFF(SECOND,comments.created_at, NOW()) AS date_difference FROM thewallv2.comments LEFT JOIN users ON users.id= comments.user_id')->result_array();
    }
}
?>