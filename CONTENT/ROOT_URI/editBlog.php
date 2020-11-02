<script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
</script>
<?php 

if (isset($_GET['blogId'])) {
	$blogId = $_GET['blogId'];
	// echo $blogId;
     $sql = "SELECT * FROM BLOGS WHERE BLOG_ID = '$blogId'";
     $result = mysqli_query($link,$sql);
     $tempArray = [];
     if ($result) {
        if(mysqli_num_rows($result)>0){
          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          $slug = $row['SLUG'];
          $meta = $row['META'];
          $title = $row['TITLE'];
          $imageLink = $row['IMAGE'];
          $altTag = $row['ALT_TAG'];
          $content = $row['CONTENT'];
          $author = $row['AUTHOR'];
        }
      }else{
        $errorm = mysqli_error($link);
      }
}

 ?>
 <?php if($_SESSION['LoggedIn']){ ?>

<div class="container card shadow">
	<h1 class="text-center" style="">Edit Blog Post</h1>
	<div class="alert alert-danger" style="display: none;" id="alertMsg"></div>
	<hr>
	<div class="card-body">
		<form class="form" method="POST">
      <input type="hidden" name="" id="blogId" value="<?php echo $blogId; ?>">
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label>Page Title<span style="color: red;">*</span></label>
						<input type="text" class="form-control" placeholder="Page Title" name="title" id="title" value="<?php echo $title; ?>">
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label>URL(Slug)<span style="color: red;">*</span></label>
						<input type="text" class="form-control" onfocusout="checkSlug()" placeholder="Unique Slug" name="title" id="slug" value="<?php echo $slug; ?>">
            <p style="color: red; display:none;" id="slugMsg"></p>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>Meta Description<span style="color: red;">*</span></label>
						<textarea cols="3" class="form-control" placeholder="Meta tag description" name="meta" id="meta"><?php echo $meta; ?></textarea>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label>Blog Image<span style="color: red;">*</span></label>
						<input type="file" id="image" class="form-control">
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label>Image alt<span style="color: red;">*</span></label>
						<input type="text" id="alt" name="alt" placeholder="Image alt tag" class="form-control" value="<?php echo $altTag; ?>">
					</div>
				</div>
			</div>
			<textarea name="editor1" id="editor1" cols="3" rows="10"><?php echo $content; ?></textarea><br>
      <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Author Name<span style="color: red;">*</span></label>
					<input type="text" id="author" name="author" value="<?php echo $author; ?>" placeholder="Author Name" class="form-control">
				</div>
			</div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Updated date<span style="color: red;">*</span></label>
            <input type="date" id="updatedDate" name="updatedDate" value="<?php echo date("Y-m-d"); ?>" placeholder="Date of Updation" class="form-control">
          </div>
        </div>
      </div>
      <div class="col-md-12 mr-auto">
  			<div class="form-group text-right">
  				<span id="saveMsg" style="display: none; color: red;"></span>
  		    	<input type="button" name="submit" id="saveBtn" value="Edit Blog" onclick="editBlog()" class="btn btn-success">
  			</div>
      </div>
		</form>
	</div>
</div>
<script>
CKEDITOR.replace( 'editor1' );
var slugMsg = document.getElementById('slugMsg');
var slug = null; 
var title = null; 
var metaTags = null; 
var editorData = null; 
var author = null; 
var alt = null; 
var file = null; 
var slugError = false;
var alertMsg = document.getElementById('alertMsg');
var saveMsg = document.getElementById('saveMsg');
var blogId = document.getElementById('blogId').value;


function makeSlug() {
	var str = document.getElementById('title').value;
    str = str.replace(/[^a-zA-Z0-9]/g, '-').toLowerCase();
    document.getElementById('slug').value = str;
}
function checkSlug() {
  slug = document.getElementById('slug').value;
	fetch('/API/V1/?checkSlugEdit&slug='+slug)
        .then(
          function(response) {
            if (response.status !== 200) {
              console.log('Looks like there was a problem. Status Code: ' +
                response.status);
              return;
            }
            // Examine the text in the response
            response.json().then(function(data) {
              // console.log(data);
              if(data){
              	slugMsg.style.display = "block";
                slugMsg.innerHTML = "Already present!";
                slugError = true;
              }
              else{
                slugMsg.style.display = "block";
                slugMsg.innerHTML = "Looks Good!";
              }
              
            });
          }
        )
        .catch(function(err) {
          console.log('Fetch Error :-S', err);
        });
}
function editBlog() {
 saveMsg.style.display = "inline-block";
 saveMsg.innerHTML = 'Saving Data...';
 document.getElementById('saveBtn').disabled = true;
 slug = document.getElementById('slug').value; 
 title = document.getElementById('title').value; 
 metaTags = document.getElementById('meta').value; 
 editorData = CKEDITOR.instances['editor1'].getData();; 
 author = document.getElementById('author').value; 
 alt = document.getElementById('alt').value; 
 updatedDate = document.getElementById('updatedDate').value; 
 file = document.getElementById('image').files[0]; 
 console.log(alt);
  let formData = new FormData();
  formData.append('blogId', blogId);
  formData.append('slug', slug);
  formData.append('title', title);
  formData.append('meta', metaTags);
  formData.append('content', editorData);
  formData.append('author', author);
  formData.append('alt', alt);
  formData.append('file', file);
  formData.append('updateBlog', 'submit');
  if (slugError) {
  	document.getElementById('alertMsg').style.display = 'block';
  	document.getElementById('alertMsg').innerHTML = 'SLUG is not unique';
  	saveMsg.innerHTML = 'SLUG is not unique...';
  	document.getElementById('saveBtn').disabled = false;
  }else if (!slug || !title || !metaTags) {
  	// console.log(selectedDomain+ selectedUri+slug+title+metaTags);
  	document.getElementById('alertMsg').style.display = 'block';
  	document.getElementById('alertMsg').innerHTML = 'Fill up all the fields...';
  	saveMsg.innerHTML = 'Fill up all the fields...';
  	document.getElementById('saveBtn').disabled = false;
  }else{
  	document.getElementById('alertMsg').style.display = 'none';
  	fetch("/API/V1/", {
        method: "POST",
        body:formData,
    }).then(
        function(response) {
        response.json().then(function(data) {
          // console.log(data);
          alert(data);
          location.reload();
        });
      }
    )
    .catch(function(err) {
      console.log('Fetch Error :-S', err);
      saveMsg.innerHTML = 'Some error! Try Again!';
  	  document.getElementById('saveBtn').disabled = false;
    });
  }
}
</script>
<?php 
}else{
  include 'signIn.php';
}