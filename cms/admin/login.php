<?php


echo "<h1>Inventory Management System</h1><br/>";

if(isset($_POST['badLogin'])){
    echo"<p style='color:red'>Wrong username or password</p><br/>";
}

echo "<form action='checkLogin.php' method='POST'>";
echo "Username: <input type='text' name='username'></input><br/><br/>";
echo "Password: <input type='password' name='password'></input><br/><br/>";
echo "<input type='submit' value='submit' />";
echo "<br/><br/>";
echo "<a href='../index.html'>Go Back</a>";

?>