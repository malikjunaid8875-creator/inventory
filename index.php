<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory Management System</title>
    
    <!-- Custom CSS File -->
    <link rel="stylesheet" href="assets/custom-style.css">
    
    <!-- FontAwesome for Dashboard Icons (via CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Header Navigation Bar -->
    <header class="navbar">
        <div class="nav-brand">
            <h2><i class="fa-solid fa-boxes-stacked"></i> StockMaster</h2>
        </div>
        <nav class="nav-links">
            <a href="index.php" class="active"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="products.php"><i class="fa-solid fa-box"></i> Products</a>
            <a href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a>
            <a href="suppliers.php"><i class="fa-solid fa-truck"></i> Suppliers</a>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="main-container">

        <!-- Page Header & Action Bar -->
        <div class="page-header">
            <div>
                <h1>Dashboard Overview</h1>
                <p>Welcome back! Here is a summary of your inventory state.</p>
            </div>
            <div class="action-buttons">
                <a href="add-product.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New Product</a>
            </div>
        </div>

        <!-- Metric Summary Cards Section -->
        <section class="metrics-grid">
            <div class="card metric-card">
                <div class="card-icon blue"><i class="fa-solid fa-boxes-stacked"></i></div>
                <div class="card-info">
                    <h3>Total Items</h3>
                    <p class="metric-number">124</p>
                </div>
            </div>

            <div class="card metric-card">
                <div class="card-icon red"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="card-info">
                    <h3>Low Stock Alert</h3>
                    <p class="metric-number">5</p>
                </div>
            </div>

            <div class="card metric-card">
                <div class="card-icon green"><i class="fa-solid fa-tags"></i></div>
                <div class="card-info">
                    <h3>Total Categories</h3>
                    <p class="metric-number">8</p>
                </div>
            </div>

            <div class="card metric-card">
                <div class="card-icon yellow"><i class="fa-solid fa-sack-dollar"></i></div>
                <div class="card-info">
                    <h3>Total Valuation</h3>
                    <p class="metric-number">$12,450.00</p>
                </div>
            </div>
        </section>

        <!-- Dashboard Data Table Section -->
        <section class="dashboard-grid">
            <div class="card table-card">
                <div class="card-header">
                    <h2><i class="fa-solid fa-clock-rotate-left"></i> Recent Inventory Activity</h2>
                    <a href="products.php" class="view-all-link">View All Products</a>
                </div>
                
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
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Placeholder Data (We will replace this with MySQL queries later) -->
                            <tr>
                                <td>#PRD-001</td>
                                <td>Wireless Optical Mouse</td>
                                <td>Electronics</td>
                                <td>45</td>
                                <td>$25.00</td>
                                <td><span class="badge badge-success">In Stock</span></td>
                            </tr>
                            <tr>
                                <td>#PRD-002</td>
                                <td>Mechanical Keyboard</td>
                                <td>Electronics</td>
                                <td>3</td>
                                <td>$85.00</td>
                                <td><span class="badge badge-warning">Low Stock</span></td>
                            </tr>
                            <tr>
                                <td>#PRD-003</td>
                                <td>USB-C Fast Cable (2m)</td>
                                <td>Accessories</td>
                                <td>0</td>
                                <td>$12.00</td>
                                <td><span class="badge badge-danger">Out of Stock</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

