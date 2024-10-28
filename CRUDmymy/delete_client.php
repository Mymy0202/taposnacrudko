<?php
session_start();
if(!isset($_SESSION{'username'})|| $_SESSION['role'] !='admin'){
    header("Location: index.php");
}

    //Include connection string
    include('database/connection.php');
//Check if client ID is provided in the URL
if(isset($_GET['ID']))
{
    $client_id = $_GET['ID'];
    //sql Delete the client fromthe database
    $delete_sql = "DELETE FROM users WHERE ID = '$client_id'";
    if($conn -> query($delete_sql) === TRUE)
    {
        header("Location: admin_dashboard.php?DeleteSuccess");
    }
    else
    {
        echo "Error Deleting Client".$conn->error;
    }
}
else
{
    header("Location; Admin_dashboard.php");
}
?>