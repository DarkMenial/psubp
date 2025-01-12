<?php
include $_SERVER['DOCUMENT_ROOT'] . '/psubp/html_utils/header.php';
echo '<style>';
echo 'body {' . PHP_EOL;echo '  background-image: url("path_to_background_image.jpg");' . PHP_EOL;echo '  background-size: cover;' . PHP_EOL;echo '  filter: blur(5px);' . PHP_EOL;echo '}' . PHP_EOL;echo '</style>';
echo '<div class="section">';
echo '</div>';
echo '<div class="section">';
echo '</div>';
echo '<div class="container">';
echo '<div class="container-post-topic">';
echo '<h1>Article</h1>';
echo '</div>';
echo '<div class="container__posts">';
echo '<div class="post-container-image">';
echo '<img src="../../../psubp/public/posts/images/test 7_2023-10-24.jpg" alt="Announcement Image">';
echo '</div>';
echo '<div class="post-container-content">';
echo '<h1>test 7</h3>';
echo '<p>2023-10-24</p>';
echo '<p>7</p>';
echo '</div>';
echo '</div>';
echo '</div>';
include $_SERVER['DOCUMENT_ROOT'] . '/psubp/html_utils/footer.php';
?>