<?php
// Start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once './php/db_connect.php';
<<<<<<< Updated upstream
=======
include_once "admin_chat_system.php";
>>>>>>> Stashed changes

// Retrieve the selected account ID from the session
$selectedAccountID = isset($_SESSION['selected_account']) ? $_SESSION['selected_account'] : null;
$userId = $_SESSION['id']; // Assuming 'id' is the user ID

// Initialize variables for permission and account name
$permissionName = '';
$accountName = '';

// Check if selected account ID is set in the session
if ($selectedAccountID) {
    // Query the database to get the account name based on the selected account ID
    $accountQuery = "SELECT account_name FROM accounts WHERE account_id = $selectedAccountID";
    $accountResult = mysqli_query($conn, $accountQuery);

    if ($accountResult && mysqli_num_rows($accountResult) > 0) {
        // Fetch the account name from the result
        $account = mysqli_fetch_assoc($accountResult);
        $accountName = $account['account_name'];
    } else {
        $accountName = 'No account found';
    }

    // Check for admin permissions
    $permissionQuery = "
        SELECT p.name 
        FROM user_permissions up 
        JOIN permissions p ON up.permission_id = p.id 
        WHERE up.user_id = $userId AND p.name = 'admin'
    ";
    $permissionResult = mysqli_query($conn, $permissionQuery);

    // Set permissionName if the user has admin permission
    if ($permissionResult && mysqli_num_rows($permissionResult) > 0) {
        $permissionName = 'admin';
    }
}

// Function to fetch asset details based on criteria
function getAssetByCriteria($accountId, $assetCategory, $assetType, $conn) {
    $query = "SELECT file_name FROM assets WHERE account_id = '$accountId'  AND asset_category = '$assetCategory' AND asset_type = '$assetType'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $asset = mysqli_fetch_assoc($result);
        return $asset['file_name'];
    }
    return null;
}

// Example criteria values (replace with actual values or retrieve dynamically)
$accountId = 9;
$assetType = 'Logo';
$assetCategory = 'Photo';

// Get the filename from the database based on criteria
$filename = getAssetByCriteria($accountId, $assetType, $assetCategory, $conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../psubp/styles/modern-normalize.css">
  <link rel="stylesheet" href="../../psubp/styles/manage-post.css">
  <link rel="stylesheet" href="../../psubp/styles/dashboard.css">
  <link rel="stylesheet" href="../../psubp/styles/post.css">
  <link rel="stylesheet" href="../../psubp/styles/utils.css">
  <link rel="stylesheet" href="../../psubp/styles/style.css">  
  <link rel="stylesheet" href="../../psubp/styles/nav.css">  
  <link rel="stylesheet" href="../../psubp/styles/fontawesome/css/fontawesome.min.css">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="../../psubp/styles/create-post.css">
  <link rel="stylesheet" href="../../psubp/styles/create-profile.css">





  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6.3.1/dist/tippy-bundle.umd.min.js"></script>



</head>
<body class = "admin-page-wrapper">
  <aside class="sidebar">
    <div class="sidebar-toggle" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </div>
    <ul class="sidebar-menu">
    <li><a href="./dashboard.php"><i class="fas fa-tachometer-alt"></i><span class="menu-text">DASHBOARD</span></a></li>
    <li><a href="./manage_posts.php"><i class="fas fa-pencil-alt"></i><span class="menu-text">POSTS</span></a></li>
<<<<<<< Updated upstream
=======
    <li><a href="./manage_chat_sessions.php"><i class="fas fa-comments"></i><span class="menu-text">Chat Inquiries</span></a></li>
>>>>>>> Stashed changes
    <li><a href="./manage_profiles.php"><i class="fas fa-users"></i><span class="menu-text">PROFILES</span></a></li>
    
    <!-- <?php if ($permissionName === 'admin' || $accountName === 'PSUBP'): ?>
        <li><a href="./manage_activity_logs.php"><i class="fas fa-history"></i><span class="menu-text">ACTIVITY LOGS</span></a></li>
    <?php endif; ?>
     -->
    <li><a href="./manage_users.php"><i class="fas fa-user-cog"></i><span class="menu-text">USERS</span></a></li>
    
    <?php if ($permissionName === 'admin'|| $accountName === 'PSUBP'): ?>
    <li><a href="./manage_archive.php"><i class="fas fa-archive"></i><span class="menu-text">ARCHIVE</span></a></li>
    <?php endif; ?>
    
    
    <li><a href="./manage_assets.php"><i class="fas fa-images"></i><span class="menu-text">ASSETS</span></a></li>
    
    <?php if ($permissionName === 'admin'|| $accountName === 'PSUBP'): ?>
    <li><a href="./manage_activity_logs.php"><i class="fas fa-history"></i><span class="menu-text">ACTIVITY LOGS</span></a></li>
    <?php endif; ?>


    <?php if ($accountName === 'PSUBP'): ?>
        <li><a href="./backup_and_restore.php"><i class="fas fa-database"></i><span class="menu-text">BACKUP & RESTORE</span></a></li>
    <?php endif; ?>
    
    <li><a href="./php/logout.php"><i class="fas fa-sign-out-alt"></i><span class="menu-text">LOGOUT</span></a></li>

    </ul>
  </aside>

  



  <div class = "content-wrapper">

    <div class="top-nav">
        <!-- <a href="../index.php">
          <div class="logo">
            <img src="../public/logo.png" alt="Logo"> <span>PSU</span> BP  
          </div>
        </a>     -->
            
        <a href="../../psubp/index.php" class="logo-wrapper td-none">
        <div class="logo">
            <?php
            if ($filename) {
                // Construct the path to the asset
                $assetPath = '../../psubp/public/assets/' . $filename;
                echo '<img src="' . $assetPath . '" alt="University Logo">';
            } else {
                echo '<p>Logo not found.</p>';
            }
            ?>
        </div>
            <div style = "color: white; font-size: 20px;"><span><strong style = "color: white; font-size: 20px;">Palawan State University</strong>
            <br></span>Brooke's Point Campus</div>
          </a> 
        
            
          <div class="right-section">
          <div class="user-profile">
    <div class="account-icon">
        <i class="fas fa-user"></i>
    </div>
    <div class="user-info">
        <span class="username">
            <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'No username found'; ?>
        </span>
        <span class="account-name"><?php echo "($accountName)"; ?></span>
        <i class="fas fa-caret-down" style="padding: 0 5px;"></i>
    </div>
    <!-- <div class="logout">
        <a href="./logout.php">Logout</a>
    </div> -->
</div>

          </div>
        </div>
        <div class="icon-container">
        <a href="./chat.php?chat_id=2" class="info-icon" data-tippy-content="Chat System">
  <i class="fas fa-comment-alt"></i>
</a>
  <a href="./system_information.php" class="info-icon" data-tippy-content="System Information"><i class="fas fa-info-circle"></i></a>
  <a href="./support_center.php" class="support-icon" data-tippy-content="Support Center"><i class="fas fa-headset"></i></a>
</div>
<script>
  tippy('.info-icon', {
    delay: [0, 100], // Adjust the delay values as needed
    theme: 'light',
    arrow: true,
  });

  tippy('.support-icon', {
    delay: [0, 100], // Adjust the delay values as needed
    theme: 'light',
    arrow: true,
  });
</script>
