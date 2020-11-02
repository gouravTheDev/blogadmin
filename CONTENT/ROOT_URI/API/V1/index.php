<?php
$link = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
$link->set_charset("utf8");
if(mysqli_connect_error()){
    die("ERROR: UNABLE TO CONNECT: ".mysqli_connect_error());
}

if(isset($_SESSION['LoggedIn']) && !empty($_SESSION['LoggedIn'])){
	$data = null;
	$errorm = null;
	if (isset($_GET['allblogs'])) {

     $sql = "SELECT * FROM BLOGS ORDER BY ID DESC";
     $result = mysqli_query($link,$sql);
     $tempArray = [];
     if ($result) {
        if(mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            array_push($tempArray, $row);
          }
          $data = json_encode($tempArray);
        }else{
          $data = null;
          $data = json_encode($data);
        }
      }else{
        $errorm = mysqli_error($link);
      }

    }

    if (isset($_GET['singleBlog'])) {
     $blogId = $_GET['blogId'];
     $sql = "SELECT * FROM BLOGS WHERE BLOG_ID = '$blogId'";
     $result = mysqli_query($link,$sql);
     $tempArray = [];
     if ($result) {
        if(mysqli_num_rows($result)>0){
          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          $data = json_encode($row);
        }
      }else{
        $errorm = mysqli_error($link);
      }

    }

    if (isset($_GET['checkSlug'])) {
     $slug = $_GET['slug'];
     $sql = "SELECT * FROM BLOGS WHERE SLUG='$slug'";
     $result = mysqli_query($link,$sql);
     if ($result) {
        if(mysqli_num_rows($result)>0){
          $data = 'This already exists';
        }else{
          $data = null;
        }
        $data = json_encode($data);
      }

    }

    if (isset($_GET['checkSlugEdit'])) {
      // Data Sanitazitation and details in json
     
     $slug = $_GET['slug'];
     $sql = "SELECT * FROM BLOGS WHERE SLUG='$slug'";
     $result = mysqli_query($link,$sql);
     if ($result) {
        if(mysqli_num_rows($result)>0){
          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          if ($slug == $row['SLUG']) {
            $data = null;
          }else{
            $data = 'This already exists';
          }
        }else{
          $data = null;
        }
        $data = json_encode($data);
      }

    }

    if (isset($_POST['createBlog'])) {
    	// Same as error_reporting(E_ALL);


      $title =  $_POST['title'];
      $slug = $_POST['slug'];
      $metaTag =  $_POST['meta'];
      $content = $_POST['content'];
      $author = $_POST['author'];
      $alt = $_POST['alt'];
      $dateCreated = $_POST['createDate'];
      $image = $_FILES['file']['name'];

      $blogId = "BL-".$slug;
      // $imgName = $blogId.".webp";
      if ($image) {
      	//-----------UPLOAD TO SERVER-------------

	      mkdir("CDN/BLOGS/".$blogId."/",  0755, true);
	      $target = "CDN/BLOGS/".$blogId."/".$image;
	      if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
	          $msg = "Image uploaded successfully";
	          // echo $msg;
	      }else{
	        $msg = "Failed to upload image";
	        // echo "not uploaded";
	      }   
      }

     

      $link->set_charset("utf8");
      $stmt = $link->prepare("INSERT INTO `BLOGS` (`BLOG_ID`, `SLUG`, `META`, `TITLE`, `CONTENT`, `IMAGE`, `ALT_TAG`, `AUTHOR`, `DATE_CREATED`, `DATE_UPDATED`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssssssss", $blogId, $slug, $metaTag, $title, $content, $image, $alt, $author, $dateCreated, $dateCreated);

      if ($stmt->execute()) {
        
        $data = "Successfully created a new blog";
        // echo $data;
        $data = json_encode($data);
      }else{
        // $errorm = "COULD NOT CREATE THE PAGE.. TRY AGAIN!";
        $errorm = mysqli_error($link);
        // echo $errorm;
        $errorm = json_encode($errorm);
      }
    }

    if (isset($_POST['updateBlog'])) {
      // Data Sanitazitation and details in json
      $blogId =  $_POST['blogId'];
      $slug = $_POST['slug'];
      $metaTag =  $_POST['meta'];
      $title =  $_POST['title'];
      $content = $_POST['content'];
      $author = $_POST['author'];
      $alt = $_POST['alt'];
      $updatedDate = date("Y-m-d");
      $image = $_FILES['file']['name'];

      $sqlF = "SELECT * FROM BLOGS WHERE BLOG_ID = '$blogId'";
      $resultF = mysqli_query($link,$sqlF);
      if ($resultF) {
        if(mysqli_num_rows($resultF)>0){
        	$row = mysqli_fetch_array($resultF,MYSQLI_ASSOC);
        	$preImageName = $row['IMAGE'];
        }
      }
      if ($image) {
        unlink("CDN/BLOGS/".$blogId."/".$preImageName);
        mkdir("CDN/BLOGS/".$blogId."/",  0755, true);
	      $target = "CDN/BLOGS/".$blogId."/".$image;
	      if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
	          $msg = "Image uploaded successfully";
	          // echo $msg;
	      }else{
	        $msg = "Failed to upload image";
	        // echo "not uploaded";
	      }  
      }else{
      	$image = $preImageName;
      }


      $link->set_charset("utf8");

      $stmt = $link->prepare("UPDATE `BLOGS` SET `TITLE` = ?, `SLUG` = ?, `META` = ?, `CONTENT` = ?, `DATE_UPDATED` = ?, `AUTHOR` = ?, `IMAGE` = ?, `ALT_TAG` = ? WHERE `BLOG_ID` = ? ");

      $stmt->bind_param("sssssssss", $title, $slug, $metaTag, $content, $updatedDate, $author, $image, $alt, $blogId);

      if ($stmt->execute()) {
        // $data = "Successfully updated the page";
        $data .= "Successfully Updated Blog";
        $data = json_encode($data);
      }else{
        $errorm = "The blog could not be updated!";
        $errorm = mysqli_error($link);
        $errorm = json_encode($errorm);
      }

    }

    if (isset($_POST['deleteBlog'])) {
      // Data Sanitazitation and details in json
      $blogId = $_POST['blogId'];

      $sql="DELETE FROM `BLOGS` WHERE `BLOG_ID`='$blogId' ";
      $result = mysqli_query($link,$sql);
      if ($result) {
        $data = "Successfully deleted the blog";
        $data = json_encode($data);
      }else{
        $errorm = mysqli_error($link);
        $errorm = json_encode($errorm);
      }

    }

}
if ($data) {
  echo $data;
}
else if($errorm){
  echo $errorm;
}




?>