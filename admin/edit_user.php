<?php
include './php/check_login.php';
include './admin_utils/admin_header.php';

// Function to check if user has a specific permission
function hasPermission($userID, $permissionName) {
    global $conn;

    $sql = "SELECT p.name AS permission_name 
            FROM user_permissions up
            JOIN permissions p ON up.permission_id = p.id
            WHERE up.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $userPermissions = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userPermissions[] = $row['permission_name'];
        }
    }

    $stmt->close();
    return in_array($permissionName, $userPermissions);
}

// Function to retrieve user details
function getUserDetails($userID) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    return $user;
}

// Function to retrieve user's associated accounts
function getUserAccounts($userID) {
    global $conn;

    $sql = "SELECT au.account_id, a.account_name
            FROM account_users au
            JOIN accounts a ON au.account_id = a.account_id
            WHERE au.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $userAccounts = [];
    while ($row = $result->fetch_assoc()) {
        $userAccounts[$row['account_id']] = $row['account_name'];
    }

    $stmt->close();
    return $userAccounts;
}

// Function to retrieve user's permissions
function getUserPermissions($userID) {
    global $conn;

    $sql = "SELECT up.permission_id, p.name AS permission_name
            FROM user_permissions up
            JOIN permissions p ON up.permission_id = p.id
            WHERE up.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $userPermissions = [];
    while ($row = $result->fetch_assoc()) {
        $userPermissions[$row['permission_id']] = $row['permission_name'];
    }

    $stmt->close();
    return $userPermissions;
}

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Check if user has admin permission
$hasPermission = hasPermission($loggedInUserID, 'admin');

// Redirect if the user does not have permission to edit users
if (!$hasPermission) {
    echo '<script>window.location.href = "manage_users.php";</script>';
    exit();
}

// Validate user ID
if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Retrieve user details
    $user = getUserDetails($userID);

    // Retrieve user's associated accounts
    $userAccounts = getUserAccounts($userID);

    // Retrieve user's permissions
    $userPermissions = getUserPermissions($userID);
} else {
    echo "User ID is not set.";
    exit();
}

?>

<main class="page-wrapper">
    <div class="sm-box">
        <h2 style="text-align: center;">Edit User</h2>
        <form method="POST" action="./php/update_user.php">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required style="width: 100%; padding: 5px;">
            </div>
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required style="width: 100%; padding: 5px;">
            </div>
            
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="profile_id">Profile ID:</label>
                <input type="text" id="profile_id" name="profile_id" value="<?php echo htmlspecialchars($user['profile_id']); ?>" required style="width: 100%; padding: 5px;">
            </div>
            
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="accounts">Accounts:</label>
                <div id="accounts-container">
                    <?php
                    if (!empty($userAccounts)) {
                        foreach ($userAccounts as $accountID => $accountName) {
                            echo '<div class="account-item">';
                            echo '<input type="hidden" name="accounts[]" value="' . $accountID . '">';
                            echo '<span>' . htmlspecialchars($accountName) . '</span>';
                            echo '<button type="button" class="remove-account" onclick="removeAccount(this)"><i class="fas fa-times"></i></button>';
                            echo '</div>';
                        }
                    } else {
                        echo 'No accounts found.';
                    }
                    ?>
                </div>
                <select id="account-selector" required>
                    <option value="" disabled selected>Select Account</option>
                    <?php
                    $query = "SELECT * FROM accounts";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Error retrieving accounts: " . mysqli_error($conn));
                    }

                    while ($account = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $account['account_id'] . '">' . htmlspecialchars($account['account_name']) . '</option>';
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
                    if (!empty($userPermissions)) {
                        foreach ($userPermissions as $permissionID => $permissionName) {
                            echo '<div class="permission-item">';
                            echo '<input type="hidden" name="permissions[]" value="' . $permissionID . '">';
                            echo '<span>' . htmlspecialchars($permissionName) . '</span>';
                            echo '<button type="button" class="remove-permission" onclick="removePermission(this)"><i class="fas fa-times"></i></button>';
                            echo '</div>';
                        }
                    } else {
                        echo 'No permissions found.';
                    }
                    ?>
                </div>
                <select id="permission-selector" required>
                    <option value="" disabled selected>Select Permission</option>
                    <?php
                    $query = "SELECT * FROM permissions";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Error retrieving permissions: " . mysqli_error($conn));
                    }

                    while ($permission = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $permission['permission_id'] . '">' . htmlspecialchars($permission['name']) . '</option>';
                    }

                    mysqli_free_result($result);
                    ?>
                </select>
                <button type="button" class="add-permission" onclick="addPermission()">Add Permission</button>
            </div>

            <div style="text-align: center;">
                <button type="submit" style="padding: 8px 16px;">Update User</button>
                <a href="./manage_users.php" style="margin-left: 10px;">Cancel</a>
            </div>
        </form>
    </div>
</main>

