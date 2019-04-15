<?php
session_start();
include("admin/dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!($conn)) {
  die ("Connection failed: " . mysqli_connect_error());
} else{
    //echo "success";
}
if(isset($_POST['itemID'])){
    $itemID = $_POST['itemID'];
}else{
    header("Location:viewProduct.php");
}

$sessionID = session_id();
$user_ip = $_SERVER['REMOTE_ADDR'];

//CHECK IF THIS USER IS ALREADY IN OUR RECORDS, if not, create a new user.
$selectUserSql = "SELECT * FROM users WHERE sessionID = '".$sessionID."' AND user_ip = '".$user_ip."'";
$result = mysqli_query($conn, $selectUserSql);


if(mysqli_num_rows($result) > 0){
    //IF THE USER EXISTS IN RECORDS
    while($row = mysqli_fetch_assoc($result)){
        $userID = $row['id'];
    }


    //select the user's id

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

//echo "<br/>user id: $userID<br/>";







$sql = "SELECT * FROM items WHERE item_id = '".$itemID."' ";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="admin/style.css">
        
    </head>
    <body>
        <nav class="navbar navbar-inverse customNav">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">PC STORE</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="index.html">Home</a></li>
                    <li class='active'><a href="viewProduct.php">Browse</a></li>
                </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <li><a href='cart.php'><span class='glyphicon glyphicon-shopping-cart'></span>Cart</a></li>
                </ul>
            </div>
        </nav>

    <div class="container-fluid">
        <br/><br/><br/>
        <?php
    while($row = mysqli_fetch_assoc($result)){
                //display the item data
                echo "<div class='col-sm-1'></div>";

                //column to display picture
                echo "<div class='col-sm-4 img'>
                <img src='../images/lrg_".$row['picture']."'></img><br/><br/>
                
                <form action='addToCart.php' method='POST' class='form-inline'>
                    <label for='quantity'>Quantity: </label>
                    <input type='number' name='quantity' value=1 class='form-control' /><br/><br/>
                    <input type = 'hidden' name='itemID' value = '".$itemID."'>
                    <button type='submit' class='btn btn-success buyButton'>Add To Cart</button>
                </form>

                </div>";
                //column to display other data

                //sql statement to grab the category name
                $sqlCategory = "SELECT category FROM categories WHERE category_id = '".$row['category']."' ";
                $catResult = mysqli_query($conn, $sqlCategory);
                while($catRow = mysqli_fetch_assoc($catResult)){
                    $catValue = $catRow["category"];
                }

                echo "<div class='col-sm-7'>
                    <h4 class = 'text-muted'>".$catValue."</h4>
                    <h1 class='text-primary'>".$row['title']."</h1>
                    <h4 class='text-muted'>ID: ".$row['item_id']."</h4>
                    <h4 class='text-muted'>Sku: ".$row['sku']."</h4>
                    <h2 class='text-success'>$".$row['price']."</h2>
                    <h4 class='text-info'>In-Stock: ".$row['quantity']." </h4><br/><hr/><br/>
                    <div class='lead'>".$row['description']."</divSS>


                </div>";
            }
        ?>


    </div>


<?php
mysqli_close($conn);
?>
</body>
</html>