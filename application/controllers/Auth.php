
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Register_model');
        $this->load->library('session');
    }
    
    public function register_validation(){
   
        $this->form_validation->set_rules('name', 'Username', 'required|is_unique[register_user.name]', array(
            'is_unique' => 'The %s is already taken.'
        ));
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[register_user.email]', array(
            'is_unique' => 'The %s is already taken.'
        ));
         $this->form_validation->set_rules('password', 'Password', 'required');
       
         if ($this->form_validation->run() == FALSE) {
             $this->load->view('register_view');
        } else {
             $data = array(
                 'name' => $this->input->post('name'),
                 'email' => $this->input->post('email'),
                 'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
             );

            $user_id = $this->Register_model->insert_user($data);

             if ($user_id) {
                 // Registration successful, log the user in
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_flashdata('success_message', 'Registration successful!');
                 redirect('Person/index'); // Redirect to dashboard or any other page
             } else {
                 // Registration failed, show error message
                 $data['error'] = 'Failed to register user';
                $this->load->view('login_view', $data);
             }
         }

    }


    public function login() {
        $this->form_validation->set_rules('email', 'Username or Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login_view');
        } else {
           
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Register_model->get_user($email);
                 
            if ($user && password_verify($password, $user->password)) {
                // Login successful, store user data in session
                $this->session->set_userdata('user_id', $user->id);
                // $name = $user->name;

                // // Pass user's name and any other data you want to display to the view
                // $data['name'] = $name;
                $email = $user->email;
                $data['email'] = $email;

                $this->load->view('person_view',$data);
                //$this->load->view('person_view');
               // var_dump($data);
            // redirect('person_view'); // Redirect to dashboard or any other page
            } else {
                // Login failed, show error message
                $data['error'] = 'Invalid username/email or password';
                $this->load->view('login_view', $data);
            }
        }
    }

    public function logout() {
        // Destroy session and redirect to login page
        $this->session->sess_destroy();
        redirect('Auth/login');
    }
}




?>