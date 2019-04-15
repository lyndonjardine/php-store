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
<link rel="stylesheet" href="style.css">
<a href='index.php'>Go Back</a>
<table>
    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>View Receipt</th>
    </tr>

    <?php
        $selectAllOrdersSQL = "SELECT * FROM order_info";
        $result = mysqli_query($conn, $selectAllOrdersSQL);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "
                    <tr>
                        <td>".$row['order_id']."</td>
                        <td>".$row['userID']."</td>
                        <td>".$row['firstName']."</td>
                        <td>".$row['lastName']."</td>
                        <td>".$row['phone']."</td>
                        <td>".$row['email']."</td>
                        <td>
                        <form action = 'orderDetail.php' method='POST'>
                            <input type='hidden' value='".$row['order_id']."' name='order_id'/>
                            <input type='submit' value = 'View' />
                        </form>
                        </td>
                    </tr>
                ";
            }
        }
            

    ?>
    


</table>