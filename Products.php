<?php
// products.php - Product Listing Page

// 1. Include the Database Connection
require_once 'config/db.php';

// 2. Fetch all products joined with category names (Newest products first)
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Inventory Management System</title>
    
    <!-- Custom CSS File -->
    <link rel="stylesheet" href="assets/custom-style.css">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Header Navigation Bar -->
    <header class="navbar">
        <div class="nav-brand">
            <h2><i class="fa-solid fa-boxes-stacked"></i> StockMaster</h2>
        </div>
        <nav class="nav-links">
            <a href="index.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="products.php" class="active"><i class="fa-solid fa-box"></i> Products</a>
            <a href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a>
            <a href="suppliers.php"><i class="fa-solid fa-truck"></i> Suppliers</a>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="main-container">

        <!-- Dynamic Status Notification Banners -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
                <div class="card alert-dismissible" style="background-color: var(--success-bg); color: var(--success-text); border: 1px solid #bbf7d0; padding: 1rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; border-radius: var(--radius-sm);">
                    <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong>Success!</strong> Product was added to the inventory database successfully.
                    </div>
                </div>
            <?php elseif ($_GET['status'] === 'deleted'): ?>
                <div class="card alert-dismissible" style="background-color: var(--danger-bg); color: var(--danger-text); border: 1px solid #fca5a5; padding: 1rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; border-radius: var(--radius-sm);">
                    <i class="fa-solid fa-trash-can" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong>Product Deleted!</strong> The item has been permanently removed from inventory.
                    </div>
                </div>
            <?php elseif ($_GET['status'] === 'notfound'): ?>
                <div class="card alert-dismissible" style="background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 1rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; border-radius: var(--radius-sm);">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong>Not Found!</strong> The requested product could not be located in the database.
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Page Header & Action Bar -->
        <div class="page-header">
            <div>
                <h1>Product Inventory</h1>
                <p>Manage, search, and monitor all real stock items from your database.</p>
            </div>
            <div class="action-buttons">
                <a href="add-product.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New Product</a>
            </div>
        </div>

        <!-- Search Bar & Dynamic Counter -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div style="display: flex; gap: 1rem; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px; max-width: 400px;">
                    <!-- Live Search Input (Handled by assets/my-scripts.js) -->
                    <input 
                        type="text" 
                        id="table-search" 
                        placeholder="Search products by name, code, or category..." 
                        style="width: 100%; padding: 0.6rem 1rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;"
                    >
                </div>
                <div>
                    <span style="color: var(--text-secondary); font-size: 0.9rem;">
                        Total Products: <strong><?php echo $result ? $result->num_rows : 0; ?></strong>
                    </span>
                </div>
            </div>
        </div>

        <!-- Dynamic Product Data Table -->
        <section class="card table-card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                    // Dynamic stock badge logic
                                    $qty = (int) $row['quantity'];
                                    if ($qty === 0) {
                                        $badge_class = "badge-danger";
                                        $status_text = "Out of Stock";
                                    } elseif ($qty <= 5) {
                                        $badge_class = "badge-warning";
                                        $status_text = "Low Stock";
                                    } else {
                                        $badge_class = "badge-success";
                                        $status_text = "In Stock";
                                    }

                                    // Fallback for null categories
                                    $category_display = !empty($row['category_name']) ? $row['category_name'] : 'Uncategorized';
                                ?>
                                <tr>
                                    <td><code><?php echo htmlspecialchars($row['item_code']); ?></code></td>
                                    <td><strong><?php echo htmlspecialchars($row['product_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($category_display); ?></td>
                                    <td><?php echo $qty; ?> pcs</td>
                                    <td>$<?php echo number_format($row['unit_price'], 2); ?></td>
                                    <td><span class="badge <?php echo $badge_class; ?>"><?php echo $status_text; ?></span></td>
                                    <td style="text-align: right;">
                                        <!-- Edit Link -->
                                        <a href="edit-product.php?id=<?php echo $row['id']; ?>" class="btn" style="padding: 0.3rem 0.6rem; font-size: 0.8rem; background: #e2e8f0; color: var(--text-primary);">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        
                                        <!-- Delete Link with JavaScript Confirmation -->
                                        <a href="delete-product.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-delete" 
                                           onclick="return confirm('Are you sure you want to delete \'<?php echo htmlspecialchars(addslashes($row['product_name'])); ?>\'?');" 
                                           style="padding: 0.3rem 0.6rem; font-size: 0.8rem; background: var(--danger-bg); color: var(--danger-text);">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <!-- Empty State Row when zero products exist in DB -->
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2.5rem; color: var(--text-secondary);">
                                    <i class="fa-solid fa-box-open" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; color: var(--border-color);"></i>
                                    No products found in the database.<br>
                                    <a href="add-product.php" style="color: var(--primary-color); font-weight: 600; margin-top: 0.5rem; display: inline-block;">
                                        + Add your first product
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> StockMaster - Inventory System. Built for learning.</p>
    </footer>

    <!-- Custom JavaScript File -->
    <script src="assets/my-scripts.js"></script>
</body>
</html>


