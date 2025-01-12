<?php
// Define database connection constants
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'psubp_db');

// Include the necessary files
require_once './php/check_login.php';
require_once './admin_utils/admin_header.php';
require_once './php/activity_logs.php';

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Function to check if user has a specific account
function hasAccount($userID, $accountName) {
    global $conn;

    $sql = "SELECT a.account_name 
            FROM users u
            JOIN account_users au ON u.id = au.user_id
            JOIN accounts a ON au.account_id = a.account_id
            WHERE u.id = '$userID'";

    $result = mysqli_query($conn, $sql);

    $userAccounts = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userAccounts[] = $row['account_name'];
        }
    }

    return in_array($accountName, $userAccounts);
}

// Check if user has the 'PSUBP' account
$hasPSUBPAccount = hasAccount($loggedInUserID, 'PSUBP');

// Redirect if the user does not have the 'PSUBP' account
if (!$hasPSUBPAccount) {
    echo '<script>window.location.href = "dashboard.php";</script>';
    exit();
}

// Backup Database
if (isset($_POST['backup'])) {
    backupDatabase();
}

// Restore Database
if (isset($_POST['restore'])) {
    restoreDatabase();
}

// Function to backup the database
function backupDatabase() {
    // Simulate restore process with a 5-second delay
    sleep(1);
    // Set the appropriate MySQL command path (for Windows or Linux)
    $mysqlDumpPath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'C:\\xampp\\mysql\\bin\\mysqldump' : 'mysqldump';
    
    // Construct the backup filename with timestamp
    $backupFilename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $backupFilePath = '../backups/' . $backupFilename;
    
    // Construct the mysqldump command
    $command = "{$mysqlDumpPath} --user=" . DB_USER . " --password=" . DB_PASS . " --host=" . DB_HOST . " " . DB_NAME . " > " . $backupFilePath;
    
    // Execute the command and capture output and return status
    exec($command, $output, $return_var);
    
    // Check if the command executed successfully
    if ($return_var === 0) {
        echo '<script>showMessage("Database backed up successfully!");</script>';
        $userId = $_SESSION['id'];
        $accountId = $_SESSION['selected_account'];
        $logMessage = "User Created A Backup";
        logActivity('backup', $logMessage, $userId, $accountId);
    } else {
        // If there's an error, output the error message
        echo '<script>showMessage("Failed to create backup. Error: ' . implode("\n", $output) . '");</script>';
    }
}

// Function to restore the database
function restoreDatabase() {
    // Set the appropriate MySQL command path (for Windows or Linux)
    $mysqlPath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'C:\\xampp\\mysql\\bin\\mysql' : 'mysql';
    
    // Specify the name of the database to restore to
    $targetDatabase = DB_NAME;
    
    // Construct the path to the latest backup file
    $latestBackupFile = glob('../backups/backup_*.sql');
    $latestBackupFile = end($latestBackupFile);
    
    // Check if the latest backup file exists
    if ($latestBackupFile !== false) {
        // Construct the mysql command for restoring the database
        $command = "{$mysqlPath} --user=" . DB_USER . " --password=" . DB_PASS . " --host=" . DB_HOST . " " . $targetDatabase . " < " . $latestBackupFile;
        
        // Execute the command
        exec($command, $output, $return_var);
        
        // Check if the command executed successfully
        if ($return_var === 0) {
            echo '<script>showMessage("Database restored successfully!");</script>';
            $userId = $_SESSION['id'];
            $accountId = $_SESSION['selected_account'];
            $logMessage = "User Restored A Backup";
            logActivity('restore', $logMessage, $userId, $accountId);
        } else {
            // If there's an error, output the error message
            echo '<script>showMessage("Failed to restore database. Error: ' . implode("\n", $output) . '");</script>';
        }
    } else {
        echo '<script>showMessage("No backup file found!");</script>';
    }
}

// Function to display the last backup date
function displayLastBackupDate() {
    if (isset($_SESSION['lastBackup'])) {
        echo "Last Backup: " . $_SESSION['lastBackup'];
    } else {
        echo "No backups available yet.";
    }
}
?>

<main class="page-wrapper">
    <div class="lg-box">
        <h1 class="dashboard-title">Backup and Restore</h1>

        <!-- Backup and Restore Form -->
        <form action="" method="post" class="backup-restore-form">
            <button class="icon-box backup-button" type="submit" name="backup">
                <i class="fas fa-hdd"></i>
                <div class="icon-title">Backup Database</div>
            </button>
            <button class="icon-box restore-button" type="submit" name="restore">
                <i class="fas fa-sync"></i>
                <div class="icon-title">Restore Database</div>
            </button>
        </form>

        <div class="loading-indicator" style="display: none;">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Loading...</span>
        </div>

        <!-- Progress Bar -->
        <div class="progress-bar" style="display: none;">
            <div class="progress" id="progress"></div>
        </div>

        <!-- Display Message -->
        <div class="message"></div>

        <!-- Display last backup date -->
        <div class="last-backup">
            <?php displayLastBackupDate(); ?>
        </div>
    </div>
</main>

