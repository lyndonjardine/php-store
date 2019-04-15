<?php
session_start();
include("admin/dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!($conn)) {
  die ("Connection failed: " . mysqli_connect_error());
} else{
    //echo "success";
}

//check if this page was reached correctly
if(isset($_POST['cartID']) && isset($_POST['newQuantity'])){
    $cartID = $_POST['cartID'];
    $newQuantity = $_POST['newQuantity'];
}else{
    header("Location:viewProduct.php");
}


//get the users session ID and ip address, the ip will be wrong if the user is using a proxy server
$sessionID = session_id();
$user_ip = $_SERVER['REMOTE_ADDR']; //this returns as '1' for localhost, this is IPv6, in IPv4 this would be 127.0.0.1

//CHECK IF THIS USER IS ALREADY IN OUR RECORDS, if not, create a new user.
$selectUserSql = "SELECT * FROM users WHERE sessionID = '".$sessionID."' AND user_ip = '".$user_ip."'";
$result = mysqli_query($conn, $selectUserSql);

if(mysqli_num_rows($result) > 0){
    //IF THE USER EXISTS IN RECORDS
    while($row = mysqli_fetch_assoc($result)){
        $userID = $row['id'];
    }

}else{
    //THE USER DOES NOT EXIST IN RECORDS
    //insert the user into records
    $insertUserSql = "INSERT INTO users (sessionID, user_ip) VALUES('".$sessionID."', '".$user_ip."')";
    if(mysqli_query($conn, $insertUserSql)){
        //success
    }else{
        echo "ERROR: ". $insertUserSql . mysqli_error($conn);
    }

    //select the user's id
    $selectUserSql = "SELECT * FROM users WHERE sessionID = '".$sessionID."' AND user_ip = '".$user_ip."'";
    $result = mysqli_query($conn, $selectUserSql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $userID = $row['id'];
        }
    }else{
        echo "THIS SHOULD NOT HAPPEN";
    }
}

//echo"UserID: ".$userID."<br/>";
//echo"New Quantity: ".$newQuantity."<br/>";
//echo"Cart ID: ".$cartID."<br/>";


//check if we have enough in stock
//first, get the item ID
$sql = "SELECT * FROM cart WHERE cart_id = '".$cartID."' ";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
    $itemID = $row['item_id'];
}

//second, get the quantity we have of that item
$sql = "SELECT * FROM items WHERE item_id = '".$itemID."'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
    $itemStock = $row['quantity'];
}
echo "STOCK: ".$itemStock;
echo "QUANTITY: ".$newQuantity;
if($itemStock > $newQuantity){
    $sql = "UPDATE cart SET quantity = '".$newQuantity."' WHERE cart_id ='".$cartID."' ";

    if(mysqli_query($conn, $sql)){
        header("Location:cart.php");
    }else{
        echo "Error updating quantity";
    }
}else{
    echo "<br/>new quantity exceeds our current stock!<br/>";
    echo "<a href='cart.php'>Click here to go back</a>";
    
}


