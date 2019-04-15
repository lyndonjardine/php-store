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










//if the catID is set, this is so only the items in the category selected are displayed
if(isset($_POST['catID'])){
    $itemCatID=$_POST['catID'];
    $sql = "SELECT category FROM categories WHERE category_id = '".$itemCatID."'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $catName = $row['category'];
            //echo $catName;
        }
    }

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



<h1>Product View</h1>
<a href="index.html">Return To Main</a>
<br/>




		<div class="col-lg-3">
        <h2>Categories</h2>
            <!-- CATEGORY SIDE -->
            <table class='table-bordered table-striped table-responsive'>
                <tr>
                    <th>Category</th>
                    <th># of items</th>
                    <th>View category</th>
                </tr>
                
                    <?php
                        //code for each category
                        $sql="SELECT * FROM categories";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $catID = $row['category_id'];
                                echo "<tr>";
                                    echo "<td>'".$row['category']."'</td>";
                                    //second sql statement to get the number of items in each cat
                                    $sql2 = "SELECT * FROM items WHERE category = '".$catID."' ";
                                    $result2 = mysqli_query($conn, $sql2);
                                    echo "<td>".mysqli_num_rows($result2)."</td>";
                                    
                                    //make a form and submit button and pass the cat id through post, to go to a view category page to view all the items in that category
                                    echo "<td><form action='viewProduct.php', method='POST'>";
                                        echo "<input type='hidden'name='catID' value='".$catID."'></input>";
                                        echo "<input type='submit' value='View Items'/>";
                                    echo "</form></td>";


                                echo "</tr>";
                            }
                        }
                    ?>

            </table>
        </div>

        <div class="col-lg-9">
        <!-- ITEM SIDE -->
        <table class='table-bordered table-striped table-responsive'>
                <tr>
                    <th>Preview</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Purchase</th>
                </tr>
                
                    <?php
                        //check if category post is set and only select the items with that catID
                        if(isset($itemCatID)){
                            $sql="SELECT * FROM items WHERE category='".$itemCatID."'";
                            echo "<h2>You are viewing items in: ".$catName.", <a href='viewProduct.php'>Click here to go back</a></h2>";

                        }else{
                            $sql="SELECT * FROM items";
                            echo "<h2>You are viewing all items</h2>";
                        }

                        //code for each item
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $itemID = $row['item_id'];
                                echo "<tr>";
                                    echo "<form action='productDetail.php' method='POST'>";
                                        echo "<input type='hidden' name='itemID' value='".$itemID."'></input>";
                                        //image input type acts as a submit button AND an image
                                        echo "<td><input type='image' src='../images/tn_".$row['picture']."' ></input></td>";
                                    echo "</form>";

                                    echo "<form action='productDetail.php' method='POST'>";
                                        echo "<input type='hidden' name='itemID' value='".$itemID."'></input>";
                                        echo "<td class='itemTitle'> <input type='submit' class='detailButton' value='".$row['title']."' > </input></td>";
                                    echo "</form>";

                                    echo "<td>$".$row['price']."</td>";
                                    //make a form and submit button and pass the cat id through post, to go to a view category page to view all the items in that category
                                    echo "<td><form action='addToCart.php', method='POST'>";
                                        echo "<input type='hidden' name='itemID' value='".$itemID."'></input>";
                                        echo "<input type='submit' value='Buy Now!'/>";
                                    echo "</form></td>";


                                echo "</tr>";
                            }
                        }

                        mysqli_close($conn);
                    ?>

            </table>


        </div>
        


		

</div> <!-- container-fluid -->
</body>
</html>