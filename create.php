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

if (isset($_POST['submit'])) {
    //write a prepared statement to insert data
    $insert = $connection->prepare("INSERT INTO `Scp Foundation` (CLASS, DESCRIPTION, CONTAINMENT, IMAGE, ITEM) values(?,?,?,?,?) ");
    $insert->bind_param("sssss", $_POST['CLASS'], $_POST['DESCRIPTION'], $_POST['CONTAINMENT'], $_POST['IMAGE'], $_POST['ITEM']);

    if ($insert->execute()) {
        echo "<div class='alert alert-success p-3'>Record successfully created</div>";
    } else {
        echo "<div class='alert alert-danger p-3'>Error: {$insert->error}</div>";
    }
}
?>

<h1>Create a new SCP Foundation record</h1>
<p><a href="index.php" class="btn btn-dark">Back to index page</a></p>
<div class="p-3 bg-dark text-white rounded">
    <form method="post" action="create.php" class="">
        <label>Enter SCP Item:</label>
            <br>
            <input type ="text" name="ITEM" placeholder="item..." class="form-control" >
            <br><br>
            <label>Enter SCP foundation Class:</label>
            <br>
            <input type ="text" name="CLASS" placeholder="class..." class="form-control" required>
            <br><br>
            <label>Enter description:</label>
            <br>
            <textarea name="DESCRIPTION" class="form-control" placeholder="Enter description"></textarea>
            <br><br>
            <label>Enter Containment:</label>
            <br>
            <input type ="text" name="CONTAINMENT" placeholder="containment..." class="form-control" >
            <br><br>
            <label>Enter image:</label>
            <br>
            <input type ="text" name="IMAGE" placeholder="images/nameofimage...." class="form-control" >
            <br><br>
            <input type="submit" name="submit" class="btn btn-primary">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>