<script>
    const accountSelector = document.getElementById('account-selector');
    const accountsContainer = document.getElementById('accounts-container');

    function addAccount() {
        const selectedValue = accountSelector.value;

        if (selectedValue !== '') {
            const container = document.getElementById('accounts-container');
            const accountElement = document.createElement('div');
            accountElement.classList.add('account-item');
            accountElement.innerHTML = `
                <input type="hidden" name="accounts[]" value="${selectedValue}">
                <span>${accountSelector.options[accountSelector.selectedIndex].text}</span>
                <button type="button" class="remove-account" onclick="removeAccount(this)"><i class="fas fa-times"></i></button>
            `;
            container.appendChild(accountElement);
            accountSelector.remove(accountSelector.selectedIndex);
            updateAccountValidation();

            // Check if the selected account is 'PSUBP' and disable selectors accordingly
            const selectedAccountName = accountSelector.options[accountSelector.selectedIndex].text;
            if (selectedValue === '9') {
                permissionSelector.disabled = true;
// Disable the permission selector
accountSelector.disabled = true; // Disable the account selector
accountSelector.selectedIndex = 0; // Set the default option
const permissionElement = document.createElement('div');
            permissionElement.classList.add('permission-item');
            permissionElement.innerHTML = `
                <input type="hidden" name="permissions[]" value='6'>
                <span>${permissionSelector.options[permissionSelector.selectedIndex].text}</span>
                <button type="button" class="remove-permission" onclick="removePermission(this)"><i class="fas fa-times"></i></button>
            `;
            permissionsContainer.appendChild(permissionElement);
            permissionSelector.remove(permissionSelector.selectedIndex);
            updatePermissionValidation();
        } else {
            accountSelector.disabled = false; // Enable the account selector
            accountSelector.selectedIndex = 0; // Set the default option
        }
    }
}

function removeAccount(button) {
    const accountElement = button.parentNode;
    const accountValue = accountElement.querySelector('input').value;
    const accountSelector = document.getElementById('account-selector');
    const accountName = accountElement.querySelector('span').textContent;

    // Find the original index of the removed account option
    const originalIndex = parseInt(accountValue) - 1;

    // Find the next option with a value greater than the removed option's value
    let nextOption;
    for (let i = originalIndex + 1; i < accountSelector.options.length; i++) {
        if (parseInt(accountSelector.options[i].value) > parseInt(accountValue)) {
            nextOption = accountSelector.options[i];
            break;
        }
    }

    // Insert the removed option before the next option, or at the end if no next option is found
    if (nextOption) {
        accountSelector.insertBefore(createOption(accountValue, accountName), nextOption);
    } else {
        accountSelector.appendChild(createOption(accountValue, accountName));
    }

    // Remove the account element from the container
    accountElement.remove();
    updateAccountValidation();

    // Enable the account selector if PSUBP is removed
    if (accountValue === '9') {
        accountSelector.disabled = false;
        permissionSelector.disabled = false; // Enable the permission selector
    } else {
        accountSelector.disabled = false;
    }
}

function createOption(value, text) {
    const option = document.createElement('option');
    option.value = value;
    option.textContent = text;
    return option;
}

function addPermission() {
    const permissionSelector = document.getElementById('permission-selector');
    const selectedValue = permissionSelector.value;
    const accountSelector = document.getElementById('account-selector');

    if (selectedValue !== '') {
        const container = document.getElementById('permissions-container');
        const permissionElement = document.createElement('div');
        permissionElement.classList.add('permission-item');
        permissionElement.innerHTML = `
            <input type="hidden" name="permissions[]" value="${selectedValue}">
            <span>${permissionSelector.options[permissionSelector.selectedIndex].text}</span>
            <button type="button" class="remove-permission" onclick="removePermission(this)"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(permissionElement);
        permissionSelector.remove(permissionSelector.selectedIndex);
        updatePermissionValidation();

        // Check if the selected permission is 'admin' and disable selectors accordingly
        if (selectedValue === '6') {
            accountSelector.disabled = true; // Disable the account selector
            permissionSelector.disabled = true; // Disable the permission selector
            permissionSelector.selectedIndex = 0; // Set the default option
        } else {
            permissionSelector.selectedIndex = 0; // Set the default option
        }
    }
}

function removePermission(button) {
    const permissionElement = button.parentNode;
    const permissionValue = permissionElement.querySelector('input').value;
    const permissionSelector = document.getElementById('permission-selector');
    const permissionName = permissionElement.querySelector('span').textContent;

    // Find the original index of the removed permission option
    const originalIndex = parseInt(permissionValue) - 1;

    // Find the next option with a value greater than the removed option's value
    let nextOption;
    for (let i = originalIndex + 1; i < permissionSelector.options.length; i++) {
        if (parseInt(permissionSelector.options[i].value) > parseInt(permissionValue)) {
            nextOption = permissionSelector.options[i];
            break;
        }
    }

    // Insert the removed option before the next option, or at the end if no next option is found
    if (nextOption) {
        permissionSelector.insertBefore(createOption(permissionValue, permissionName), nextOption);
    } else {
        permissionSelector.appendChild(createOption(permissionValue, permissionName));
    }

    // Remove the permission element from the container
    permissionElement.remove();
    updatePermissionValidation();

    // Check if the removed permission is 'admin' and enable selectors accordingly
    if (permissionValue === '6') {
        permissionSelector.disabled = false; // Enable the permission selector
    }
}

function updateAccountValidation() {
    const accountSelector = document.getElementById('account-selector');
    const accountContainer = document.getElementById('accounts-container');
    if (accountContainer.children.length > 0) {
        accountSelector.removeAttribute('required');
    } else {
        accountSelector.setAttribute('required', 'required');
    }
}

function updatePermissionValidation() {
    const permissionSelector = document.getElementById('permission-selector');
    const permissionContainer = document.getElementById('permissions-container');
    if (permissionContainer.children.length > 0) {
        permissionSelector.removeAttribute('required');
    } else {
        permissionSelector.setAttribute('required', 'required');
    }
}
</script>
<?php include './admin_utils/admin_footer.php'; ?>