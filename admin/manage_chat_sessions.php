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
        <h1 class="dashboard-title">Chat Inquiries</h1>

        <!-- Filter and Search -->
        <div class="filter-search">
            <select id="account-filter" class="filter">
                <option value="">All Accounts</option>
                <option value="PSUBP">PSUBP</option>
                <option value="BSIT">BSIT</option>
                <!-- Add more account options as needed -->
            </select>
            <input type="date" id="date-filter" class="filter">
            <input type="text" id="search" placeholder="Search by chat" class="filter">
        </div>

        <!-- chat session Table -->
        <div class="chat-session">
            <table id="chat-table" class="chat-table">
                <thead>
                    <tr>
                        <th>Chat ID</th>
                        <th>Subject</th>
                        <th>Department</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last Activity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php include './php/display_chat_sessions.php'; ?>
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

    /* Add styles for the chat session table */
    .chat-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .chat-table th,
    .chat-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .chat-table th {
        background-color: #f9f9f9;
    }

    .chat-table tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

<script>
    const accountFilter = document.getElementById('account-filter');
    const dateFilter = document.getElementById('date-filter');
    const searchInput = document.getElementById('search');
    const chatRows = document.querySelectorAll('#chat-table tbody tr');

    // Event listeners
    accountFilter.addEventListener('change', filterchat);
    dateFilter.addEventListener('change', filterchat);
    searchInput.addEventListener('input', filterchat);

    function filterchat() {
        const accountFilterValue = accountFilter.value.toLowerCase();
        const dateFilterValue = dateFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        chatRows.forEach(row => {
            const account = row.cells[3].textContent.toLowerCase();
            const date = row.cells[0].textContent;
            const chat = row.cells[1].textContent.toLowerCase();

            const accountMatch = account.includes(accountFilterValue) || accountFilterValue === '';
            const dateMatch = date.includes(dateFilterValue) || dateFilterValue === '';
            const searchMatch = chat.includes(searchValue) || searchValue === '';

            if (accountMatch && dateMatch && searchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<?php include './admin_utils/admin_footer.php'; ?>
