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
    echo '<script>window.location.href = "manage_users.php";</script>';
    exit();
}
?>

<?php
    // Redirect to manage_users.php after saving
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $selectedAccounts = $_POST['accounts'] ?? [];
        $selectedPermissions = $_POST['permissions'] ?? [];

        // Redirect to get_user.php with form data
        header('Location: get_user.php?username=' . urlencode($username) . '&password=' . urlencode($password) . '&email=' . urlencode($email) . '&accounts=' . urlencode(implode(',', $selectedAccounts)) . '&permissions=' . urlencode(implode(',', $selectedPermissions)));
        exit();
    }
?>

<main class="page-wrapper">
    <div class="sm-box">
        <h2 style="text-align: center;">Create User</h2>
        <form method="POST" action="./php/get_user.php">
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required style="width: 100%; padding: 5px;">
            </div>
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 5px;">
            </div>
            
            <div class="form-group" style="margin-bottom: 10px;">
    <label for="profile_id">Profile ID:</label>
    <input type="text" id="profile_id" name="profile_id" required style="width: 100%; padding: 5px;">
</div>

            
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="accounts">Accounts:</label>
                <div id="accounts-container">
                    <!-- Selected accounts will be dynamically added here -->
                </div>
                <select id="account-selector" required>
                <option value="" disabled selected>Select Account</option> <!-- Disable and select by default -->                    <?php
                    // Fetch accounts from the database
                    $query = "SELECT * FROM accounts";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die("Error retrieving accounts: " . mysqli_error($conn));
                    }

                    // Display account options
                    while ($account = mysqli_fetch_assoc($result)) {
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
                    <!-- Selected permissions will be dynamically added here -->
                </div>
                <select id="permission-selector" required>
                <option value="" disabled selected>Select Permission</option> <!-- Disable and select by default -->
                    <?php
                    // Fetch permissions from the database
                    $permissionsQuery = "SELECT * FROM permissions";
                    $permissionsResult = mysqli_query($conn, $permissionsQuery);

                    if (!$permissionsResult) {
                        die("Error retrieving permissions: " . mysqli_error($conn));
                    }

                    // Display permission options
                    while ($permission = mysqli_fetch_assoc($permissionsResult)) {
                        echo '<option value="' . $permission['id'] . '">' . $permission['name'] . '</option>';
                    }

                    mysqli_free_result($permissionsResult);
                    ?>
                </select>
                <button type="button" class="add-permission" onclick="addPermission()">Add Permission</button>
            </div>
            <div class="form-group" style="text-align: center;">
                <button type="submit" style="padding: 8px 16px;">Create</button>
                <a href="./manage_users.php" style="margin-left: 10px;">Cancel</a>
            </div>
        </form>
    </div>
</main>

<script>
    const permissionSelector = document.getElementById('permission-selector');

    
function addAccount() {
    const accountSelector = document.getElementById('account-selector');
    const selectedValue = accountSelector.value;

    if (selectedValue !== '') {
        const container = document.getElementById('accounts-container');
        const accountElement = document.createElement('div');
        accountElement.classList.add('account');
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
            permissionSelector.disabled = true; // Disable the permission selector
            accountSelector.disabled = true; // Disable the account selector
            accountSelector.selectedIndex = 0; // Set the default option

        permissionElement.classList.add('permission');
        permissionElement.innerHTML = `
            <input type="hidden" name="permissions[]" value= '6'>
            <span>${permissionSelector.options[permissionSelector.selectedIndex].text}</span>
            <button type="button" class="remove-permission" onclick="removePermission(this)"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(permissionElement);
        permissionSelector.remove(permissionSelector.selectedIndex);
        updatePermissionValidation();

        } else {
    accountSelector.disabled = true; // Enable the account selector
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
        permissionElement.classList.add('permission');
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
            accountSelector.disabled = false; // Disable the account selector
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

    const optionElement = document.createElement('option');
    optionElement.value = permissionValue;
    optionElement.textContent = permissionName;
    // permissionSelector.appendChild(optionElement);
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

<?php
    include './admin_utils/admin_footer.php';
?>