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
        <h1 class="dashboard-title">Activity Logs</h1>

        <!-- Filter and Search -->
        <div class="filter-search">
            <select id="account-filter" class="filter">
                <option value="">All Accounts</option>
                <option value="PSUBP">PSUBP</option>
                <option value="BSIT">BSIT</option>
                <!-- Add more account options as needed -->
            </select>
            <input type="date" id="date-filter" class="filter">
            <input type="text" id="search" placeholder="Search by activity" class="filter">
        </div>

        <!-- Activity Logs Table -->
        <div class="activity-logs">
            <table id="activity-table" class="activity-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Activity</th>
                        <th>User</th>
                        <th>Account</th>
                        <!-- <th>Permission</th> -->
                        <!-- <th>Full Name</th> -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample data -->
                    <!-- <tr>
                        <td>2023-09-29 10:30:00</td>
                        <td>User login</td>
                        <td>mark</td>
                        <td>PSUBP</td>
                        <td>Admin</td>
                        <td>Mark Daniel Rodriguez</td>
                    </tr>
                    <tr>
                        <td>2023-10-01 1:20:00</td>
                        <td>User Created</td>
                        <td>mark</td>
                        <td>PSUBP</td>
                        <td>Admin</td>
                        <td>Mark Daniel Rodriguez</td>
                    </tr>
                    <tr>
                        <td>2023-10-01 1:20:00</td>
                        <td>User Login</td>
                        <td>dan</td>
                        <td>BSIT</td>
                        <td>manage_post</td>
                        <td>Daniel Rodriguez</td>
                    </tr> -->
                <?php include './php/display_activity_logs_table.php'; ?>
                    <!-- Add more rows for each log -->
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

    .filter-search select,
    .filter-search input {
        margin-right: 10px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Add styles for the activity logs table */
    .activity-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .activity-table th,
    .activity-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .activity-table th {
        background-color: #f9f9f9;
    }

    .activity-table tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

<script>
    const accountFilter = document.getElementById('account-filter');
    const dateFilter = document.getElementById('date-filter');
    const searchInput = document.getElementById('search');
    const activityRows = document.querySelectorAll('#activity-table tbody tr');

    // Event listeners
    accountFilter.addEventListener('change', filterActivity);
    dateFilter.addEventListener('change', filterActivity);
    searchInput.addEventListener('input', filterActivity);

    function filterActivity() {
        const accountFilterValue = accountFilter.value.toLowerCase();
        const dateFilterValue = dateFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        activityRows.forEach(row => {
            const account = row.cells[3].textContent.toLowerCase();
            const date = row.cells[0].textContent;
            const activity = row.cells[1].textContent.toLowerCase();

            const accountMatch = account.includes(accountFilterValue) || accountFilterValue === '';
            const dateMatch = date.includes(dateFilterValue) || dateFilterValue === '';
            const searchMatch = activity.includes(searchValue) || searchValue === '';

            if (accountMatch && dateMatch && searchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<?php include './admin_utils/admin_footer.php'; ?>
