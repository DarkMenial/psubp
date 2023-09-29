<?php
require_once 'db_connect.php';

// Get the filter values
$filterAuthor = $_GET['filter-author'] ?? 'all';
$filterTopic = $_GET['filter-topic'] ?? 'all';

// Construct the SQL query based on the filter values
$query = "SELECT p.id, p.title, p.image, p.content, t.topic_name, a.account_name, u.full_name, p.publish, p.date_posted
FROM posts p
JOIN users u ON p.user_id = u.id
JOIN account_users au ON u.id = au.user_id
JOIN accounts a ON au.account_id = a.account_id
JOIN topics t ON p.topic_id = t.topic_id";

// Add filters to the query if specified
if ($filterAuthor !== 'all') {
    $query .= " WHERE a.account_name = '$filterAuthor'";
}

if ($filterTopic !== 'all') {
    $topicID = mysqli_real_escape_string($conn, $filterTopic);
    $query .= " AND t.topic_id = '$topicID'";
}

// Execute the SELECT query
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the results and display them as cards
        echo '<ul class="announcement-list grid-view">';

        while ($post = mysqli_fetch_assoc($result)) {
            $cardID = 'card-' . $post['id'];
            $author = $post['account_name'];
            $postType = $post['topic_name'];

            echo '<div class="card expandable-card" id="' . $cardID . '" data-author="' . $author . '" data-post-type="' . $postType . '">';
            echo '<div class="card-header">';
            echo '<div class="card-thumbnail">';
            echo '<img src="./public/posts/' . $post['image'] . '" alt="Announcement Image" class="card-image">';
            echo '</div>';
            echo '<div class="card-details">';
            echo '<div class="card-top">';
            echo '<p class="card-topic">' . strtoupper($post['topic_name']) . '</p>';
            echo '</div>';
            echo '<div class="card-bottom">';
            echo '<div class="card-title">';
            echo '<h3>' . $post['title'] . '</h3>';
            echo '</div>';
            echo '<p class="card-author">' . $post['account_name'] . '</p>';
            echo '<div class="card-meta">';
            echo '<p class="card-date">' . $post['date_posted'] . '</p>';
            echo '</div>';
            echo '<button class="expand-button" onclick="expandCard(\'' . $cardID . '\')">';
            echo '<i class="fas fa-ellipsis-h" style="color: #f05c26;"></i>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="card-content">';

            // Limit the content to a specific number of characters
            $maxContentLength = 130;
            $content = $post['content'];

            // Check if the content exceeds the maximum length and contains multiple paragraphs
            if (strlen($content) > $maxContentLength && strpos($content, "\n") !== false) {
                // Get the first paragraph
                $paragraphs = explode("\n", $content);
                $firstParagraph = trim($paragraphs[0]);

                // Check if the first paragraph meets the maximum length requirement
                if (strlen($firstParagraph) > $maxContentLength) {
                    $content = substr($firstParagraph, 0, $maxContentLength) . '...';
                } else {
                    $content = $firstParagraph;
                }
            } elseif (strlen($content) > $maxContentLength) {
                // Trim the content to the maximum length
                $content = substr($content, 0, $maxContentLength) . '...';
            }

            echo '<p class="card-description">' . nl2br($content) . '</p>';

            // Modify the href attribute to include the underscore (_) in the title
            $postFileName = str_replace(' ', '_', $post['title']);
            echo '<a href="./posts/' . $postFileName . '.php" class="view-post-button">VIEW ' . strtoupper($post['topic_name']) . '<i class="fas fa-external-link-alt"></i></a>';

            echo '</div>';
            echo '<div class="card-footer">';
            echo '</div>';
            echo '</div>';
        }

        echo '</ul>';
    } else {
        echo '<p>No posts found.</p>';
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Display the MySQL error
    echo 'Query error: ' . mysqli_error($conn);
}
?>