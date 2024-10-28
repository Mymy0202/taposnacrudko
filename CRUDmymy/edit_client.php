<?php
session_start();
if(!isset($_SESSION{'username'})|| $_SESSION['role'] !='admin'){
    header("Location: index.php");
}

    //Include connection string
    include('database/connection.php');
    //Check if Client ID is provided in the URL
    if(isset($_GET['ID']))
    { 
        $client_id = $_GET['ID'];
        //fetch the current client data
        $sql = "SELECT * FROM users WHERE ID = '$client_id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $role = $row['role'];
        }

    }
    else{
        header("Location: admin_dashboard.php");
    }
    //UPDATE FUNCTION
    if(isset($_POST['update']))
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $role = $_POST['role'];
        $update_sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', role = '$role' WHERE ID = '$client_id'";
        if($conn->query($update_sql) === TRUE)
        {
            header("Location: Admin_dashboard.php?UpdatedSuccess");
        }
        else
        {
            echo "Error Updating Client".$conn->error;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
</head>
<body>
    <h2>Edit Client Information</h2>
    <form action="" method="post">
        Firstname
        <input type="text" name="firstname" id="" value="<?php echo $firstname; ?>" required> <br>
        Lastname
        <input type="text" name="lastname" id="" value="<?php echo $lastname; ?>" required> <br>
        Role: <br>
        <select name="role" id="">
            <option value="client" <?php if($role == 'client') echo 'selected';?>>Client</option>
            <option value="admin" <?php if($role == 'admin') echo 'selected';?>>Admin</option>
        </select>
        <br>
        <input type="submit" value="Update Record" name="update">
    </form>
</body>
</html>