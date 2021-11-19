<?php  
 class M_auth extends CI_Model  
 {  
      function can_login($username, $password)  
      {  
           $this->db->where('username', $username);  
           $this->db->where('password', md5($password));  
           $query = $this->db->get('users');  
           //SELECT * FROM users WHERE username = '$username' AND password = '$password'  
           if($query->num_rows() > 0)  
           {  
                return true;  
           }  
           else  
           {  
                return false;       
           }  
      }  


      function LoginApi($username, $password)
      {
          $result = $this->db->query("SELECT
                                          *
                                      FROM
                                          users
                                      WHERE
                                          username = '".$username."'
                                      AND PASSWORD = '".md5($password)."'");
                                      
          return $result->result();
      }
 }  