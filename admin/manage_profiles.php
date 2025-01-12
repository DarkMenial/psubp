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
?>

<?php include './admin_utils/admin_header.php'; ?>

<main class="page-wrapper">
    <div class="lg-box">
        <h1 class="dashboard-title">Manage Profiles</h1>

        <!-- Filter and Search -->
        <div class="filter-search">
            <select id="position-filter" onchange="filterProfiles()">
                <option value="">All Designations</option>
                <option value="Faculty">Faculty</option>
                <option value="Staff">Staff</option>
                <!-- Add more position options as needed -->
            </select>
            <input type="text" id="search" placeholder="Search by full name" oninput="filterProfiles()" style="width: 300px; margin-left: 10px;">
        </div>

        <!-- Profiles Table -->
        <table class="profiles-table">
            <thead>
                <tr>
                    <th>Profile ID</th>
                    <th>Full Name</th>
                    <th>Designation</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <td>Mark</td>
                    <td>Faculty</td>
                    <td>mark.ea@example.com</td>
                    <td>+631234567890</td>
                    <td><img src="path_to_photo" alt="Mark's photo" style="width: 50px; height: 50px;"></td>
                    <td>
                        <div class="action-buttons">
                            <button class="edit-button" onclick="editProfile('john_doe')">Edit</button>
                            <button class="archive-button" onclick="archiveProfile('john_doe')">Archive</button>
                            <button class="delete-button" onclick="deleteProfile('john_doe')">Delete</button>
                        </div>
                    </td>
                </tr> -->
                <?php include './php/display_profile_table.php'; ?>
                <!-- Add more rows for each profile -->
            </tbody>
        </table>

        <div class="buttons">
          <a href="create_profile.php" class="create-prpfile-button"><i class="fas fa-plus"></i>Create Profile</a>
        </div>

    </div>
</main>

<style>
    /* Add styles for the filter and search */
    .filter-search {
        margin-top: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .filter-search input, .filter-search select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Add styles for the profiles table */
    .profiles-table {
        width: 100%;
        border-collapse: collapse;
    }

    .profiles-table th, .profiles-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .profiles-table th {
        background-color: #f9f9f9;
    }

    .profiles-table tbody tr:hover {
        background-color: #f5f5f5;
    }

    /* Add styles for action buttons */
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

    /* Style the Add Profile button */
    .add-profile-button {
        padding: 10px 20px;
        background-color: #428bca;
        border: none;
        color: white;
        cursor: pointer;
    }

    .add-profile-button:hover {
        background-color: #357ebd;
    }
</style>

<script>
    function filterProfiles() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const positionFilter = document.getElementById('position-filter').value.toLowerCase();
        const rows = document.querySelectorAll('.profiles-table tbody tr');

        rows.forEach(row => {
            const fullName = row.cells[0].textContent.toLowerCase();
            const position = row.cells[1].textContent.toLowerCase();

            if ((fullName.includes(searchValue)) && (position.includes(positionFilter) || positionFilter === '')) {
                row.style.display = '';
            } else {
                row.style display = 'none';
            }
        });
    }

    function editProfile(username) {
        alert('Editing profile: ' + username);
        // Add functionality to edit the selected profile
    }

    function archiveProfile(username) {
        alert('Archiving profile: ' + username);
        // Add functionality to archive the selected profile
    }

    function deleteProfile(username) {
        alert('Deleting profile: ' + username);
        // Add functionality to delete the selected profile
    }

    function addProfile() {
        alert('Adding a new profile');
        // Add functionality to add a new profile (e.g., show a form for profile creation)
    }
</script>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
