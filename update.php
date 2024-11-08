
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP FOUNDATION</title>
    <link href="styles/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="container">

<?php 
    include "connection.php";

    if (isset($_GET['update'])) {
        $ID = $_GET['update'];
        $recordID = $connection->prepare("SELECT * FROM `Scp Foundation` WHERE ID = ?");
        
        if ($recordID) {
            $recordID->bind_param("i", $ID);
            if ($recordID->execute()) {
                $temp = $recordID->get_result();
                $row = $temp->fetch_assoc();
            } else {
                echo "<div class='alert alert-danger'>Error fetching data: {$recordID->error}</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error preparing statement: {$connection->error}</div>";
        }
    }

    if (isset($_POST['update'])) {
        // Capture POST variables
        $id = $_POST['ID'];
        $class = $_POST['CLASS'];
        $description = $_POST['DESCRIPTION'];
        $containment = $_POST['CONTAINMENT'];
        $image = $_POST['IMAGE'];
        $item = $_POST['ITEM'];

        // Prepare the update statement
        $update = $connection->prepare("UPDATE `Scp Foundation` SET CLASS=?, DESCRIPTION=?, CONTAINMENT=?, IMAGE=?, ITEM=? WHERE ID=?");
        
        if ($update) {
            $update->bind_param("sssssi", $class, $description, $containment, $image, $item, $id);
            
            if ($update->execute()) {
                echo "<div class='alert alert-success p-3'>Record successfully updated.</div>";
            } else {
                echo "<div class='alert alert-danger p-3'>Update error: {$update->error}</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error preparing update statement: {$connection->error}</div>";
        }
    }
?>

<h1>Update a SCP Foundation record</h1>
<p><a href="index.php" class="btn btn-dark">Back to index page</a></p>
<div class="p-3 bg-dark text-white rounded">
    <form method="post" action="update.php?update=<?php echo htmlspecialchars($ID); ?>" class="">
        <input type="hidden" name="ID" value="<?php echo htmlspecialchars($row['ID']); ?>">
        
        <label>Enter SCP Item:</label>
        <br>
        <input type="text" name="ITEM" placeholder="item..." class="form-control" value="<?php echo htmlspecialchars($row['ITEM']); ?>">
        <br><br>
        
        <label>Enter SCP Foundation Class:</label>
        <br>
        <input type="text" name="CLASS" placeholder="class..." class="form-control" required value="<?php echo htmlspecialchars($row['CLASS']); ?>">
        <br><br>
        
        <label>Enter Description:</label>
        <br>
        <textarea name="DESCRIPTION" class="form-control" placeholder="Enter description"><?php echo htmlspecialchars($row['DESCRIPTION']); ?></textarea>
        <br><br>
        
        <label>Enter Containment:</label>
        <br>
        <input type="text" name="CONTAINMENT" placeholder="containment..." class="form-control" value="<?php echo htmlspecialchars($row['CONTAINMENT']); ?>">
        <br><br>
        
        <label>Enter Image:</label>
        <br>
        <input type="text" name="IMAGE" placeholder="images/nameofimage...." class="form-control" value="<?php echo htmlspecialchars($row['IMAGE']); ?>">
        <br><br>
        
        <input type="submit" name="update" value="Update Record" class="btn btn-primary">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
