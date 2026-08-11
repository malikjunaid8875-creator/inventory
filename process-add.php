<?php
// process-add.php - Form Submission Handler for Add Product

// Include database connection
require_once 'config/db.php';

// Verify the page was accessed via POST request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Collect and sanitize user inputs
    $product_name = trim($_POST['product_name'] ?? '');
    $item_code    = trim($_POST['item_code'] ?? '');
    $category_val = trim($_POST['category'] ?? ''); 
    $quantity     = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
    $unit_price   = isset($_POST['unit_price']) ? (float) $_POST['unit_price'] : 0.00;

    // 2. Server-side Validation
    if (empty($product_name) || empty($item_code) || empty($category_val)) {
        die("<div style='font-family: sans-serif; padding: 2rem; color: #b91c1c;'>
                <h3>Validation Error</h3>
                <p>Please fill in all required fields (Product Name, Item Code, and Category).</p>
                <a href='add-product.php'>&laquo; Go back to Add Product form</a>
             </div>");
    }

    // 3. Category FK Handler
    // Checks if $category_val is an integer ID or a string name
    $category_id = is_numeric($category_val) ? (int)$category_val : null;

    if (!$category_id && !empty($category_val)) {
        // Look up category by name in 'categories' table
        $cat_stmt = $conn->prepare("SELECT id FROM categories WHERE category_name = ?");
        $cat_stmt->bind_param("s", $category_val);
        $cat_stmt->execute();
        $cat_res = $cat_stmt->get_result();

        if ($row = $cat_res->fetch_assoc()) {
            $category_id = $row['id'];
        } else {
            // Automatically insert new category into DB if it doesn't exist yet
            $insert_cat = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
            $insert_cat->bind_param("s", $category_val);
            if ($insert_cat->execute()) {
                $category_id = $insert_cat->insert_id;
            }
            $insert_cat->close();
        }
        $cat_stmt->close();
    }

    // 4. Duplicate SKU / Item Code Check
    $check_stmt = $conn->prepare("SELECT id FROM products WHERE item_code = ?");
    $check_stmt->bind_param("s", $item_code);
    $check_stmt->execute();
    $check_res = $check_stmt->get_result();

    if ($check_res->num_rows > 0) {
        $check_stmt->close();
        die("<div style='font-family: sans-serif; padding: 2rem; color: #b91c1c;'>
                <h3>Duplicate Item Code Error</h3>
                <p>The Item Code <strong>" . htmlspecialchars($item_code) . "</strong> already exists in the inventory.</p>
                <a href='add-product.php'>&laquo; Go back and enter a unique Item Code</a>
             </div>");
    }
    $check_stmt->close();

    // 5. Insert Product into MySQL using Prepared Statements
    $sql = "INSERT INTO products (item_code, product_name, category_id, quantity, unit_price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Data Types: s = string, s = string, i = integer, i = integer, d = double/float
        $stmt->bind_param("ssiid", $item_code, $product_name, $category_id, $quantity, $unit_price);

       
        if ($stmt->execute()) {
           
           
            // Redirect to products.php with success flag
            header("Location: products.php?status=success");
            exit();
        } else {
            echo "Database Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "SQL Error: " . $conn->error;
    }

} else {
    // Direct access redirect to the form
    header("Location: add-product.php");
    exit();
}
?>

