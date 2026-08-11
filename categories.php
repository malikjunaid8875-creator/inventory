<?php
// categories.php - Categories Management Page

require_once 'config/db.php';

$message = '';
$message_type = '';

// ==========================================================================
// 1. FORM PROCESSING: Add New Category (Inline Processing)
// ==========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name'] ?? '');
    $description   = trim($_POST['description'] ?? '');

    if (empty($category_name)) {
        $message = "Category name is required.";
        $message_type = "danger";
    } else {
        // Check for duplicate category name
        $check_stmt = $conn->prepare("SELECT id FROM categories WHERE category_name = ?");
        $check_stmt->bind_param("s", $category_name);
        $check_stmt->execute();
        $check_res = $check_stmt->get_result();

        if ($check_res->num_rows > 0) {
            $message = "Category '<strong>" . htmlspecialchars($category_name) . "</strong>' already exists.";
            $message_type = "danger";
        } else {
            // Insert new category
            $stmt = $conn->prepare("INSERT INTO categories (category_name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $category_name, $description);

            if ($stmt->execute()) {
                // Redirect to avoid form resubmission on page refresh
                header("Location: categories.php?status=success");
                exit();
            } else {
                $message = "Database insert error: " . $conn->error;
                $message_type = "danger";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}

// Check GET redirect status
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $message = "Category added successfully!";
    $message_type = "success";
}

// ==========================================================================
// 2. FETCH DATA: Get Categories with Product Counts
// ==========================================================================
$sql = "SELECT c.*, COUNT(p.id) AS total_products 
        FROM categories c 
        LEFT JOIN products p ON c.id = p.category_id 
        GROUP BY c.id 
        ORDER BY c.id DESC";

$categories_result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Inventory Management System</title>
    
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
            <a href="products.php"><i class="fa-solid fa-box"></i> Products</a>
            <a href="categories.php" class="active"><i class="fa-solid fa-tags"></i> Categories</a>
            <a href="suppliers.php"><i class="fa-solid fa-truck"></i> Suppliers</a>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="main-container">

        <!-- Notification Banner -->
        <?php if (!empty($message)): ?>
            <div class="card alert-dismissible" style="background-color: <?php echo $message_type === 'success' ? 'var(--success-bg)' : 'var(--danger-bg)'; ?>; color: <?php echo $message_type === 'success' ? 'var(--success-text)' : 'var(--danger-text)'; ?>; border: 1px solid var(--border-color); padding: 1rem; margin-bottom: 1.5rem; border-radius: var(--radius-sm);">
                <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1>Product Categories</h1>
                <p>Organize your products into logical category groups.</p>
            </div>
        </div>

        <!-- Two-Column Grid: Form (Left) & Table (Right) -->
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; align-items: start;">
            
            <!-- Column 1: Add Category Form Card -->
            <section class="card">
                <h2 style="font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    <i class="fa-solid fa-folder-plus"></i> Add New Category
                </h2>

                <form action="categories.php" method="POST">
                    <input type="hidden" name="add_category" value="1">

                    <div style="margin-bottom: 1.25rem;">
                        <label for="category_name" style="display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem;">
                            Category Name <span style="color: var(--icon-red);">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="category_name" 
                            name="category_name" 
                            required 
                            placeholder="e.g. PC Accessories" 
                            style="width: 100%; padding: 0.65rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;"
                        >
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="description" style="display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem;">
                            Description (Optional)
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="3" 
                            placeholder="Brief details about items in this category..." 
                            style="width: 100%; padding: 0.65rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none; font-family: inherit; resize: vertical;"
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-floppy-disk"></i> Save Category
                    </button>
                </form>
            </section>

            <!-- Column 2: Categories List Table Card -->
            <section class="card table-card">
                <div class="card-header">
                    <h2><i class="fa-solid fa-list"></i> Existing Categories</h2>
                    <span style="color: var(--text-secondary); font-size: 0.85rem;">
                        Total: <strong><?php echo $categories_result ? $categories_result->num_rows : 0; ?></strong>
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th># ID</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Total Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($categories_result && $categories_result->num_rows > 0): ?>
                                <?php while ($cat = $categories_result->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $cat['id']; ?></td>
                                        <td><strong><?php echo htmlspecialchars($cat['category_name']); ?></strong></td>
                                        <td style="color: var(--text-secondary); font-size: 0.88rem;">
                                            <?php 
                                                echo !empty($cat['description']) 
                                                    ? htmlspecialchars($cat['description']) 
                                                    : '<em style="color:#a0aec0;">No description</em>'; 
                                            ?>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #e2e8f0; color: var(--text-primary);">
                                                <i class="fa-solid fa-box"></i> <?php echo $cat['total_products']; ?> products
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                                        No categories found. Use the form on the left to create your first category!
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> StockMaster - Inventory System. Built for learning.</p>
    </footer>

    <!-- Custom JavaScript File -->
    <script src="assets/my-scripts.js"></script>
</body>
</html>

