<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Register_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_user($data)
    {
        $this->db->insert('register_user', $data);
        return $this->db->insert_id();
    }

    public function get_user($username_email)
    {
        $this->db->where('name', $username_email);
        $this->db->or_where('email', $username_email);
        return $this->db->get('register_user')->row();
    }

    public function get_user_role($username_email)
    {
        $this->db->where('name', $username_email);
        $this->db->or_where('email', $username_email);
        return $this->db->get('register_user')->row()->role_id;
    }

    public function store_remember_token($user_id, $remember_token)
    {
        // Store the remember token in the database for the user
        $this->db->where('id', $user_id);
        $this->db->update('register_user', array('remember_token' => $remember_token));
    }

    public function get_user_by_id($user_id) {
        // Retrieve the user based on the user ID
        $query = $this->db->get_where('register_user', array('id' => $user_id));
      
        // Check if the query returned any rows
        if ($query->num_rows() == 1) {
            // Return the user object
            return $query->row();
        } else {
            // User not found
            return false;
        }
    }
    public function get_user_by_remember_token($remember_token)
    {
      
      
        $query = $this->db->get_where('register_user', array('remember_token' => $remember_token));
    
        $user = $query->row();

        if ($user) {
            // If user found, return the user object
            return $this->get_user_by_id($user->id);
        } else {
            // If no user found, return false
            return false;
        }
    }

    public function delete_remember_token($user_id)
    {
        // Delete the remember token from the database for the user
        $this->db->where('id', $user_id);
        $this->db->update('register_user', array('remember_token' => NULL));
    }
}
