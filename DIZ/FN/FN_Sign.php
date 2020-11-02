<?php
 if(isset($_SESSION['LoggedIn'])){
 }
 else $_SESSION['LoggedIn']=false;
if(isset($_POST["s_Hash"]) && $_POST["s_Hash"]== $_SESSION['s_Hash']){

  // echo $GLOBALS['alert_info']; $_SESSION['redirectOnNextLoad'] ="hh"; echo $_SESSION['redirectOnNextLoad'];
  $link = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
  $link->set_charset("utf8");

  // SIGN IN PHP CODE

  if (isset($_POST['formName']) && $_POST['formName']=="adminSignIn"){

          $email = $_POST['email'];

          $password = $_POST['password'];

          $password = md5($password);
          // echo $password;
          $sql = "SELECT * FROM BLOG_ADMIN WHERE `EMAIL` = '$email'";
          $result = mysqli_query($link, $sql);

          $results = mysqli_num_rows($result);
          if(!$results){
              // echo '<div class="alert alert-danger">No Such User</div>';
              $GLOBALS['alert_info'] .= DaddToBsAlert("No Such User!");
          }else{
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $passwordDB = $row['PASSWORD'];
            if($password == $passwordDB){
                // echo '<div class="alert alert-success"> Welcome to Beanstalk Franchise Portal </div>';
                $_SESSION["LoggedIn"]=true;
                $_SESSION["user"] = $email;
                $_SESSION["userId"] = $row['USER_ID'];
                $_SESSION["userName"] = $row['NAME'];
                echo "<script>
                    window.location.href='/';
                  </script>";
            }else{
                // echo '<div class="alert alert-danger"> Credential did not match! </div>';
                $GLOBALS['alert_info'] .= DaddToBsAlert("Credential did not match!");
            }
          }

  }
}


?>
