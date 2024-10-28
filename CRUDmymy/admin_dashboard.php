<?php
session_start();

if(!isset($_SESSION{'username'})|| $_SESSION['role'] !='admin'){
    header("Location: index.php");
}

    //Include connection string
    include('database/connection.php');

    //Create variable for search query
    $search_query = '';

    //Check if a search is submitted
    if(isset($_GET['search']))
    {
        $search_query = $conn->real_escape_string($_GET['search']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php
        echo "WELCOME Admin ".$_SESSION['username'];
    ?>
    <a href="logout.php">Logout</a>
    <br> <br>
    <!-- search form -->
     <form action="" method="get">
        <input type="text" name="search" id="" value="<?php echo $search_query;1?>" placeholder="search by username">
        <select name="search_field" id="">
            <option value="Username">username</option>
            <option value="Firstname">firstname</option>
            <option value="Lastname">lastname</option>
        </select>
        <input type="submit" value="search">
     </form>
     <br>
     <!-- Create table for list of records -->
      <table border="1" style="width: 60%;">
            <tr>
                <td>#</td>
                <td>Username</td>
                <td>Firstname</td>
                <td>Lastname</td>
                <td>Role</td>
                <td>Action</td>
            </tr>
            <?php
                //Modify SQL query base on the search input
                if(!empty($search_query))
                {
                    $search_field = $_GET['search_field'];
                    $sql = "SELECT * FROM users WHERE role='client' AND $search_field LIKE '%$search_query%'";
                }
                else
                {
                    $sql = "SELECT * FROM users WHERE role='client'";
                }

                $result = $conn->query($sql);
                //Check if any client is exists
                if($result->num_rows > 0)
                {
                    //Loop all records
                    $count = 1;
                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['firstname']."</td>";
                        echo "<td>".$row['lastname']."</td>";
                        echo "<td>".$row['role']."</td>";
                        echo "<td>";
                        echo "<a href='edit_client.php?ID=".$row['ID']."'> Edit </a> |";
                        echo "<a href='delete_client.php?ID=".$row['ID']."' onclick='return confirm(\"Are you sure you want to delete this client?\");'> Delete </a> |";
                        echo "</td>";
                        $count++;
                    }
                }
                else
                {
                    echo "<tr><td colspan=5>No Records Found!</td></tr>";
                }
            ?>
      </table>
</body>
</html>