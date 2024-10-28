<?php
//CALL CONNECTION STRING
include('database/connection.php');

//Check if user legitimate user
if(isset($_POST['register']))
{
    //set variables for user credentials
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = "client";
    //Sanitized username
    $username = $conn->real_escape_string($_POST['username']);
    $password =password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = "client";

    //check if username is already exist.
    $check_sql = "SELECT username FROM users WHERE username='$username'";
    //Execute sql command
    $result = $conn->query($check_sql);
    
    if($result->num_rows > 0)
    {
        header("Location: register.php?message=Username already taken. Please choose another one");
    }
    else
    {
        //username is available, proceed with registration
        $sql = "INSERT INTO users (`ID`,`firstname`,`lastname`,`username`,`password`,`role`)VALUES (Null, '$firstname', '$lastname','$username','$password','$role')";

        if($conn->query($sql) === TRUE)
        {
            header('Location: index.php');
        }
        else
        {
            echo "Error: ".$sql."<br>".$conn->error;
        }
    }
}

?>