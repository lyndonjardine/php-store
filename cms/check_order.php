<?php
session_start();
//get the users IP
$user_ip = $_SERVER['REMOTE_ADDR'];
$sessionID = session_id();

include("admin/dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!($conn)) {
  die ("Connection failed: " . mysqli_connect_error());
} else{
    //echo "success";
}


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



$error = 0;
$fNameError = 0;
$lNameError = 0;
$phoneError = 0;
$emailError = 0;
$formatError = 0;

$firstName = "";
$lastName = "";
$phone = "";
$email = "";


if(isset($_POST['first_name']) && $_POST['first_name'] != ''){
    $firstName = mysqli_real_escape_string($conn,$_POST['first_name']);
}else{
    $fNameError = 1;
    $error = 1;
}

if(isset($_POST['last_name']) && $_POST['last_name'] != ''){
    $lastName = mysqli_real_escape_string($conn,$_POST['last_name']);
}else{
    $lNameError = 1;
    $error = 1;
}

if(isset($_POST['phone']) && $_POST['phone'] != ''){
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
}else{
    $phoneError = 1;
    $error = 1;
}

if(isset($_POST['email']) && $_POST['email'] != ''){
    //$category=mysqli_real_escape_string($conn, $_POST['category']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    //check if its a valid email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $formatError = 1;
        $error = 1;
    }

}else{
    $emailError = 1;
    $error = 1;
}


