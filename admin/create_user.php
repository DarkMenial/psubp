<?php
require_once './php/db_connect.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include './admin_utils/admin_header.php';

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
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required style="width: 100%; padding: 5px;">
            </div>
            <div class="form-group" style="margin-bottom: 10px;">
                <label for="accounts">Accounts:</label>
                <div id="accounts-container">
                    <!-- Selected accounts will be dynamically added here -->
                </div>
                <select id="account-selector" required>
                    <option value="">Select Account</option> <!-- Add an empty option -->
                    <?php
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
                    <option value="">Select Permission</option>
                    <?php
                    // Fetch permissions from the database
                    $permissionsQuery = "SELECT DISTINCT name FROM permissions";
                    $permissionsResult = mysqli_query($conn, $permissionsQuery);

                    if (!$permissionsResult) {
                        die("Error retrieving permissions: " . mysqli_error($conn));
                    }

                    // Display permission options
                    while ($permission = mysqli_fetch_assoc($permissionsResult)) {
                        echo '<option value="' . $permission['name'] . '">' . $permission['name'] . '</option>';
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
function addAccount() {
    const accountSelector = document.getElementById('account-selector');
    const selectedValue = accountSelector.value;
    const permissionSelector = document.getElementById('permission-selector');

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
        }
    }
}

function removeAccount(button) {
    const accountElement = button.parentNode;
    const accountValue = accountElement.querySelector('input').value;
    const accountSelector = document.getElementById('account-selector');
    const accountName = accountElement.querySelector('span').textContent;

    const optionElement = document.createElement('option');
    optionElement.value = accountValue;
    optionElement.textContent = accountName;
    accountSelector.appendChild(optionElement);
    accountElement.remove();
    updateAccountValidation();

    // Check if the removed account is 'PSUBP' and enable selectors accordingly
    if (accountValue === '9') {
        const permissionSelector = document.getElementById('permission-selector');
        permissionSelector.disabled = false; // Enable the permission selector
        accountSelector.disabled = false; // Enable the account selector
    }
}




    



    function addPermission() {
        const selector = document.getElementById('permission-selector');
        const selectedValue = selector.value;
        if (selectedValue !== '') {
            const container = document.getElementById('permissions-container');
            const permissionElement = document.createElement('div');
            permissionElement.classList.add('permission');
            permissionElement.innerHTML = `
                <input type="hidden" name="permissions[]" value="${selectedValue}">
                <span>${selectedValue}</span>
                <button type="button" class="remove-permission" onclick="removePermission(this)"><i class="fas fa-times"></i></button>
            `;
            container.appendChild(permissionElement);
            selector.remove(selector.selectedIndex);
            updatePermissionValidation();

            if (selectedValue === 'admin') {
                selector.disabled = true; // Disable the permission selector
            }
        }
    }

    function removePermission(button) {
        const permissionElement = button.parentNode;
        const permissionValue = permissionElement.querySelector('input').value;
        const selector = document.getElementById('permission-selector');
        const optionElement = document.createElement('option');
        optionElement.value = permissionValue;
        optionElement.textContent = permissionValue;
        selector.appendChild(optionElement);
        permissionElement.remove();
        updatePermissionValidation();

        if (permissionValue === 'admin') {
            selector.disabled = false; // Enable the permission selector
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
} else {
    header("Location: login.php");
    exit();
}
?>