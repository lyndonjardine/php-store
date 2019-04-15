<?php
session_start();
include("admin/dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!($conn)) {
  die ("Connection failed: " . mysqli_connect_error());
} else{
    //echo "success";
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
      <li><a href="viewProduct.php">Browse</a></li>
    </ul>
    <ul class='nav navbar-nav navbar-right'>
        <li><a href='cart.php'><span class='glyphicon glyphicon-shopping-cart'></span>Cart</a></li>
    </ul>
  </div>
</nav>


<div class="container-fluid">

    <div class='col-sm-2'></div>
    <div class='col-sm-6'>
    <h1 class='text-primary'>Thank You!</h1>

        <div class='panel panel-info'>
            <div class='panel-heading'><h3>Order Receipt</h3></div>
            <div class='panel-body'>
                <table class="table table-condensed table-bordered table-striped table-responsive">
                    <tr>
                        <th>#</th>
                        <th>Item</th> 
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>


            <?php
                $itemCounter = 1;
                $totalPrice = 0;
                $totalQuantityPrice = 0;
                $itemName = "";

                //get the order id of the user
                $selectOrderSQL = "SELECT * FROM order_info WHERE userID = ".$userID." ";
                $orderResult = mysqli_query($conn, $selectOrderSQL);
                if(mysqli_num_rows($orderResult) > 0){
                    while($orderRow = mysqli_fetch_assoc($orderResult)){
                        $order_id = $orderRow['order_id'];
                    }
                }else{
                    header("Location:index.html");
                }


                //select each item in the table items_sold with the matching order_id
                $selectItemSQL = "SELECT * FROM items_sold WHERE order_id = ".$order_id." ";
                $itemSoldResult = mysqli_query($conn, $selectItemSQL);
                if(mysqli_num_rows($itemSoldResult) > 0){
                    while($soldRow = mysqli_fetch_assoc($itemSoldResult)){

                        //get the item name
                        $selectNameSQL = "SELECT title FROM items WHERE item_id = ".$soldRow['item_id']." ";
                        $nameResult = mysqli_query($conn, $selectNameSQL);
                        while($nameRow = mysqli_fetch_assoc($nameResult)){
                            $itemName = $nameRow['title'];
                        }


                        echo "<tr>
                            <td>".$itemCounter."</td>
                            <td>".$itemName."</td>
                            <td>".$soldRow['sell_quantity']."</td>
                            <td>".$soldRow['sell_price']."</td>
                        </tr>";
                        //calculate the price of the item multiplyed by the quantity of the item
                        $totalQuantityPrice = $soldRow['sell_price'] * $soldRow['sell_quantity'];
                        //add it to the total price
                        $totalPrice += $totalQuantityPrice;
                        $itemCounter++;
                    }
                    
                }


            ?>
            </table>
            

            <h3 class='text-info'>Customer Information</h3>
                <?php
                    //display the total price
                    echo "<h2>Total:</h2>";
                    echo "<h2 class='text-success'>$".$totalPrice."</h2>";
                    //get the order information again
                    $selectOrderSQL = "SELECT * FROM order_info WHERE order_id = ".$order_id." ";
                    $orderResult = mysqli_query($conn, $selectOrderSQL);
                    if(mysqli_num_rows($orderResult) > 0){
                        while($orderRow = mysqli_fetch_assoc($orderResult)){
                            $order_id = $orderRow['order_id'];
                            $first_name = $orderRow['firstName'];
                            $last_name = $orderRow['lastName'];
                            $phone = $orderRow['phone'];
                            $email = $orderRow['email'];
                        }
                        echo "<h4>First Name: ".$first_name."</h4>";
                        echo "<h4>Last Name: ".$last_name."</h4>";
                        echo "<h4>Phone Number: ".$phone."</h4>";
                        echo "<h4>Email: ".$email."</h4>";


                        //destroy the session, this closes the user's order, 
                        //if the user goes back to buy something else, it will be under a new session id and a new user id
                        session_destroy();

                    }else{
                        //header("Location:index.html");
                        echo "error getting order info";
                    }
                ?>
            </div>
        </div>

    </div>





</div> <!-- container-fluid -->
</body>
</html>