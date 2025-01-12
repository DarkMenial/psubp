<?php include './admin_utils/admin_header.php'; ?>

<main class="page-wrapper">
    <div class="lg-box">
        <h1 class="dashboard-title">Manage Assets</h1>

        <!-- Filter and Search -->
        <div class="filter-search">
            <select id="asset-type-filter" onchange="filterAssets()">
                <option value="all">All Assets</option>
                <option value="Logo">Logo</option>
                <option value="Banner">Banner</option>
                <option value="Hero">Hero</option>
                <option value="Laws">By Laws</option>
                <option value="Others">Others</option>
            </select>
            <select id="asset-category-filter" onchange="filterAssets()">
                <option value="all">All Categories</option>
                <option value="Photo">Photo</option>
                <option value="Video">Video</option>
                <option value="Music">Music</option>
                <option value="File">File</option>
            </select>
            <select id="account-filter" onchange="filterAssets()">
                <option value="all">All Accounts</option>
                <option value="PSUBP">PSUBP</option>
                <option value="BSIT">BSIT</option>
                <option value="BSCRIM">BSCRIM</option>
                <!-- Add more account options as needed -->
            </select>
            <input type="text" id="search" placeholder="Search by asset type" oninput="filterAssets()">
        </div>

        <!-- Asset Management Table -->
        <table class="asset-management-table">
            <thead>
                <tr>
                    <th>Asset Type</th>
                    <th>Asset Category</th>
                    <th>Account</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include './php/display_assets.php'; ?>
            </tbody>
        </table>
    </div>
</main>

<style>
    .asset-management-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .asset-management-table th,
    .asset-management-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .asset-management-table th {
        background-color: #f9f9f9;
    }

    .change-asset-button,
    .delete-button {
        margin: 0 5px;
        padding: 6px 12px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
    }

    .change-asset-button {
        background-color: #4CAF50;
        color: white;
    }

    .delete-button {
        background-color: #f44336;
        color: white;
    }

    .filter-search {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
    }

    .filter-search select,
    .filter-search input {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        flex: 1;
    }
</style>

<script>
    function filterAssets() {
        const typeFilter = document.getElementById('asset-type-filter').value.toLowerCase();
        const categoryFilter = document.getElementById('asset-category-filter').value.toLowerCase();
        const accountFilter = document.getElementById('account-filter').value.toLowerCase();
        const searchFilter = document.getElementById('search').value.toLowerCase();

        const table = document.querySelector('.asset-management-table tbody');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const typeCell = rows[i].getElementsByTagName('td')[0];
            const categoryCell = rows[i].getElementsByTagName('td')[1];
            const accountCell = rows[i].getElementsByTagName('td')[2];

            if (typeCell && categoryCell && accountCell) {
                const typeText = typeCell.textContent.toLowerCase();
                const categoryText = categoryCell.textContent.toLowerCase();
                const accountText = accountCell.textContent.toLowerCase();

                const typeMatch = typeFilter === 'all' || typeText.includes(typeFilter);
                const categoryMatch = categoryFilter === 'all' || categoryText.includes(categoryFilter);
                const accountMatch = accountFilter === 'all' || accountText.includes(accountFilter);
                const searchMatch = searchFilter === '' || typeText.includes(searchFilter);

                if (typeMatch && categoryMatch && accountMatch && searchMatch) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>
