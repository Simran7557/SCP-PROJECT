<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP FOUNDATION</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="styles/style.css" rel="stylesheet">
    <script>
        // JavaScript function to confirm deletion
        function confirmDelete(deleteUrl) {
            if (confirm("Are you sure you want to delete this record?")) {
                // Redirect to the delete URL if confirmed
                window.location.href = deleteUrl;
            }
        }
    </script>
</head>

<body class="container">
    <?php
    // Include the database connection file
    include "connection.php";
    
    // Check if the 'delete' parameter is set in the GET request
    if (isset($_GET['delete'])) {
        // Retrieve the ITEM value from the GET request
        $delID = $_GET['delete'];
        
        // Prepare the delete query
        $delete = $connection->prepare("DELETE FROM `Scp Foundation` WHERE ITEM=?");
        
        // Bind the ITEM parameter
        $delete->bind_param("s", $delID);  // Use "s" for string (ITEM is a text field)
        
        // Execute the query and check if the deletion was successful
        if ($delete->execute()) {
            echo "<div class='message'>Record Deleted from SCP</div>";
        } else {
            echo "<div class='error-message'>Error deleting record from SCP: {$delete->error}</div>";
        }
    }
    ?>
    
    <div>
        <ul class="nav navbar-dark bg-dark rounded">
            <!-- Loop through the result and display navigation links dynamically -->
            <?php 
                // Fetch all items from the database for the navigation links
                $results = $connection->query("SELECT ITEM FROM `Scp Foundation`");
                while ($link = $results->fetch_assoc()) {
            ?>
                <li class="nav-item active">
                    <a href="index.php?link=<?php echo $link['ITEM']; ?>" class="nav-link text-light">
                        <?php echo htmlspecialchars($link['ITEM']); ?>
                    </a>
                </li>
            <?php } ?>

            <!-- Link to create a new SCP record -->
            <li class="nav-item active">
                <a href="create.php" class="nav-link text-light">Create A New SCP Foundation Record</a>
            </li>
        </ul>
    </div>
    
    <h1 class="display-1">SCP FOUNDATION</h1>
    
    <div class="p-3 bg-dark text-white rounded">
        <?php
            // Check if an ITEM link has been clicked by the user (via the GET parameter 'link')
            if (isset($_GET['link'])) {
                // Escape the GET parameter to prevent SQL injection
                $ITEM = $connection->real_escape_string($_GET['link']);
                
                // Run an SQL query to retrieve the record for the selected SCP ITEM
                $scp = $connection->query("SELECT * FROM `Scp Foundation` WHERE ITEM = '$ITEM'");

                // Check if the query returned any rows
                if ($scp->num_rows > 0) {
                    // Fetch the result as an associative array
                    $array = $scp->fetch_assoc();
                    
                    $update = "update.php?update=" . $array['ITEM'];
                    $delete = "index.php?delete=" . $array['ITEM'];
                    
                    // Output the details of the selected item
                    echo "
                        <h2>" . htmlspecialchars($array['ITEM']) . "</h2>  <!-- Display the item name -->
                        <h3>" . htmlspecialchars($array['CLASS']) . "</h3>  <!-- Display the class -->
                        <p>" . htmlspecialchars($array['DESCRIPTION']) . "</p>  <!-- Display the description -->
                        <p>" . nl2br(htmlspecialchars($array['CONTAINMENT'])) . "</p>  <!-- Display the containment -->
                        <p>
                            <img src='" . htmlspecialchars($array['IMAGE']) . "' alt='" . htmlspecialchars($array['ITEM']) . "'>  <!-- Display the image -->
                        </p>
                        <p>
                            <a href='{$update}' class='button'>Update Record</a>
                            <a href='#' onclick=\"confirmDelete('{$delete}')\" class='button'>Delete Record</a>
                        </p> 
                    ";
                } else {
                    // If no records were found, display an error message
                    echo "<p>No records found for the selected item.</p>";
                }
            } else {
                // If no item link was clicked, display a default message
                echo "
                    <h3>Please use the menu above to navigate this application</h3>
                ";
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
