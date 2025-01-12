<?php
require_once 'db_connect.php';

// Get the filter values
$filterPosition = $_GET['filter-position'] ?? 'all';

// Construct the SQL query based on the filter values
$query = "SELECT p.id AS profile_id, p.name, p.position, p.email, p.phone, p.photo
    FROM profiles p";

// Add filters to the query if specified
if ($filterPosition !== 'all') {
    $position = mysqli_real_escape_string($conn, $filterPosition);
    $query .= " WHERE p.position = '$position'";
}

// Execute the SELECT query
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {


        while ($profile = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $profile['profile_id'] . '</td>'; // Display Profile ID
            echo '<td>' . $profile['name'] . '</td>';
            echo '<td>' . $profile['position'] . '</td>';
            echo '<td>' . $profile['email'] . '</td>';
            echo '<td>' . $profile['phone'] . '</td>';
            echo '<td><img src="' . $profile['photo'] . '" alt="Profile Photo" style="width: 50px; height: 50px;"></td>';
            echo '<td>';
            echo '<div class="action-buttons">';
            echo '<button class="edit-button" onclick="editProfile(' . $profile['profile_id'] . ')">Edit</button>';
            echo '<button class="archive-button" onclick="archiveProfile(' . $profile['profile_id'] . ')">Archive</button>';
            echo '<button class="delete-button" onclick="deleteProfile(' . $profile['profile_id'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<p>No profiles found.</p>';
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Display the MySQL error
    echo 'Query error: ' . mysqli_error($conn);
}
?>
