/**
 * StockMaster - Inventory Management System
 * Main JavaScript File (assets/my-scripts.js)
 */

// Wait for the DOM (HTML structure) to fully load before running scripts
document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Highlight current active menu link
    setActiveNavLink();

    // 2. Initialize delete action confirmation popups
    initDeleteConfirmations();

    // 3. Initialize live search filter for data tables
    initTableSearch();

    // 4. Auto-dismiss flash notification banners
    initAlertDismissal();

    console.log('StockMaster JavaScript initialized successfully.');
});

/**
 * Automatically sets the 'active' CSS class on the navbar link 
 * corresponding to the current page.
 */
function setActiveNavLink() {
    // Get current filename from URL (e.g., "index.php" or "products.php")
    const currentPath = window.location.pathname.split('/').pop() || 'index.php';
    const navLinks = document.querySelectorAll('.nav-links a');

    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref === currentPath) {
            link.classList.add('active');
        }
    });
}

/**
 * Attaches a JavaScript confirmation prompt to any link/button with class ".btn-delete"
 * Prevents accidental deletion of database records.
 */
function initDeleteConfirmations() {
    // Use Event Delegation to catch clicks on delete buttons
    document.addEventListener('click', (event) => {
        const deleteButton = event.target.closest('.btn-delete');
        
        if (deleteButton) {
            const itemName = deleteButton.getAttribute('data-name') || 'this item';
            const confirmed = confirm(`Are you sure you want to delete "${itemName}"?\nThis action cannot be undone.`);
            
            // If user clicks "Cancel", stop the link navigation / form submit
            if (!confirmed) {
                event.preventDefault();
            }
        }
    });
}

/**
 * Enables real-time searching/filtering on tables.
 * Looks for an input field with id="table-search".
 */
function initTableSearch() {
    const searchInput = document.getElementById('table-search');
    if (!searchInput) return;

    searchInput.addEventListener('keyup', () => {
        const query = searchInput.value.toLowerCase().trim();
        const tableRows = document.querySelectorAll('.data-table tbody tr');

        tableRows.forEach(row => {
            // Get all text content within the table row
            const rowText = row.textContent.toLowerCase();
            
            // Show or hide row based on search match
            if (rowText.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

/**
 * Automatically hides notification/alert banners (class ".alert-dismissible")
 * after 4 seconds with a smooth fade-out.
 */
function initAlertDismissal() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500); // Remove element from DOM after fade
        }, 4000);
    });
}

