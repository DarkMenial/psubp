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

// Check if user has admin or create_profile permission
$hasPermission = hasPermission($loggedInUserID, 'admin') || hasPermission($loggedInUserID, 'create_profile');

// Redirect if the user does not have permission to create a profile or admin rights
if (!$hasPermission) {
    echo '<script>window.location.href = "manage_profiles.php";</script>';
    exit();
}
?>

<main class="page-wrapper">
  <div class="card sm-box">
    <div class="card-body">
      <form id="myForm" action="./php/get_profile.php" method="POST" enctype="multipart/form-data">
        <h2>Add Profile</h2>
        <div class="profile-container">
          <div class="profile-image">
            <label for="file-upload" class="profile-image-label">
              <i class="fas fa-camera"></i>
            </label>
            <input type="file" id="file-upload" name="image" accept="image/*" onchange="previewImage(event)">
            <img id="profile-image-preview" src="#" alt="Profile Image Preview" style="display: none;">
          </div>
        </div>

        <div class="form-column">
          <input type="text" name="name" placeholder="Name" required>
          <input type="text" name="position" placeholder="Position" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="tel" name="phone" placeholder="Phone" required>
          <textarea name="bio" placeholder="Bio" required></textarea>
          <button type="submit">Add Profile</button>
        </div>
      </form>
    </div>
  </div>
</main>

<style>
.card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 400px;
  margin: 20px auto;
}

.card-header {
  background-color: #f5f5f5;
  border-bottom: 1px solid #ddd;
  padding: 10px;
}

.card-header h2 {
  margin: 0;
  font-size: 20px;
  color: #333;
}

.card-body {
  padding: 20px;
}

.card-body input,
.card-body textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.card-body button[type="submit"] {
  background-color: #4caf50;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
}

.card-body button[type="submit"]:hover {
  background-color: #45a049;
}

.profile-container {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.profile-image {
  position: relative;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  overflow: hidden;
  background-color: #f5f5f5;
}

.profile-image-label {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  cursor: pointer;
  opacity: 0;
  transition: opacity 0.3s;
}

.profile-image-label:hover {
  opacity: 1;
}

.profile-image-label i {
  color: #fff;
  font-size: 40px;
}

.profile-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: none;
}

.form-column {
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>

<script>
function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById('profile-image-preview');
    output.src = reader.result;
    output.style.display = 'block';
  };
  reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php include './admin_utils/admin_footer.php'; ?>