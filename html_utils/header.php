<?php
<<<<<<< Updated upstream
require_once $_SERVER['DOCUMENT_ROOT'] . '/psubp/admin/php/db_connect.php';

=======
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/psubp/admin/php/db_connect.php';

// ██████╗██╗  ██╗ █████╗ ████████╗
// ██╔════╝██║  ██║██╔══██╗╚══██╔══╝
// ██║     ███████║███████║   ██║   
// ██║     ██╔══██║██╔══██║   ██║   
// ╚██████╗██║  ██║██║  ██║   ██║   
//  ╚═════╝╚═╝  ╚═╝╚═╝  ╚═╝   ╚═╝   


// Retrieve user session or cookie
$user_email = $_SESSION['user_email'] ?? $_COOKIE['user_email'] ?? '';
$user_name = $_SESSION['user_name'] ?? $_COOKIE['user_name'] ?? '';
$chat_active = isset($_SESSION['chat_id']);
$chat_department = '';
$max_cookie_lifetime = 259200; // 3 days
$extend_time = 86400; // 1 day




// Fetch active chat sessions and latest chat info in a single query
$sql = "SELECT cs.chat_id, cs.user_name, a.account_name 
        FROM chat_sessions cs
        JOIN accounts a ON cs.account_id = a.account_id
        WHERE cs.user_email = ? AND cs.status != 'closed' 
        ORDER BY cs.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$chat_sessions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Set session if not active but chat exists
if (!$chat_active && !empty($chat_sessions)) {
  $_SESSION['chat_id'] = $chat_sessions[0]['chat_id'];
  $_SESSION['user_name'] = $chat_sessions[0]['user_name'];
  $_SESSION['user_email'] = $user_email;
  $expiration_time = time() + $max_cookie_lifetime;
  setcookie("chat_id", $chat_sessions[0]['chat_id'], $expiration_time, "/");
  setcookie("user_name", $chat_sessions[0]['user_name'], $expiration_time, "/");
  setcookie("user_email", $user_email, $expiration_time, "/");
  $chat_active = true;
}




if ($chat_active) {
    $chat_department = $chat_sessions[0]['account_name'] ?? '';

        // Extend cookies by 1 day but never exceed 3 days from the original set time
        if (isset($_COOKIE['chat_id'])) {
          $current_expiration = $_COOKIE['chat_id_exp'] ?? time();
          $new_expiration = min(time() + $extend_time, $current_expiration + $extend_time, time() + $max_cookie_lifetime);
          setcookie("chat_id", $_COOKIE['chat_id'], $new_expiration, "/");
          setcookie("user_name", $_COOKIE['user_name'], $new_expiration, "/");
          setcookie("user_email", $_COOKIE['user_email'], $new_expiration, "/");
          setcookie("chat_id_exp", $new_expiration, $new_expiration, "/");
      }
}

// Fetch available chat subjects
$subjectsQuery = "SELECT id, name FROM chat_subjects ORDER BY name ASC";
$subjectsResult = mysqli_query($conn, $subjectsQuery);
$chat_subjects = mysqli_fetch_all($subjectsResult, MYSQLI_ASSOC);

// Available departments
$sql = "SELECT account_id, account_name FROM accounts WHERE account_name IS NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->execute();
$departments_result = $stmt->get_result();

$all_departments = [];
while ($row = $departments_result->fetch_assoc()) {
    $all_departments[] = $row;
}
$active_departments = array_column($chat_sessions, 'account_name');
// Extract account IDs from $all_departments
$all_department_ids = array_column($all_departments, 'account_id');
$available_department_ids = array_diff($all_department_ids, $active_departments);

