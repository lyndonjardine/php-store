<?php
    session_start();
    include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 

    //get the username and password
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    //TODO HASH THE PASSWORD

    //select matching username and password
    //$sql = "SELECT * FROM admin_info WHERE username = '".$username."' AND password = '".$password."' AND active = 1";
    //$result = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM admin_info WHERE username = '".$username."' AND active = 1";
    $result = mysqli_query($conn, $sql);


    //if exactly 1 row is returned, the login is a success
    if(mysqli_num_rows($result) == 1 ){
        //echo "Login success<br/>";
        
        while($row = mysqli_fetch_assoc($result)) {
            //check if the password entered matches the hashed password
            if(password_verify($password, $row['password']) == true){

                //put the id returned into a session variable
                $_SESSION['admin_id'] = $row['admin_id'];
                $admin_id = $_SESSION['admin_id'];
                $time = time();
                $sessionID = session_id();
                //echo $_SESSION['admin_id'];
                
                //insert a record for current sessions, SESSION_ID WILL NOT WORK
                $sql = "INSERT INTO current_sessions (sessionID, admin_id, login_time) 
                VALUES('".$sessionID."', '".$admin_id."', '".$time."')";
                if(mysqli_query($conn, $sql)){
                    echo "success";
                }else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }else{
                //wrong password
                echo "Login failure";
                header('Location:login.php');
            }

        }
        //redirect to home page
        header("Location:index.php");

    }else{
        echo "Login failure";
        header("Location:login.php");
    }
    //print_r($_SESSION);
    //session_destroy(); //REMOVE THIS LATER
?>