
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Register_model');
        $this->load->library('session');

        $this->autologin();

    }
    

    public function autologin() {
        // Check if the remember token cookie exists
        $remember_token = $this->input->cookie('remember_me');
      //  echo 'rememebr token 20'.$remember_token;
    // Check if the remember token is valid
    if ($remember_token) {
        // Retrieve the user based on the remember token
        $user = $this->Register_model->get_user_by_remember_token($remember_token);
       
        if ($user) {
            // Login successful, store user data in session
            $this->session->set_userdata('user_id', $user->id);
         //   echo 'user line 139'.$user->id;
            $name = $user->name;
            $data = array(
                'name' => $name
            );
           echo 'ssssssss autologin 34'.$name;
            // Redirect the user to the main page
           $this->load->view('person_view',$data);
            return; // Exit the function


        }
    }
    
        
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
                
                //this for priniting the user session id by echoing we can use it directly in php controller.
                //echo "User ID in session: " . $this->session->userdata('user_id');

                $this->load->view('login_view',$data);
                
               
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
              //  echo 'line 76 '.$user->id;
                // Pass user's name and any other data you want to display to the view
                $name = $user->name;
                $data = array(
                    'name' => $name
                );
                
    
                $this->session->set_flashdata('success_message', 'Registration successful!');
                $this->load->view('person_view', $data);
    
                // Remember the user if the 'Remember Me' checkbox is checked
                if ($this->input->post('remember_me')) {
                   // echo 'rememebr line 87';
                    $this->remember();

                }
             
             
    
                // Redirect the user to the main page
               // $this->load->view('person_view');
            } else {
                // Login failed, show error message
                $data['error'] = 'Invalid username/email or password';
                $this->load->view('login_view', $data);
            }
        }
    }
    
    public function remember() {
        // Check if a remember token already exists for the user
        $user_id = $this->session->userdata('user_id');
        $existing_token = $this->Register_model->get_remember_token_by_user_id($user_id);
    
        //echo 'existing toke line 111'.$existing_token;
        if (!$existing_token) {
            // Generate a random remember token
          //  echo 'line 114'.$existing_token;
            $remember_token = $this->generate_random_token();
            
            // Store the remember token in the database for the user
            $this->Register_model->store_remember_token($user_id, $remember_token);
    
            // Set the remember token as a cookie
            $this->input->set_cookie('remember_me', $remember_token, time() + (86400 * 10)); // 30 days expiry
        }
    }
    



  






    public function logout() {
        // Destroy session, delete remember token from database and remove cookie
        $user_id = $this->session->userdata('user_id');
        $this->Register_model->delete_remember_token($user_id);
        $this->session->sess_destroy();
      //  delete_cookie('remember_me');
        redirect('Auth/login');
    }







    public function generate_random_token($length = 32) {
        // Define characters that can be used in the token
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        
        // Initialize an empty token string
        $token = '';
        
        // Generate random characters to form the token
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, $characters_length - 1)];
        }
        
        // Return the generated token
        return $token;
    }










}




?>