if($error == 1){
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
        
        <!-- Custom CSS -->
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
                    <li ><a href="viewProduct.php">Browse</a></li>
                </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <li class='active'><a href='cart.php'><span class='glyphicon glyphicon-shopping-cart'></span>Cart</a></li>
                </ul>
            </div>
        </nav>



        <div class="container-fluid">
            <br/>
            <div class = 'col-sm-1'> </div>
            <div class = 'col-sm-5'>
                <h1>Your Shopping Cart</h1>
            </div>
            <div class = 'col-sm-6'></div>
        </div>
        <hr/>
        <div class='container-fluid'>
            <table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th class='col-sm-1'></th>
                        <th class='col-sm-9 text-info'>Item</th>
                        <th class='col-sm-1 text-info'>Quantity</th>
                        <th class='col-sm-1 text-info'>Price</th>
                    </tr>
                </thead>
                
                <?php
                    //get the user's session ID and ip address, and return all the item ids in 'cart' with the matching data
                    $sql = "SELECT * FROM cart WHERE userID = '".$userID."'";
                    $result = mysqli_query($conn, $sql);
                    
                    //initialize var for total price
                    $totalPrice = 0;
                    
                    if(mysqli_num_rows($result) > 0){
                        
                        while($row = mysqli_fetch_assoc($result)){
                            
                            //for each item in the cart
                            //do a second select statement to find the name of the item_id
                            $sql2 = "SELECT * FROM items WHERE item_id = '".$row['item_id']."'";
                            $result2 = mysqli_query($conn, $sql2);
                            if(mysqli_num_rows($result2) > 0){
                                while($row2 = mysqli_fetch_assoc($result2)){
                                    //calculate the total price with quantity
                                    $price = $row2['price'] * $row['quantity'];
                                    //echo "Total Price: ".$price;
                                    
                                    echo "<tr>";
                                        echo "<td><img src='../images/tn_".$row2['picture']."' /></td>";
                                        echo "<td><h4 class='text-primary'>".$row2['title']."</h4></td>";
                                        
                                        //options to update quantity, or remove from cart
                                        echo "<td>
                                        <form action='updateCart.php' method='POST'>
                                            <input type='hidden' value='".$row['cart_id']."' name='cartID' />
                                            <input type='number'value='".$row['quantity']."' name='newQuantity' />
                                            <button type='submit' class='btn btn-default updateBtn'>Update</button>    
                                        </form>

                                        <form action='removeItem.php' method='POST'>
                                            <input type='hidden' value='".$row['cart_id']."' name='cartID' />
                                            <button type='submit' class='btn btn-danger'>Remove</button>
                                        </form>

                                        </td>";
                                        echo "<td>$".$price."</td>";
                                    echo "</tr>";
                                }
                            }

                                $totalPrice += $price;

                        }
                    }else{
                        echo "No items in cart";
                    }

                ?>
            </table>
        </div>


        <div class='container-fluid'>
            <div class='col-sm-6'></div>

            <div class='panel panel-info col-sm-5'>
                <div class='panel-body'>

                    <form action='#' method='POST'>
                        <div class='form-group'>
                            <label for="first_name">First name:</label> 
                            <input id='first_name' class='form-control' type='text' name='first_name' value='<?php echo $firstName; ?>'/>
                            <?php
                                if($fNameError ==1 ){
                                    echo "<p class='text-danger'>First name is Required!</p>";
                                }
                            ?>
                        </div>
                        <div class='form-group'>
                            <label for="last_name">Last name:</label> 
                            <input type='text' class='form-control' id='last_name' name='last_name' value='<?php echo $lastName; ?>'/>
                            <?php
                                if($lNameError ==1 ){
                                    echo "<p class='text-danger'>Last name is Required!</p>";
                                }
                            ?>
                        </div>
                        <div class='form-group'>
                            <label for="phone">Phone#:</label> 
                            <input type='text' class='form-control' id='phone' name='phone' value='<?php echo $phone; ?>'/>
                            <?php
                                if($phoneError ==1 ){
                                    echo "<p class='text-danger'>Phone Number is Required!</p>";
                                }
                            ?>
                        </div>
                        <div class='form-group'>
                            <label for="email">Email:</label> 
                            <input type='text' class='form-control' id='email' name='email' value='<?php echo $email; ?>'/>
                            <?php
                                if($formatError == 1){
                                    echo "<p class='text-danger'>Invalid Email!</p>";
                                }
                                if($emailError ==1 ){
                                    echo "<p class='text-danger'>Email is Required!</p>";
                                }
                            
                            ?>
                        </div>

                        <h2 >Subtotal:</h2>
                        <h2 class='text-success'>$<?php echo $totalPrice; ?></h2>
                        <button type='submit' class='btn btn-success btn-lg' role='button'>Submit Order</button>
                    </form>
                
                </div>
            </div>
        </div>

    </body>
</html>
<?php
}else{
    //THE USER SUCCESSFULLY ENTERED ALL DATA
    $orderSuccess = 0;
    //insert the order into the database
    $insertOrderSQL = "INSERT INTO order_info (firstName, lastName, phone, email, userID) VALUES('".$firstName."', '".$lastName."', '".$phone."', '".$email."', ".$userID.") ";
    if(mysqli_query($conn, $insertOrderSQL)){
        //echo "success";
        $orderSuccess = 1;
    }else{
        echo "Error: " . $insertOrderSQL . "<br>" . mysqli_error($conn);
    }

    //get the order_ID
    if($orderSuccess == 1){
        $getOrderSQL = "SELECT order_id FROM order_info WHERE userID = '".$userID."'";
        $orderResult = mysqli_query($conn, $getOrderSQL);

        if(mysqli_num_rows($orderResult) > 0){
            while($row = mysqli_fetch_assoc($orderResult)){
                $order_id = $row['order_id'];
            }
            //the most recent order(the one that was just made) is set as $order_id
            //echo "orderID:".$order_id;

            //loop through the cart, move each item into items_sold
            $sql = "SELECT * FROM cart WHERE userID = '".$userID."'";
            $result = mysqli_query($conn, $sql);

            

            if(mysqli_num_rows($result) > 0){
                        
                while($row = mysqli_fetch_assoc($result)){
                    
                    //for each item in the cart
                    //do a second select statement to find the name of the item_id
                    $sql2 = "SELECT * FROM items WHERE item_id = '".$row['item_id']."'";
                    $result2 = mysqli_query($conn, $sql2);
                    if(mysqli_num_rows($result2) > 0){
                        while($row2 = mysqli_fetch_assoc($result2)){
                            //insert each item into items_sold
                            //$price = $row2['price'] * $row['quantity'];
                            $insertItemSQL = "INSERT INTO items_sold (item_id, order_id, sell_price, sell_quantity) VALUES(".$row2['item_id'].", ".$order_id.", ".$row2['price'].", ".$row['quantity']."   )";
                            if(mysqli_query($conn, $insertItemSQL)){
                                //echo "item sold!".$row2['item_id']."<br/>";
                                //if the item was sold successfully, subtract from the item quantity and remove it from the cart
                                $oldQuantity = $row2['quantity'];//get the old quantity
                                $newQuantity = $oldQuantity - $row['quantity'];//subtract the quantity sold from the old quantity
                                //update the items table
                                $updateItemQuantitySQL = "UPDATE items SET quantity=".$newQuantity." WHERE item_id = ".$row2['item_id']." ";
                                if(mysqli_query($conn, $updateItemQuantitySQL)){
                                    echo "new quantity: ".$newQuantity;
                                    //if the quantity was successfully updated, remove the item from the cart table

                                    $removeFromCartSQL = "DELETE FROM cart WHERE cart_id = ".$row['cart_id']." ";
                                    if(mysqli_query($conn, $removeFromCartSQL)){
                                        echo "item removed from cart!";
                                        header("Location:order_thankyou.php");
                                    }else{
                                        echo "error removing item from cart!";
                                    }
                                }else{
                                    echo "error updating quantity!";
                                }
                            }
                        }
                    }
                }
            }else{
                echo "No items in cart";
            }
        }
    }
}

    mysqli_close($conn);
?>
