<?php
    //include the database connection file
    include('database/connection.php');
    //Start session to manage user data
    session_start();
    //check if the form is submited using log in button
    if(isset($_POST['login']))
    {
        //Sanitized username input to prevent SQL injection
        $username = $conn->real_escape_string($_POST['username']);
        //Get the password from the form (Note: not yet encrypted)
        $password = $_POST['password'];

        //SQL query to select user data from the database based on username
        $sql_user = "SELECT * FROM users WhERE username='$username'";
        //Execute query
        $result = $conn->query($sql_user);

        //Check if the query returned any results
        if($result->num_rows > 0)
        {
            //Username is on the database record
            $row = $result->fetch_assoc();

            //Verify the provided password against the stored hased password
            if(password_verify($password, $row['password']))
            {
                //if password is correct, set session variable for username and role
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['role'];

                //Redirect the user to the appropriate dashboard
                if($row['role'] == "admin")
                {  
                    header("Location: admin_dashboard.php");
                }
                else if($row['role'] == "client")
                {  
                    header("Location: client_dashboard.php");
                }
            }
            else
            {
                header("Location: index.php?incorrect");
            }
        }
        else
        {
            //Incorrect Username
            header("Location: index.php?incorrect");
        }
    }
?>