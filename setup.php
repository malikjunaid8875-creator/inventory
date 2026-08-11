<?php
// setup.php
require_once 'config/db.php';

// Array of SQL queries to create tables
$tables = [
    // 1. Categories Table
    "categories" => "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",

    // 2. Suppliers Table
    "suppliers" => "CREATE TABLE IF NOT EXISTS suppliers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        supplier_name VARCHAR(150) NOT NULL,
        contact_name VARCHAR(100) DEFAULT NULL,
        email VARCHAR(100) DEFAULT NULL,
        phone VARCHAR(20) DEFAULT NULL,
        address TEXT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",

    // 3. Customers Table
    "customers" => "CREATE TABLE IF NOT EXISTS customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(150) NOT NULL,
        email VARCHAR(100) DEFAULT NULL,
        phone VARCHAR(20) DEFAULT NULL,
        address TEXT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;",

    // 4. Products Table (Linked to Categories & Suppliers)
    "products" => "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        item_code VARCHAR(100) NOT NULL UNIQUE,
        product_name VARCHAR(255) NOT NULL,
        category_id INT DEFAULT NULL,
        supplier_id INT DEFAULT NULL,
        quantity INT NOT NULL DEFAULT 0,
        unit_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE,
        FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB;"
];

$results = [];

// Execute each table creation query
foreach ($tables as $tableName => $sql) {
    if ($conn->query($sql) === TRUE) {
        $results[] = [
            'status' => 'success',
            'message' => "Table <strong>'$tableName'</strong> created successfully (or already exists)."
        ];
    } else {
        $results[] = [
            'status' => 'error',
            'message' => "Error creating table '$tableName': " . $conn->error
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - Inventory System</title>
    <link rel="stylesheet" href="assets/custom-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <main class="main-container" style="max-width: 650px; margin-top: 4rem;">
        <div class="card">
            <h2 style="margin-bottom: 1rem;"><i class="fa-solid fa-database"></i> Database Table Setup</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                Target Database: <code><?php echo $dbname; ?></code>
            </p>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach ($results as $res): ?>
                    <div style="padding: 0.8rem 1rem; border-radius: var(--radius-sm); background-color: <?php echo $res['status'] === 'success' ? 'var(--success-bg)' : 'var(--danger-bg)'; ?>; color: <?php echo $res['status'] === 'success' ? 'var(--success-text)' : 'var(--danger-text)'; ?>;">
                        <i class="fa-solid <?php echo $res['status'] === 'success' ? 'fa-check-circle' : 'fa-triangle-exclamation'; ?>"></i>
                        <?php echo $res['message']; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                <a href="index.php" class="btn btn-primary">
                    <i class="fa-solid fa-house"></i> Go to Dashboard
                </a>
            </div>
        </div>
    </main>
</body>
</html>
