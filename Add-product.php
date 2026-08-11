<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Inventory Management System</title>
    
    <!-- Custom CSS File -->
    <link rel="stylesheet" href="assets/custom-style.css">
    
    <!-- FontAwesome for Icons (via CDN) -->
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
            <a href="categories.php"><i class="fa-solid fa-tags"></i> Categories</a>
            <a href="suppliers.php"><i class="fa-solid fa-truck"></i> Suppliers</a>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="main-container">

        <!-- Page Header & Action Bar -->
        <div class="page-header">
            <div>
                <h1>Add New Product</h1>
                <p>Register a new stock item into your inventory system.</p>
            </div>
            <div class="action-buttons">
                <a href="products.php" class="btn" style="background: #e2e8f0; color: var(--text-primary);">
                    <i class="fa-solid fa-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>

        <!-- Form Card Container -->
        <section class="card" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
            
            <!-- Form points to process-add.php via POST method -->
            <form action="process-add.php" method="POST">
                
                <!-- Row 1: Product Name & Item Code -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="product_name" style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Product Name <span style="color: var(--icon-red);">*</span></label>
                        <input 
                            type="text" 
                            id="product_name" 
                            name="product_name" 
                            required 
                            placeholder="e.g. Wireless Ergonomic Mouse" 
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;"
                        >
                    </div>
                    <div>
                        <label for="item_code" style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Item Code / SKU <span style="color: var(--icon-red);">*</span></label>
                        <input 
                            type="text" 
                            id="item_code" 
                            name="item_code" 
                            required 
                            placeholder="e.g. #PRD-004" 
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;"
                        >
                    </div>
                </div>

                <!-- Row 2: Category & Quantity -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="category" style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Category <span style="color: var(--icon-red);">*</span></label>
                        <select 
                            id="category" 
                            name="category" 
                            required 
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none; background: #fff;"
                        >
                            <option value="" disabled selected>Select category...</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Hardware">Hardware</option>
                        </select>
                    </div>
                    <div>
                        <label for="quantity" style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Initial Quantity <span style="color: var(--icon-red);">*</span></label>
                        <input 
                            type="number" 
                            id="quantity" 
                            name="quantity" 
                            min="0" 
                            required 
                            placeholder="e.g. 50" 
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;"
                        >
                    </div>
                </div>

                <!-- Row 3: Unit Price -->
                <div style="margin-bottom: 2rem;">
                    <label for="unit_price" style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Unit Price ($) <span style="color: var(--icon-red);">*</span></label>
                    <input 
                        type="number" 
                        step="0.01" 
                        id="unit_price" 
                        name="unit_price" 
                        min="0" 
                        required 
                        placeholder="e.g. 29.99" 
                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;"
                    >
                </div>

                <!-- Form Submit Action Buttons -->
                <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                    <a href="products.php" class="btn" style="background: #e2e8f0; color: var(--text-primary);">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Save Product
                    </button>
                </div>

            </form>
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

