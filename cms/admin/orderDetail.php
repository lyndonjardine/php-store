<?php
session_start();
include("dbinfo.php");
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
    if(mysqli_num_rows($result) > 0 ){
        //echo "Login success<br/>";
    }else{
		echo mysqli_num_rows($result);
		echo "Login failure<br/>";
		//print_r($_SESSION);
		echo "admin: ".$admin_id."<br/>";
		echo "session: ".$sessionID."<br/>";
		header("Location:login.php");
    }

}else{
	//$admin_error1 = 1;
	header("Location:login.php");
}

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
        <link rel="stylesheet" href="style.css">
        
    </head>
<body>






<div class="container-fluid">

    <div class='col-sm-2'></div>
    <div class='col-sm-6'>
    <h1 class='text-primary'>Customer Receipt</h1>

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

                if(isset($_POST['order_id']) && $_POST['order_id'] != ''){
                    $order_id  = $_POST['order_id'];
                }else{
                    echo "ORDER: ".$order_id;
                    header("Location:view_orders.php");
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
                        echo "<a href='view_orders.php'>Go Back</a> ";

                    }else{
                        //header("Location:index.html");
                        echo "error getting order info";
                    }
                ?>
            </div>
        </div>

    </div>





</div> <!-- container-fluid -->