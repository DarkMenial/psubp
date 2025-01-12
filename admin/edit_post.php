<?php
include './php/check_login.php';
include './admin_utils/admin_header.php';

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

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Check if user has admin or create_post permission
$hasPermission = hasPermission($loggedInUserID, 'admin') || hasPermission($loggedInUserID, 'edit_post');

// Redirect if the user does not have permission to edit posts or is not associated with PSUBP account
if (!$hasPermission) {
    echo '<script>window.location.href = "manage_posts.php";</script>';
    exit();
}

// Retrieve the selected account ID from the session or URL parameter
$selectedAccountID = isset($_SESSION['selected_account']) ? $_SESSION['selected_account'] : null;

// Function to retrieve user's associated accounts
function getUserAccounts($userID) {
    global $conn;

    $sql = "SELECT au.account_id, a.account_name
            FROM account_users au
            JOIN accounts a ON au.account_id = a.account_id
            WHERE au.user_id = '$userID'";

    $result = mysqli_query($conn, $sql);

    $userAccounts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $userAccounts[$row['account_id']] = $row['account_name'];
    }

    return $userAccounts;
}

// Get user's associated accounts
$userAccounts = getUserAccounts($loggedInUserID);

// Validate post ID
if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    // Retrieve post data from the database
    $query = "SELECT * FROM posts WHERE id = '$postID'";
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
        $postAccountID = $post['account_id'];

        // Check if the logged-in user is associated with the account of the post or is the PSUBP account
        if (array_key_exists($postAccountID, $userAccounts) || in_array('PSUBP', $userAccounts)) {
            // Populate form fields with retrieved post data
            $title = $post['title'];
            $content = $post['content'];
            $topicID = $post['topic_id'];
            $publish = $post['publish'];
            $autoArchive = $post['auto_archive'];
            $autoArchiveDate = $post['auto_archive_date'];
        } else {
            // Handle case when user is not authorized to edit the post
            echo "You are not authorized to edit this post.";
            exit();
        }
    } else {
        // Handle case when post is not found
        echo "Post not found.";
        exit();
    }
} else {
    // Handle case when post ID is not set
    echo "Post ID is not set.";
    exit();
}
?>