<style>
    /* Add styles for the loading indicator */
    .loading-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
    }

    .loading-indicator i {
        font-size: 24px;
        margin-right: 10px;
    }

    .loading-indicator span {
        font-size: 18px;
    }

    /* Update styles for the progress bar */
    .progress-bar {
        width: 100%;
        height: 10px;
        background-color: #f0f0f0;
        margin-top: 10px;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress {
        height: 100%;
        background-color: #3498db;
        width: 0%;
        transition: width 0.5s ease-in-out;
        border-radius: 5px;
    }

    /* Add styles for the action buttons */
    .backup-restore-form {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
    }

    .icon-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #3498db;
        margin: 5px;
        width: 120px;
        height: 120px;
        border-radius: 10px;
        padding: 1px;
        background-color: #ecf0f1;
        transition: background-color 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: #333;
    }

    .icon-box:hover {
        background-color: rgba(5, 50, 5, 0.1);
        box-shadow: 0 5px 10px rgba(1, 2, 3, 0.5);
    }

    .icon-box i {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .icon-title {
        font-size: 0.8rem;
        text-align: center;
        font-weight: bold;
    }

    .last-backup {
        text-align: center;
        margin-top: 20px;
    }

    /* Add styles for the message display */
    .message {
        text-align: center;
        margin-top: 10px;
    }
</style>

<!-- Add Font Awesome link for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    // Function to show progress bar
    function showProgressBar() {
        document.querySelector('.progress-bar').style.display = 'block';
    }

    // Function to hide progress bar
    function hideProgressBar() {
        document.querySelector('.progress-bar').style.display = 'none';
    }

    // Function to update progress
    function updateProgress(progress) {
        document.querySelector('.progress').style.width = progress + '%';
    }

    // Function to show message
    function showMessage(message) {
        const messageDiv = document.querySelector('.message');
        messageDiv.innerText = message;
        messageDiv.style.display = 'block';
    }

    // Function to hide message
    function hideMessage() {
        document.querySelector('.message').style.display = 'none';
    }

// Backup Button Click Event
document.querySelector('.backup-button').addEventListener('click', function() {
    showProgressBar();
    document.querySelector('.loading-indicator').style.display = 'block';
    showMessage("Backing up database... Please wait.");
    hideMessage();
    let progress = 0;
    const backupProgress = Math.random() * 40 + 60; // Simulated backup progress between 60% and 100%
    const progressIncrement = backupProgress / 20; // 20 intervals for faster progress
    const interval = setInterval(function() {
        progress += progressIncrement;
        if (progress >= 50 && progress < 80) {
            clearInterval(interval); // Clear the current interval
            const slowInterval = setInterval(function() {
                progress += progressIncrement / 2;
                updateProgress(progress);
                if (progress >= 80) {
                    clearInterval(slowInterval);
                    const remainingProgress = backupProgress - 80;
                    const remainingProgressInterval = setInterval(function() {
                        progress += remainingProgress / 20;
                        updateProgress(progress);
                        if (progress >= backupProgress) {
                            clearInterval(remainingProgressInterval);
                            setTimeout(() => {
                                hideProgressBar(); // Hide progress bar after 1 second
                                document.querySelector('.loading-indicator').style.display = 'none';
                            }, 1000);
                        }
                    }, 50);
                }
            }, 100);
        } else {
            updateProgress(progress);
            if (progress >= backupProgress) {
                clearInterval(interval);
                setTimeout(() => {
                    hideProgressBar(); // Hide progress bar after 1 second
                    document.querySelector('.loading-indicator').style.display = 'none';
                }, 1000);
            }
        }
    }, 50);
});

// Restore Button Click Event
document.querySelector('.restore-button').addEventListener('click', function() {
    showProgressBar();
    document.querySelector('.loading-indicator').style.display = 'block';
    showMessage("Restoring database... Please wait.");
    hideMessage();
    let progress = 0;
    const restoreProgress = Math.random() * 40 + 60; // Simulated restore progress between 60% and 100%
    const progressIncrement = restoreProgress / 20; // 20 intervals for faster progress
    const interval = setInterval(function() {
        progress += progressIncrement;
        if (progress >= 50 && progress < 80) {
            clearInterval(interval); // Clear the current interval
            const slowInterval = setInterval(function() {
                progress += progressIncrement / 2;
                updateProgress(progress);
                if (progress >= 80) {
                    clearInterval(slowInterval);
                    const remainingProgress = restoreProgress - 80;
                    const remainingProgressInterval = setInterval(function() {
                        progress += remainingProgress / 20;
                        updateProgress(progress);
                        if (progress >= restoreProgress) {
                            clearInterval(remainingProgressInterval);
                            setTimeout(() => {
                                hideProgressBar(); // Hide progress bar after 1 second
                                document.querySelector('.loading-indicator').style.display = 'none';
                            }, 1000);
                        }
                    }, 50);
                }
            }, 100);
        } else {
            updateProgress(progress);
            if (progress >= restoreProgress) {
                clearInterval(interval);
                setTimeout(() => {
                    hideProgressBar(); // Hide progress bar after 1 second
                    document.querySelector('.loading-indicator').style.display = 'none';
                }, 1000);
            }
        }
    }, 50);
});

</script>
