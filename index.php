<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
    	<div class="card">
    		<div class="card-header">
    			<h2 class="text-center font-italic">Image Crop And Resize with PHP</h2>
    		</div>
    		<div class="card-body">
    			<div class="form w-75 m-auto">
    				<form action="" method="post" enctype="multipart/form-data">
    					<div class="form-group">
    						<label for="image">Image</label>
    						<input type="file" id="image" name="image" class="form-control">
    					</div>
    					<div class="form-group">
    						<label for="height">Height</label>
    						<input type="number" class="form-control" id="height" name="height" placeholder="Enter Picture Height" area-describedby="heightHelp">
    						<small id="heightHelp" class="form-text text-muted">Enter Image Height By Pixel</small>
    					</div>
    					<div class="form-group">
    						<label for="width">Width</label>
    						<input type="number" class="form-control" id="width" name="width" placeholder="Enter Picture Width" area-describedby="widthHelp">
    						<small id="widthHelp" class="from-text text-muted">Enter Image Width By Pixel</small>
    					</div>
    					<input type="submit" class="btn btn-info" value="Upload">
    				</form>
    			</div>
    			<div class="image-script w-75 m-auto ">
    				
	    			<!-----------------------------------------------------
	    			    		Image Upload Script
	    			--------------------------------------------------- -->
    				<?php
 						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	     					$fileName = $_FILES['image']['name'];
	    					$filetempLoc = $_FILES['image']['tmp_name'];
	    					$fileType = $_FILES['image']['type'];
	    					$fileSize = $_FILES['image']['size'];
	    					$ext = explode('.', $fileName);
	    					$ext = end($ext);
	    					$height = $_POST['height'];
	    					$width = $_POST['width'];

	    					
	    			//---------------------------------------------------
	    			//    		Empty Check
	    			//---------------------------------------------------
	    					if (empty($fileName) or empty($height) or empty($width)) {
	    						echo '<div class="alert alert-danger mt-2"><strong>Error!! </strong>Field Must Not Be Empty</div>';
	    					}

	    			//---------------------------------------------------
	    			//    		Image Ration
	    			//---------------------------------------------------
	    					list($original_width, $original_height) = getimagesize($filetempLoc);
	    					$scale_ratio = $original_width/$original_height;
	    					if (($width/$height) > $scale_ratio) {
	    						$width = $height*$scale_ratio;
	    					}else{
	    						$height = $width/$scale_ratio;
	    					}

	    		// ----------------------------------------------------------
	    		// 	Image Extension check
	    		// ----------------------------------------------------------
	    					$img = "";
	    					if ($ext == 'gif' or $ext == 'GIF') {
	    						$img = imagecreatefromgif($filetempLoc);
	    					}else if($ext == 'png' or $ext == 'PNG') {
	    						$img = imagecreatefrompng($filetempLoc);
	    					}else if($ext == 'jpg' or $ext == 'JPG' or $ext == 'jpeg' or $ext == 'JPEG'){
	    						$img = imagecreatefromjpeg($filetempLoc);
	    					}else{
	    						echo '<div class="alert alert-danger mt-2"><strong>Error!! </strong>Image Should BE .jpg, .png, .gif</div>';
	    						exit();
	    					}

	    			//---------------------------------------------------
	    			//    		Image Resize
	    			//---------------------------------------------------
	    					$ictc = imagecreatetruecolor($width, $height);
	    					imagecopyresampled($ictc, $img, 0, 0, 0, 0, $width, $height, $original_width, $original_height);
	    					imagejpeg($ictc, 'uploads/'.$fileName, 80);

	    			//---------------------------------------------------
	    			//    		Download Image Button
	    			//---------------------------------------------------
	    					echo '<a href="uploads/'.$fileName.'" class="btn btn-primary mt-1" id="download"  download>Download</a>';

	    			//---------------------------------------------------
	    			//    		Image Unlink ajax input
	    			//---------------------------------------------------
	    					echo '<input type="hidden" id="unlink" value="'.$fileName.'" name="unlink"';
	    					echo '<input type="hidden" id="tmpUnlink" value="'.$filetempLoc.'" name="tmpUnlink"';
	    					
	    				}
					?>
    			</div> <!-- image script end -->
    		</div> <!-- Card Body End -->
    		<div class="card-footer">
    			<h4 class="text-center font-italic">Made By <a href="http://developeralam.github.io" target="_blank">Md alam</a></h4>
    		</div> <!-- Card Footer End -->
    	</div> <!-- Card End -->
    </div> <!-- Container End -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-------------------------------------------------------------
    						Unlink ajax Script
    ----------------------------------------------------------- -->
		<script>
			$("#download").click(function(){
				setTimeout(function(){

    				var unlink = $("#unlink").val();
    				var tmpUnlink = $("#unlink").val();
    				var dataString = 'unlink='+unlink+'&tempUnlink='+tmpUnlink;
    				$.ajax({
    					type:"POST",
    					url:"unlink.php",
    					data:dataString,
    					success:function(data){
    					}
    				});
				}, 4000);
			})
		</script>
  </body>
</html>