// Now, filter the departments based on the available IDs
$available_departments = array_filter($all_departments, function ($dept) use ($available_department_ids) {
    return in_array($dept['account_id'], $available_department_ids);
});



  
// Handle form submission for new chat session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$chat_active) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $department = isset($_POST['account_id']) ? (int) trim($_POST['account_id']) : null;
    $subject_id = isset($_POST['subject_id']) ? (int) trim($_POST['subject_id']) : null;
    

    if (!empty($name) && !empty($email) && !empty($department)) {
        $chat_id = uniqid();
        $_SESSION['chat_id'] = $chat_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;

        // Set cookies to preserve session data for 1 hour
        setcookie('chat_id', $chat_id, time() + 3600, '/');
        setcookie('user_name', $name, time() + 3600, '/');
        setcookie('user_email', $email, time() + 3600, '/');

        $sql = "INSERT INTO chat_sessions (chat_id, user_name, user_email, status, account_id, subject_id) 
        VALUES (?, ?, ?, 'open', ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("sssii", $chat_id, $name, $email, $department, $subject_id);

if ($stmt->execute()) {
    echo "✅ Chat session successfully inserted.<br>";
} else {
    echo "❌ Error inserting chat session: " . $stmt->error . "<br>";
}

// Debugging: Verify the inserted data
$sql_check = "SELECT * FROM chat_sessions WHERE chat_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $chat_id);
$stmt_check->execute();
$result = $stmt_check->get_result();
$chat_data = $result->fetch_assoc();

if ($chat_data) {
    echo "🔍 Chat session exists in database:<br>";
    print_r($chat_data);
} else {
    echo "❌ Chat session NOT FOUND after insertion.<br>";
}


        // Redirect after session creation
        header('Refresh: 0');  // This will reload the current page
        exit();
    }
}




// Handle creating a new chat session when a department is selected (using new-chat-form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $chat_active) {
    $department = $_POST['account_id'] ?? '';  // Make sure this is the account_id

    if (!empty($department)) {
        // Create a new session for the selected department
        $chat_id = uniqid();
        $_SESSION['chat_id'] = $chat_id;
        $subject = $_POST['id'] ?? '';  // This will now contain account_id


        // Set the new department
        setcookie('chat_id', $chat_id, time() + 3600, '/');

        $sql = "INSERT INTO chat_sessions (chat_id, user_name, user_email, status, account_id, subject_id) 
        VALUES (?, ?, ?, 'open', ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $chat_id, $user_name, $user_email, $department, $subject);

        

        // Redirect after session creation
        header('Refresh: 0');  // This will reload the current page
        exit();
    }
}
// echo "🔍 Debugging Info:<br>";
// echo "Session: "; print_r($_SESSION);
// echo "Cookies: "; print_r($_COOKIE);
// echo "Database Chat Sessions: "; print_r($chat_sessions);




>>>>>>> Stashed changes

// Function to fetch asset details based on criteria
function getAssetByCriteria($accountId, $assetType, $assetCategory, $conn) {
  $query = "SELECT file_name FROM assets WHERE account_id = '$accountId' AND asset_type = '$assetType'  AND asset_category = '$assetCategory'";
  $result = mysqli_query($conn, $query);
  if ($result && mysqli_num_rows($result) > 0) {
      $asset = mysqli_fetch_assoc($result);
      return $asset['file_name'];
  }
  return null;
}

// Example criteria values (replace with actual values or retrieve dynamically)
$accountId = 9;
$assetType = 'Photo';
$assetCategory = 'Logo';

