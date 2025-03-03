<?php






// Define university-wide "About" content
$universityAbout = [
    'history' => [
        'title' => 'History',
        'content' => 'The Palawan State University (PSU) has its humble beginnings...',
    ],
    'mission' => [
        'title' => 'Mission',
        'content' => 'Palawan State University is committed to upgrading people’s quality of life...',
    ],
    'vision' => [
        'title' => 'Vision',
        'content' => 'An internationally recognized university that provides relevant and innovative...',
    ],
    'quality-policy' => [
        'title' => 'Quality & Policy',
        'content' => 'We Provide equal opportunities for relevant, innovative and...',
    ],
    // Add more sections as needed
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About PSU</title>
    <!-- Include your CSS files -->
<<<<<<< Updated upstream
    <link rel="stylesheet" href="/psubp/styles/modern-normalize.css">
    <link rel="stylesheet" href="/psubp/styles/post.css">
    <link rel="stylesheet" href="/psubp/styles/academic-calendar.css">
    <link rel="stylesheet" href="/psubp/styles/news&events.css">
    <link rel="stylesheet" href="/psubp/styles/style.css">
    <link rel="stylesheet" href="/psubp/styles/utils.css">
    <link rel="stylesheet" href="/psubp/styles/nav-department.css">
=======
    <link rel="stylesheet" href="/styles/modern-normalize.css">
    <link rel="stylesheet" href="/styles/post.css">
    <link rel="stylesheet" href="/styles/academic-calendar.css">
    <link rel="stylesheet" href="/styles/news&events.css">
    <link rel="stylesheet" href="/styles/style.css">
    <link rel="stylesheet" href="/styles/utils.css">
    <link rel="stylesheet" href="/styles/nav-department.css">
>>>>>>> Stashed changes
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
</head>
<body>

<section></section>

<!-- Main Content -->
<main class="main-content">
    <section class="container__pages container__banner">
        <!-- Banner Image and Title -->
        <div>
            <div class="banner__content">
                <h2>About PSU</h2>
            </div>
            <img src="./public/banner.jpg" alt="Banner Image">
            <div class="banner__overlay"></div>
        </div>
    </section>

    <section id="about" class="container">
        <!-- Sidebar and Main Content -->
        <div class="container__sidemain">
            <div class="sidebar__sticky">
                <?php
                // Display sidebar buttons based on current content (department or university-wide)
                $content = isset($currentDepartment) ? $currentDepartment['sections'] : $universityAbout;
                foreach ($content as $sectionId => $section) {
                    echo '<button class="nav-button" data-section="' . $sectionId . '">' . $section['title'] . '</button>';
                }
                ?>
            </div>
            <div class="main">
                <?php
                // Display main content based on current content (department or university-wide)
                foreach ($content as $sectionId => $section) {
                    echo '<section id="' . $sectionId . '">';
                    echo '<div class="container page_container">';
                    echo '<h1>' . $section['title'] . '</h1>';
                    echo '<p>' . $section['content'] . '</p>';
                    echo '</div>';
                    echo '</section>';
                    echo '<div class="section"></div>';
                    echo '<div class="sectionline"></div>';
                    echo '<div class="section"></div>';
                }
                ?>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<<<<<<< Updated upstream
<?php include $_SERVER['DOCUMENT_ROOT'] .'/psubp/html_utils/footer.php'; ?>
=======
<?php include $_SERVER['DOCUMENT_ROOT'] .'/html_utils/footer.php'; ?>
>>>>>>> Stashed changes
</body>
</html>
