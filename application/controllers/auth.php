<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Auth extends CI_Controller {  

	function __construct(){
		parent::__construct();
		$this->load->model('m_auth');  
		$this->load->library('session');
          $this->load->model('m_invoice');
	}
      //functions  
      function login()  
      {  
	
           $data['title'] = 'CodeIgniter Simple Login Form With Sessions';  
           $this->load->view("v_login", $data);  
      }  
     public function login_validation()  
      {  
		  
           $this->load->library('form_validation');  
           $this->form_validation->set_rules('username', 'Username', 'required');  
           $this->form_validation->set_rules('password', 'Password', 'required');  
           if($this->form_validation->run())  
           {  
                //true  
                $username = $this->input->post('username');  
                $password = $this->input->post('password');  
                //model function  
        
                if($this->m_auth->can_login($username, $password))  
                {  

					$temp = $this->db->query("SELECT `type` FROM users WHERE username = '".$username."'")->row();	
                     $session_data = array(  
                          'username'  => $username ,
						   'type' =>   $temp->type
                     );  
                     $this->session->set_userdata($session_data);  
                     redirect(base_url() . 'index.php/auth/enter');  
                }  
                else  
                {  
                     $this->session->set_flashdata('error', 'Invalid Username and Password');  
                     redirect(base_url() . 'index.php/auth/login');  
                }  
           }  
           else  
           {  
                //false  
                $this->login();  
           }  
      }  
      function enter(){  
           if($this->session->userdata('username') != '')  
           {  

			redirect(base_url() . 'index.php/invoice');  
               // echo '<h2>Welcome - '.$this->session->userdata('username').'</h2>';  
               // echo '<label><a href="'.base_url().'main/logout">Logout</a></label>';  
           }  
           else  
           {  
                redirect(base_url() . 'auth/login');  
           }  
      }  
      function logout()  
      {  
           $this->session->unset_userdata('username');  
           redirect(base_url() . 'index.php/auth/login');  
      }  

      public function loginApi()
      {
          $username = $this->input->post('username');
          $password = $this->input->post('password');
          $result = $this->m_auth->can_login($username, $password);
          echo json_encode($result);
      }

      function getapi(){
		$data=$this->m_invoice->getallapi();
		echo json_encode($data);

	}


 } 