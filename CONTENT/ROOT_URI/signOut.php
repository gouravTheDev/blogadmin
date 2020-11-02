<?php 
 if(isset($_SESSION['LoggedIn'])){
 	// $_SESSION['logout'];
    session_destroy();
    echo "<script>
		 	window.location.href='/';
		 </script>";
    
}


 ?>