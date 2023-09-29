<?php
require_once './php/db_connect.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include './admin_utils/admin_header.php';

    // Retrieve the user ID from the URL parameter
    $id = $_GET['id'];

    // Fetch the user data from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
?>

<main class="page-wrapper">
    <div class="sm-box">
        <h2 style="text-align: center;">Edit User</h2>
        <form method="POST" action="./php/update_user.php">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required style="width: 100%; padding: 5px;">
            </div>
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required style="width: 100%; padding: 5px;">
            </div>
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required style="width: 100%; padding: 5px;">
            </div>
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="accounts">Accounts:</label>
                <div id="accounts-container">
                    <?php
                    // Retrieve selected accounts
                    $selectedAccounts = explode(',', $user['accounts']);

                    // Fetch accounts from the database
                    $query = "SELECT * FROM accounts";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Error retrieving accounts: " . mysqli_error($conn));
                    }

                    // Display selected accounts
                    foreach ($selectedAccounts as $accountId) {
                        $query = "SELECT * FROM accounts WHERE account_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('i', $accountId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $account = $result->fetch_assoc();
                        $stmt->close();

                        echo '<div class="account-item">';
                        echo '<input type="hidden" name="accounts[]" value="' . $accountId . '">';
                        echo '<span>' . $account['account_name'] . '</span>';
                        echo '<button type="button" class="remove-account" onclick="removeAccount(this)"><i class="fas fa-times"></i></button>';
                        echo '</div>';
                    }

                    mysqli_free_result($result);
                    ?>
                </div>
                <select id="account-selector">
                    <option value="">Select Account</option> <!-- Add an empty option-->
                    <?php
                    // Fetch accounts from the database
                    $query = "SELECT * FROM accounts";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Error retrieving accounts: " . mysqli_error($conn));
                    }

                    // Display account options
                    while ($account = mysqli_fetch_assoc($result)) {
                        if (in_array($account['account_id'], $selectedAccounts)) {
                            continue; // Skip already selected accounts
                        }

                        echo '<option value="' . $account['account_id'] . '">' . $account['account_name'] . '</option>';
                    }

                    mysqli_free_result($result);
                    ?>
                </select>
                <button type="button" class="add-account" onclick="addAccount()">Add Account</button>
            </div>
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="permissions">Permissions:</label>
                <div id="permissions-container">
                    <?php
                    // Retrieve selected permissions
                    $selectedPermissions = explode(',', $user['permissions']);

                    // Fetch permissions from the database
                    $query = "SELECT * FROM permissions";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Error retrieving permissions: " . mysqli_error($conn));
                    }

                    // Display selected permissions
                    foreach ($selectedPermissions as $permissionId) {
                        $query = "SELECT * FROM permissions WHERE permission_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('i', $permissionId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $permission = $result->fetch_assoc();
                        $stmt->close();

                        echo '<div class="permission-item">';
                        echo '<input type="hidden" name="permissions[]" value="' . $permissionId . '">';
                        echo '<span>' . $permission['name'] . '</span>';
                        echo '<button type="button" class="remove-permission" onclick="removePermission(this)"><i class="fas fa-times"></i></button>';
                        echo '</div>';
                    }

                    mysqli_free_result($result);
                    ?>
                </div>
                <select id="permission-selector">
                    <option value="">Select Permission</option> <!-- Add an empty option -->
                    <?php
                    // Fetch permissions from the database
                    $query = "SELECT * FROM permissions";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Error retrieving permissions: " . mysqli_error($conn));
                    }

                    // Display permission options
                    while ($permission = mysqli_fetch_assoc($result)) {
                        if (in_array($permission['permission_id'], $selectedPermissions)) {
                            continue; // Skip already selected permissions
                        }

                        echo '<option value="' . $permission['permission_id'] . '">' . $permission['name'] . '</option>';
                    }

                    mysqli_free_result($result);
                    ?>
                </select>
                <button type="button" class="add-permission" onclick="addPermission()">Add Permission</button>
            </div>
            <div style="text-align: center;">
                <button type="submit" style="padding: 8px 16px;">Update User</button>
            </div>
        </form>
    </div>
</main>

<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
<script>
    const accountSelector = document.getElementById('account-selector');
    const accountsContainer = document.getElementById('accounts-container');
    const permissionSelector = document.getElementById('permission-selector');
    const permissionsContainer = document.getElementById('permissions-container');

function addAccount() {
    const accountValue = accountSelector.value;
    const accountText = accountSelector.options[accountSelector.selectedIndex].text;

    if (accountValue !== '') {
        const accountItem = document.createElement('div');
        accountItem.classList.add('account-item');
        accountItem.innerHTML = `
            <input type="hidden" name="accounts[]" value="${accountValue}">
            <span>${accountText}</span>
            <button type="button" class="remove-account" onclick="removeAccount(this)"><i class="fas fa-times"></i></button>
        `;
        accountsContainer.appendChild(accountItem);
        accountSelector.value = '';
    }
}

function removeAccount(button) {
    const accountItem = button.parentNode;
    accountsContainer.removeChild(accountItem);
}

function addPermission() {
    const permissionValue = permissionSelector.value;
    const permissionText = permissionSelector.options[permissionSelector.selectedIndex].text;

    if (permissionValue !== '') {
        const permissionItem = document.createElement('div');
        permissionItem.classList.add('permission-item');
        permissionItem.innerHTML = `
            <input type="hidden" name="permissions[]" value="${permissionValue}">
            <span>${permissionText}</span>
            <button type="button" class="remove-permission" onclick="removePermission(this)"><i class="fas fa-times"></i></button>
        `;
        permissionsContainer.appendChild(permissionItem);
        permissionSelector.value = '';
    }
}

function removePermission(button) {
    const permissionItem = button.parentNode;
    permissionsContainer.removeChild(permissionItem);
}
</script>

<?php
include './admin_utils/admin_footer.php';
} else {
header("Location: login.php");
exit();
}
?>