<main class="page-wrapper"> 
    <div class="box">
        <div class="lg-box">
            <h2>Edit Post</h2>
            <div class="add-post-container">
                <form id="myForm" action="./php/update_post.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="post_id" value="<?php echo $postID; ?>">
                    <div class="form-row">
                        <div class="form-column">
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title" required maxlength="120" value="<?php echo $title; ?>">
                        </div>
                    </div>
                    <input type="hidden" id="quill-content" name="content">
                    <div>
                        <label for="content">Content:</label>
                        <div class="editor">
                            <!-- <div id="quill-editor"><?php echo $content; ?></div> -->
                            <textarea id="content" name="content"><?php echo $content; ?></textarea>
                        </div>
                    </div>
                    <div class="save-container"> 
                        <div class="form-column">
                            <select id="topic" name="topic_id" required onchange="handleTopicChange()">
                                <option value="">Select Topic</option>
                                <?php
                                $query = "SELECT * FROM topics";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $topicID = $row['topic_id'];
                                    $topicName = $row['topic_name'];
                                    $selected = ($topicID === $topicID) ? 'selected' : '';
                                    echo '<option value="' . $topicID . '"' . $selected . '>' . $topicName . '</option>';
                                }
                                mysqli_free_result($result);
                                ?>
                            </select>
                            <!-- Populate other form fields -->
                            <div class="save-containers">  
                                <div class="form-column">
                                    <div class="form-column">
                                        <div class="button-container">
                                            <button type="submit">Save</button>
                                            <button type="discard-post" onclick="discardPost()">Discard</button>
                                        </div>
                                    </div>
                                    <div class="form-column">
                                        <div class="check-box-container"> 
                                            <div class="form-row">
                                                <label for="publish">Publish:</label>
                                                <input type="checkbox" id="publish" name="publish" <?php if($publish == 1) echo "checked"; ?>>
                                            </div>
                                        </div>
                                        <div class="check-box-container"> 
                                            <div class ="form-column">
                                                <div class="auto-archive-container">
                                                    <label for="auto-archive" class="checkbox-label">Archive:</label>
                                                    <input type="checkbox" id="auto-archive" name="auto-archive" <?php if($autoArchive == 1) echo "checked"; ?> onchange="handleAutoArchiveChange()">
                                                    <input type="date" id="auto-archive-date" name="auto-archive-date" class="auto-archive-date-input" <?php if($autoArchive == 1) echo "value='$autoArchiveDate'"; ?> <?php if($autoArchive != 1) echo "disabled"; ?>>
                                                </div>
                                            </div>
                                            <div id="duration-container" <?php if($autoArchive != 1) echo "style='display:none;'"; ?>>
                                                <div>
                                                    <label for="start-date">Start Date:</label>
                                                    <input type="date" id="start-date" name="start-date" value="<?php echo $startDate; ?>">
                                                </div>
                                                <div>
                                                    <label for="end-date">End Date:</label>
                                                    <input type="date" id="end-date" name="end-date" value="<?php echo $endDate; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-column">
                            <label class="custom-file-upload" id="choose-file-label">
                                <i class="fas fa-image"></i> Choose Image
                                <input type="file" id="file-upload" name="image" accept="image/*" onchange="previewImage(event)">
                            </label>

                            <div class="image-preview-container">
                                <div id="discard-container" style="display: <?php echo ($post['image'] ? 'block' : 'none'); ?>; position: relative;">
                                    <button type="button" id="discard-image" onclick="discardImage()" style="position: absolute; top: 0px; right: 0;"><i class="fas fa-times-circle"></i></button>
                                </div>
                                <?php
                                // Check if the image filename is available
                                if (!empty($post['image'])) {
                                    // Construct the full filepath
                                    $imagePath = '/psubp/public/posts/images/' . $post['image'];
                                    ?>
                                    <img id="image-preview" src="<?php echo $imagePath; ?>" alt="Image Preview" style="display: block; max-width: 200px; margin-top: 10px; margin-left: auto;">
                                <?php } else { ?>
                                    <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 200px; margin-top: 10px; margin-left: auto;">
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
       
   <!-- Include the Quill library -->
   <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  
  <script type="module" src="../src/post-quill-editor.js"></script>

  

<script>

function previewImage(event) {
    var file = event.target.files[0];
    var imagePreview = document.getElementById('image-preview');
    var discardContainer = document.getElementById('discard-container');
    var chooseFileLabel = document.getElementById('choose-file-label');

    if (file) {
        var reader = new FileReader();

        reader.onload = function(event) {
            imagePreview.src = event.target.result;
            imagePreview.style.display = 'block';
            discardContainer.style.display = 'block';
            chooseFileLabel.style.display = 'none';
        }

        reader.readAsDataURL(file);
    } else {
        imagePreview.style.display = 'none';
        discardContainer.style.display = 'none';
        chooseFileLabel.style.display = 'block';
    }
}


function discardImage() {
    var fileUpload = document.getElementById('file-upload');
    fileUpload.value = '';
    var imagePreview = document.getElementById('image-preview');
    imagePreview.src = '#';
    imagePreview.style.display = 'none';
    var discardContainer = document.getElementById('discard-container');
    discardContainer.style.display = 'none';
    var chooseFileLabel = document.getElementById('choose-file-label');
    chooseFileLabel.style.display = 'block';
}



// Get the necessary elements
const autoArchiveCheckbox = document.getElementById('auto-archive');
const autoArchiveDateInput = document.getElementById('auto-archive-date');

// Add event listener to the auto archive checkbox
autoArchiveCheckbox.addEventListener('change', () => {
if (autoArchiveCheckbox.checked) {
  autoArchiveDateInput.disabled = false;
  const endDate = new Date();
  endDate.setDate(endDate.getDate() + 7); // Set the default auto archive date to 7 days from today
  const endDateString = endDate.toISOString().slice(0, 10); // Format the end date as yyyy-mm-dd
  autoArchiveDateInput.value = endDateString;
} else {
  autoArchiveDateInput.disabled = true;
  autoArchiveDateInput.value = '';
}
});

 </script>

<script>
// Get the necessary elements
const topicSelect = document.getElementById('topic');
const durationContainer = document.getElementById('duration-container');
const startDateInput = document.getElementById('start-date');
const endDateInput = document.getElementById('end-date');

// Function to handle topic change
function handleTopicChange() {
const selectedTopic = topicSelect.value;
if (selectedTopic === 'event' || selectedTopic === 'announcement') {
  durationContainer.style.display = 'block';
} else {
  durationContainer.style.display = 'none';
}
}

// Function to handle auto archive change
function handleAutoArchiveChange() {
if (autoArchiveCheckbox.checked) {
  autoArchiveDateInput.disabled = false;
  const endDate = endDateInput.value;
  autoArchiveDateInput.value = endDate;
} else {
  autoArchiveDateInput.disabled = true;
  autoArchiveDateInput.value = '';
}
}
</script>

<script>
// Get the title input element
const titleInput = document.getElementById('title');

// Add event listener for input event
titleInput.addEventListener('input', () => {
if (titleInput.value.length > 120) {
  titleInput.value = titleInput.value.slice(0, 120);
}
});

</script>

<script>

function execCommand(command) {
document.execCommand(command, false, null);
}

function insertLink() {
var url = prompt('Enter the URL:');
if (url) {
  document.execCommand('createLink', false, url);
}
}

function insertImage() {
var url = prompt('Enter the image URL:');
if (url) {
  document.execCommand('insertImage', false, url);
}
}

function insertVideo() {
var url = prompt('Enter the video URL:');
if (url) {
  var embedCode = '<iframe width="560" height="315" src="' + url + '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
  document.execCommand('insertHTML', false, embedCode);
}
}

<script>
// Call the previewImage function if there's an image associated with the post
window.addEventListener('DOMContentLoaded', () => {
    var imagePreview = document.getElementById('image-preview');
    var discardContainer = document.getElementById('discard-container');
    var chooseFileLabel = document.getElementById('choose-file-label');

    // Check if there's an image associated with the post
    if (imagePreview.src !== '#' && imagePreview.src !== '' && imagePreview.style.display !== 'none') {
        discardContainer.style.display = 'block';
        chooseFileLabel.style.display = 'none';
    }
});
</script>


</script>
<script type="module" src="../src/sidebar-toggle.js"></script>
<script>
// Call the previewImage function if there's an image associated with the post
window.addEventListener('DOMContentLoaded', () => {
    var imagePreview = document.getElementById('image-preview');
    var discardContainer = document.getElementById('discard-container');
    var chooseFileLabel = document.getElementById('choose-file-label');

    // Check if there's an image associated with the post
    if (imagePreview.src !== '#' && imagePreview.src !== '' && imagePreview.style.display !== 'none') {
        discardContainer.style.display = 'block';
        chooseFileLabel.style.display = 'none';
    }
});
</script>

</html>