<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

class comment extends CI_Model
{
    function verify_comment()
    {
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $this->form_validation->set_rules('comment', 'comment', 'trim|required',
                                           array('required' => 'Comment cannot be blank'));
        if($this->form_validation->run() == FALSE)
        {
            return validation_errors();
        }
    } 
    function add_comment($post)
    {
        date_default_timezone_set("ASIA/Manila");
        $date = date('Y/m/d H:i:s');
         return $this->db->query('INSERT INTO comments (user_id, message_id, comment, created_at) VALUES (?, ?, ?, ?)', array($this->security->xss_clean($post['user_id']), $this->security->xss_clean($post['message_id']), $this->security->xss_clean($post['comment']), $this->security->xss_clean($date)));
    }    
}

?>