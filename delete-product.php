
<?php
// delete-product.php - Handle Product Deletion

// 1. Include the Database Connection
require_once 'config/db.php';

// 2. Validate that an ID parameter exists and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int) $_GET['id'];

    // 3. Prepare the DELETE SQL query
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    
    if ($stmt) {
        // Bind the integer product ID
        $stmt->bind_param("i", $product_id);

        // Execute the deletion
        if ($stmt->execute()) {
            // Check if a row was actually affected
            if ($stmt->affected_rows > 0) {
                // Redirect with deletion success status
                header("Location: products.php?status=deleted");
                exit();
            } else {
                // Product ID was not found in DB
                header("Location: products.php?status=notfound");
                exit();
            }
        } else {
            echo "Error executing delete: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "SQL Error: " . $conn->error;
    }

} else {
    // If no valid ID was passed in GET request, redirect back
    header("Location: products.php");
    exit();
}
?>