// Get the filename from the database based on criteria
$filename = getAssetByCriteria($accountId, $assetType, $assetCategory, $conn);

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../../psubp/styles/modern-normalize.css" />
    <link rel="stylesheet" href="../../../psubp/styles/post.css" />
    <link rel="stylesheet" href="../../../psubp/styles/owl.carousel.min.css" />
    <link rel="stylesheet" href="../../../psubp/styles/owl.theme.default.min.css" />
    <link rel="stylesheet" href="../../../psubp/styles/academic-calendar.css" />
    <link rel="stylesheet" href="../../../psubp/styles/academic-department.css" />
    <link rel="stylesheet" href="../../../psubp/styles/news&events.css" />
    <link rel="stylesheet" href="../../../psubp/styles/style.css" />
    <link rel="stylesheet" href="../../../psubp/styles/footer.css" />
    <link rel="stylesheet" href="../../../psubp/styles/programs&courses.css" />
    <link rel="stylesheet" href="../../../psubp/styles/utils.css" />
    <link rel="stylesheet" href="../../../psubp/styles/nav.css" />
    <link rel="stylesheet" href="../../../psubp/styles/profile-card.css" />
    <link rel="stylesheet" href="../../../psubp/styles/organizational-chart.css" />
    <link rel="stylesheet" href="../../../psubp/styles/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">

    
        <!-- █████╗ ███████╗███████╗███████╗████████╗███████╗
            ██╔══██╗██╔════╝██╔════╝██╔════╝╚══██╔══╝██╔════╝
            ███████║███████╗███████╗█████╗     ██║   ███████╗
            ██╔══██║╚════██║╚════██║██╔══╝     ██║   ╚════██║
            ██║  ██║███████║███████║███████╗   ██║   ███████║
            ╚═╝  ╚═╝╚══════╝╚══════╝╚══════╝   ╚═╝   ╚══════╝ -->
                          



    
  <title>University Website</title>
  </head>
  <body>
    <header class="header">
      <nav>
        <!-- Logo -->
        <div class="nav-content container">
          <a href="/psubp/index.php" class="logo-wrapper td-none">
            <div class="logo-img-wrapper">
            <?php
            if ($filename) {
              // Construct the URL to the asset
              $assetUrl = '/psubp/public/assets/' . $filename;
              echo '<img src="' . $assetUrl . '" alt="University Logo">';
            } else {
              echo '<p>Logo not found.</p>';
            }
            ?>
            </div>
            <div><span><strong>Palawan State University</strong>
            <br></span>Brooke's Point Campus</div>
          </a>
          
        <div class="header__nav-list">
          <!-- Secondary NavList (upper) -->
          <ul class="secondary-list">
            <li>
              <a href="/psubp/about.php">About</a>
                <ul class="dropdown">
                  <li><a href="/psubp/about.php#mission&vission">Mission & Vission</a></li>
                  <li><a href="/psubp/about.php#history" data-section="history">History</a></li>
                      <li><a href="/psubp/about.php#quality-policy">Quality Policy</a></li>
                      <li><a href="/psubp/faculty&staff.php">Faculty and Staff</a></li>
                      <!-- <li><a href="/psubp/organizationl_chart.php">Organizational Chart</a></li> -->
                      <!-- <li><a href="#contact-us#">Contact Us</a>
                         <ul class="has-dropdown sub-dropdown social-media-icons">
                            <li><a href="#" class="social-icon"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="#" class="social-icon"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a></li>
                          </ul>
                        </li> -->
            </li>
          </ul>
                
             
      
            <li>
              <a href="/psubp/news&events.php">News & Events</a>
              <!-- <ul class="dropdown">
                <li><a href="#">Admission Office Announcements</a></li>
                <li><a href="#">Academic Department News</a>
                  <ul class="has-dropdown sub-dropdown">
                    <li><a href="./academic_department/bsed.php#N&E">BSED</a></li>
                    <li><a href="./academic_department/beed.php#N&E">BEED</a></li>
                    <li><a href="./academic_department/bscrim.php#N&E">BSCRIM</a></li>
                    <li><a href="./academic_department/bsit.php#N&E">BSIT</a></li>
                    <li><a href="./academic_department/bshm.php#N&E">BSHM</a></li>
                    <li><a href="./academic_department/bsagri.php#N&E">BSAGRI</a></li>
                    <li><a href="./academic_department/bsba.php#N&E">BSBA</a></li>
                  </ul>
                </li>
                <li><a href="pta.php#N&E">PTA News & Events</a></li>
              </ul> -->
            </li>
            <li>
              <a href="/psubp/people_directory.php">People Directory</a>
            </li>
          </ul>
          <!-- Main NavList (lower) -->
          <ul class="main-list">
  
  
            <!-- <li>
              <div class="search-container">
                <input type="text" id="search-bar" placeholder="Search">
              </div>
              <div class="search-button"><i id="search-icon" class="fa fa-search"></i></div>
            </li> -->
            
            <li>
              <a href="#">ACADEMICS</a>
              <ul class="dropdown">
                <li><a href="/psubp/academic_calendar.php">Academic Calendar</a></li>
                <li><a href="/psubp/programs&courses.php">Academic Programs</a></li>
                <!-- <li><a href="/psubp/academic_departments.php">Academic Departments</a></li> -->
                <li><a href="/psubp/program_heads.php">Programs Head</a></li>  
                <!-- <li><a href="academics.php#majors">Majors</a></li> -->
                <!-- <li><a href="/psubp/portals.php">Portals</a></li> -->
              </ul>
            </li>
  
            <li>  
              <a href="/psubp/admission.php#admissions">ADMISSIONS</a>
            <ul class="dropdown">
              <li><a href="/psubp/admission_requirements.php">Admission Requirements</a></li>
              <li><a href="/psubp/admission_process.php">Admission Process</a></li>
              </ul>
            </li>  
            <!-- <li><a href="/psubp/student-affairs.php#student-affairs">STUDENT AFFAIRS</a>
              <ul class="dropdown">
                    <li><a href="/psubp/student-government.php#student-government">Student Government</a></li>
                    <li><a href="#">Student Resources</a></li>
              </ul>
            </li> -->
          </ul>
        </div>
        </div>
      </nav>
      
    </header>
<<<<<<< Updated upstream
    
=======
    

>>>>>>> Stashed changes
