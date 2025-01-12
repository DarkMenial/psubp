<?php
include './php/check_login.php';
include './admin_utils/admin_header.php';

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Function to check if user has a specific permission
function hasPermission($userID, $permissionName) {
    global $conn;

    $sql = "SELECT p.name AS permission_name 
            FROM users u
            JOIN user_permissions up ON u.id = up.user_id
            JOIN permissions p ON up.permission_id = p.id
            WHERE u.id = '$userID'";

    $result = mysqli_query($conn, $sql);

    $userPermissions = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userPermissions[] = $row['permission_name'];
        }
    }

    return in_array($permissionName, $userPermissions);
}

// Check if user has admin rights
$hasPermission = hasPermission($loggedInUserID, 'admin');

// Redirect if the user does not have admin rights
if (!$hasPermission) {
    echo '<script>window.location.href = "dashboard.php";</script>';
    exit();
}
?>

<main class="page-wrapper">
    <div class="lg-box">
        <h1 class="dashboard-title">Archive</h1>

        <!-- Filter and Search -->
        <div class="filter-search">
            <select id="archive-filter" class="filter">
                <option value="">All Archives</option>
                <option value="user">User</option>
                <option value="profile">Profile</option>
                <option value="post">Post</option>
                <!-- Add more archive options as needed -->
            </select>
            <select id="account-filter" class="filter">
                <option value="">All Accounts</option>
                <option value="PSUBP">PSUBP</option>
                <option value="BSIT">BSIT</option>
                <!-- Add more account options as needed -->
            </select>
            <input type="date" id="date-filter" class="filter">
            <input type="text" id="search" placeholder="Search by item">
        </div>

        <!-- Archive Table -->
        <div class="archive-logs">
            <table class="archive-table">
                <thead>
                    <tr>
                        <th>Date Archived</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Account</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample data -->

                    <!-- <tr>
                        <td>2023-09-29 10:30:00</td>
                        <td>Post</td>
                        <td>Sample Post</td>
                        <td>PSUBP</td>
                        <td>
                            <div class="action-buttons">
                                <button class="unarchive-button">Unarchive</button>
                                <button class="delete-button">Delete</button>
                            </div>
                        </td>
                    </tr> -->

                    <?php include './php/display_archive.php'; ?>

                    <!-- Add more rows for each archive -->
                </tbody>
            </table>
        </div>
    </div>
</main>

<style>
    /* Add styles for the filter and search */
    .filter-search {
        margin-top: 10px;
        display: flex;
        align-items: center;
    }

    .filter-search select, .filter-search input {
        margin-right: 10px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }


    /* Add styles for the archive table */
    .archive-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .archive-table th, .archive-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .archive-table th {
        background-color: #f9f9f9;
    }

    .archive-table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
    }

    .action-buttons button {
        padding: 6px 12px;
        margin: 0 5px;
        cursor: pointer;
    }

    .action-buttons .unarchive-button {
        background-color: #5cb85c;
        border: none;
        color: white;
    }

    .action-buttons .delete-button {
        background-color: #d9534f;
        border: none;
        color: white;
    }
</style>

<script>
    const archiveFilter = document.getElementById('archive-filter');
    const dateFilter = document.getElementById('date-filter');
    const accountFilter = document.getElementById('account-filter');
    const searchInput = document.getElementById('search');
    const archiveRows = document.querySelectorAll('.archive-table tbody tr');

    // Event listener for archive filter
    archiveFilter.addEventListener('change', () => filterArchive());

    // Event listener for date filter
    dateFilter.addEventListener('change', () => filterArchive());

    // Event listener for account filter
    accountFilter.addEventListener('change', () => filterArchive());

    // Event listener for search input
    searchInput.addEventListener('input', () => filterArchive());

    function filterArchive() {
        const archiveFilterValue = archiveFilter.value.toLowerCase();
        const dateFilterValue = dateFilter.value;
        const accountFilterValue = accountFilter.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        archiveRows.forEach(row => {
            const type = row.cells[1].textContent.toLowerCase();
            const item = row.cells[2].textContent.toLowerCase();
            const account = row.cells[3].textContent.toLowerCase();

            const archiveMatch = type.includes(archiveFilterValue) || archiveFilterValue === '';
            const dateMatch = row.cells[0].textContent.includes(dateFilterValue) || dateFilterValue === '';
            const accountMatch = account.includes(accountFilterValue) || accountFilterValue === '';
            const searchMatch = item.includes(searchValue) || searchValue === '';

            if (archiveMatch && dateMatch && accountMatch && searchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>




<?php include './admin_utils/admin_footer.php'; ?>


