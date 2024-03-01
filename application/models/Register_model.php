<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register_model extends CI_Model {
public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_user($data) {
        $this->db->insert('register_user', $data);
        return $this->db->insert_id();
    }

    public function get_user($username_email) {
        $this->db->where('name', $username_email);
        $this->db->or_where('email', $username_email);
        return $this->db->get('register_user')->row();
    }

}

    ?>