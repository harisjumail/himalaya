<!DOCTYPE html>  
 <html>  
 <head>  
      <title>Webslesson | <?php echo $title; ?></title>  
      <link rel="stylesheet" 

href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />  
 </head>  
 <body>  
      <div class="container">  
           <br /><br /><br />  
           <form method="post" action="<?php echo base_url(); ?>index.php/auth/login_validation">  
                <div class="form-group">  
                     <label>Enter Username</label>  
                     <input type="text" name="username" class="form-control" />  
                                   
                </div>  
                <div class="form-group">  
                     <label>Enter Password</label>  
                     <input type="password" name="password" class="form-control" />  
                     
                </div>  
                <div class="form-group">  
                     <input type="submit" name="insert" value="Login" class="btn btn-info" />  
                     <?php  
                       echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  
                     ?>  
                </div>  
           </form>  
                 
               login : 
               <p>
               username : kasir1 <br>
               passwod : admin
               <p>  
               username : pelayan1 <br>
               passwod : admin
               <p> 
               <p>  
               username : pelayan2<br>
               passwod : admin
               <p> 

               API login 
               http://localhost/himalaya/index.php/auth/loginApi <br>
               API akses menu makanan
               http://localhost/himalaya/index.php/auth/getapi

      </div>  


 </body>  



 </html>  