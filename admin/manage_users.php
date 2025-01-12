<?php
require_once './php/db_connect.php';

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // Check if the sidebar state is stored in the session
    if (!isset($_SESSION['sidebarCollapsed'])) {
        // Set the initial state of the sidebar
        $_SESSION['sidebarCollapsed'] = false;
    }

    // Handle the sidebar toggle action
    if (isset($_GET['toggle'])) {
        // Toggle the sidebar state
        $_SESSION['sidebarCollapsed'] = !$_SESSION['sidebarCollapsed'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    include './admin_utils/admin_header.php';
?>

<main class="page-wrapper">
    <div class="lg-box">
        <h1 class="dashboard-title">Manage Users</h1>

        <!-- Filter by account and search -->
        <div class="filter-search">
            <select id="account-filter" onchange="filterUsers()">
                <option value="all">All Accounts</option>
                <option value="PSUBP">PSUBP</option>
                <option value="BSIT">BSIT</option>
                <option value="BSCRIM">BSCRIM</option>
                <!-- Add more account options as needed -->
            </select>
            <input type="text" id="search" placeholder="Search by username or full name" oninput="filterUsers()" style="width: 285px;">
        </div>

        <!-- User Management Table -->
        <table class="archive-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Account</th>
                    <th>Permission</th>
                    <th>Action</th>
                </tr>
            </thead>

            
            <tbody>
            <?php include './php/display_user.php'; ?>
            <!-- <tr>
                    <td>dan</td>
                    <td>Mark Daniel Rodriguez</td>
                    <td>mark.ea@example.com</td>
                    <td>BSIT</td>
                    <td>Admin</td>
                    <td>
                        <div class="action-buttons">
                        <button class="edit-button" onclick="editUser('john_doe')">Edit</button>
                        <button class="archive-button" onclick="archiveUser('john_doe')">Archive</button>
                        <button class="delete-button" onclick="deleteUser('john_doe')">Delete</button>
</div>
                    </td>
                </tr> -->
                <!-- Add more rows for each user -->
            </tbody>
        </table>

        <div class="buttons">
          <a href="create_user.php" class="add-post-button" style = "padding: 10px 20px; width: max-content;"><i class="fas fa-plus"></i>Create User</a>
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

    /* Add styles for the user management table */
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

    .action-buttons .edit-button {
        background-color: #5cb85c;
        border: none;
        color: white;
    }

    .action-buttons .archive-button {
        background-color: #5bc0de;
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
    function editUser(username) {
        alert('Editing user: ' + username);
        // Add functionality to edit the selected user
    }

    function archiveUser(username) {
        alert('Archiving user: ' + username);
        // Add functionality to archive the selected user
    }

    function deleteUser(username) {
        alert('Deleting user: ' + username);
        // Add functionality to delete the selected user
    }

    function filterUsers() {
        const accountFilter = document.getElementById('account-filter').value.toLowerCase();
        const searchValue = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('.archive-table tbody tr');

        rows.forEach(row => {
            const username = row.cells[0].textContent.toLowerCase();
            const fullName = row.cells[1].textContent.toLowerCase();
            const account = row.cells[3].textContent.toLowerCase();

            if ((accountFilter === 'all' || account === accountFilter) &&
                (username.includes(searchValue) || fullName.includes(searchValue))) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
