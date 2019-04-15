<?php
session_start();
include("dbinfo.php");
require_once '../libs/phpThumb/src/ThumbLib.inc.php';
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$admin_error1 = 0;
$admin_error2 = 0;
//code to ensure the user is logged in
if(isset($_SESSION['admin_id'])){
	//echo $_SESSION['admin_id'];
	//echo "<br/>";
	//echo session_id();
	
	$sessionID = session_id();
	$admin_id = $_SESSION['admin_id'];
	//echo $sessionID."<br/>";
	//echo $admin_id;

	$sql = "SELECT * FROM current_sessions WHERE admin_id = '".$admin_id."' AND sessionID = '".$sessionID."'";
    $result = mysqli_query($conn, $sql);

    //if exactly 1 row is returned, the login is a success
    if(mysqli_num_rows($result) >0 ){
		//echo "Login success<br/>";
		
    }else{
		echo "Login failure";
		header("Location:login.php");
    }

}else{
	//$admin_error1 = 1;
	header("Location:login.php");
}

?><?php

	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
    
  	$catdropdown=mysqli_real_escape_string($conn, $_POST['catdropdown']);
  	$title=mysqli_real_escape_string($conn, $_POST['title']);
  	$description=mysqli_real_escape_string($conn, $_POST['description']);
  	$price=mysqli_real_escape_string($conn, $_POST['price']);
  	$quantity=mysqli_real_escape_string($conn, $_POST['quantity']);
	$sku=mysqli_real_escape_string($conn, $_POST['sku']);
  	$image=basename(mysqli_real_escape_string($conn,$_FILES['uploaded']['name']));
  
  	$errors = 0;
  
  	if ($title=="") $errors=1;
  	if ($description=="") $errors=2;
  	if ($price=="") $errors=3;
  	if ($quantity=="") $errors=4;
  	if ($sku=="") $errors=5;
  	if ($image=="") $errors=6;
	
	$TableName = "items";
	$sql = "SELECT * FROM $TableName WHERE title='$title'";
	$DuplicateCheck = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	if ( mysqli_num_rows($DuplicateCheck) > 0 ) {  $errors=7; $is_duplicate="yes"; }	  

	if ($errors>0) {
		
?>  
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Check Item Add</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=b2a98his3fl6m8p9ynl8vqhjpbjx0aq666q567oremqxgnbt'></script>
		<script>
		tinymce.init({
			selector: '#description'
		});
		</script>
	</head>

	<body>

		<h2>Enter Item Details Below</h2>
		<FONT color=red><h2>All Fields Are Required</h2></font>

   		<FORM action="check_item_add.php" method="POST" enctype="multipart/form-data">
 	
			Category: <select name="catdropdown">
    						<option value = "">Choose a category</option>
<?php
   
	$sql = "SELECT category_id, category FROM categories";
	$result = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($row = mysqli_fetch_assoc($result)) {
			$category_id = $row['category_id'];
			$category = $row['category'];
			echo "<option value=\"$category_id\" ";
			if ($catdropdown==$category_id) echo " SELECTED ";
			echo ">$category\n";
	}
?>	
	 		</select>
			<?php if ($catdropdown=="") echo "<font color=red> *required</font>"; ?>
	 		<br /><br />
      		Title: 		<input type="text" name="title" value="<?php echo "$title"; ?>" />
			<?php if ($title=="") echo "<font color=red> *required</font>"; ?>
			<?php if ($title!="" && $is_duplicate=="yes") echo "<font color=red> *duplicate</font>"; ?>
      		<br /><br />
	  		Description : 	<input type="text" id='description' name="description" value="<?php echo "$description"; ?>" />
			<?php if ($description=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
			Price: 		<input type="text" name="price" value="<?php echo "$price"; ?>" />
			<?php if ($price=="") echo "<font color=red> *required</font>"; ?>
			<br /><br />
	  		Quantity:		<input type="text" name="quantity" value="<?php echo "$quantity"; ?>" />
			<?php if ($quantity=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
	  		SKU  : 			<input type="text" name="sku" value="<?php echo "$sku"; ?>" />
			<?php if ($sku=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
	 		Please choose an image: <input name="uploaded" type="file" /><?php echo "<font color=red> *required</font>"; ?>
	 		<br /><br />

      		<input type="submit" name="submit" value="Add" />
   		</FORM>

	</body>

</html>
<?php
		mysqli_close($conn);
		
  	} else {

		$SQLString = "INSERT INTO $TableName(Category, title, description, price, quantity, sku, picture) 
						VALUES('$catdropdown', '$title', '$description', '$price', '$quantity', '$sku', '$image')";
		$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

		$target = "../../images/"; 
 		$target = $target . basename( $_FILES['uploaded']['name']) ; 
 		move_uploaded_file($_FILES['uploaded']['tmp_name'], $target);

		mysqli_close($conn);

		//PHPTHUMB CODE FOR TH AND LRG IMAGES
		try
		{
			//grab the image
			$phpImage = PhpThumbFactory::create('../../images/'.$image);
		}
		catch (Exception $e)
		{
			echo "error creating php image";
		}

		// do your manipulations
		//resize the large image
		$phpImage->resize(250,250);
		//save it with the lrg_ prefix
		$phpImage->save("../../images/lrg_".$image);
		$phpImage->resize(100,100);
		$phpImage->save("../../images/tn_".$image);


		header("Location:./view_items.php");
	}
	
?>
  


