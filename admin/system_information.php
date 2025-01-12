<?php
require_once './php/db_connect.php';
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    if (!isset($_SESSION['sidebarCollapsed'])) {
        $_SESSION['sidebarCollapsed'] = false;
    }

    if (isset($_GET['toggle'])) {
        $_SESSION['sidebarCollapsed'] = !$_SESSION['sidebarCollapsed'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
?>

<?php include './admin_utils/admin_header.php'; ?>

<main class="page-wrapper">
    <div class="container mt-4 system-info-section">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="dashboard-title">System Information</h1>
                <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <h2><i class="fas fa-file-alt"></i> Project Title</h2>
                        <p>Palawan State University Promotional and Informative Website</p>

                        <h2><i class="fas fa-info"></i> Project Description</h2>
                        <p>This website serves as a platform to promote Palawan State University and provide information to its stakeholders. It addresses the need for an online presence to disseminate essential information and updates.</p>

                        <h2><i class="fas fa-bullseye"></i> Objective</h2>
                        <p>The main objective of this project is to create an informative and user-friendly website that showcases the offerings, achievements, and activities of Palawan State University.</p>
                    </div>

                    <div class="col-lg-6">
                        <h2><i class="fas fa-tasks"></i> Features</h2>
                        <ul>
                            <li>User Authentication and Management</li>
                            <li>Managing User Profiles</li>
                            <li>Creating and Managing Dynamic Content</li>
                            <li>Easy Asset Management and Updates</li>
                            <li>Informative and Up-to-Date Content</li>
                            <li>News, Events, and Announcement Management</li>
                            <li>Document Repository</li>
                            <li>Effective Search and Filter Functionality</li>
                            <li>Feedback System for Users</li>
                            <li>Real-Time Updates and Feeds</li>
                            <li>Interactive Maps</li>
                            <li>Email Newsletters</li>
                            <li>Admin Support Request</li>
                            <li>Support Center with Issue Reporting</li>
                            <li>Knowledge Base and FAQs</li>
                            <li>Messaging System for Support and Bug Reporting</li>
                        </ul>
                    </div>





                    <div class="col-lg-6">
                        <h2><i class="fas fa-laptop-code"></i> Technology Stack</h2>
                        <p>HTML, CSS, JavaScript, PHP, MySQL</p>

                        <h2><i class="fas fa-users"></i> Team Members</h2>
                        <ul>
                            <li>Mark Daniel Rodriguez - Main Developer</li>
                            <li>Elizabeth Siprioto - Developer</li>
                            <li>Aira Jean Collado - Developer</li>
                            <li>Angelica Bautista - Developer</li>


                        </ul>
                    </div>
                

                <div class="row">
                    <div class="col-lg-6">
                        <h2><i class="fas fa-handshake"></i> Acknowledgments</h2>
                        <p>We acknowledge the support and guidance provided by the faculty and staff of Palawan State University in the development of this project.</p>

                        <h2><i class="fas fa-envelope"></i> Contact Information</h2>
                        <p>Email: markdaniel17@gmail.com</p>
                        <p>Phone: 09386055998</p>
                    </div>

                    <div class="col-lg-6">
                        <h2><i class="fas fa-code-branch"></i> Version Information</h2>
                        <p>Version 1.0</p>
                    </div>
                    </div>
        </div>
    </div>
</main>

<style>
/* Updated styles for System Information section */



.dashboard-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

.system-info-section {
    padding-bottom: 1380px; /* Add some padding at the bottom */
}

.row {
    margin-bottom: 50px;
}

.col-lg-6 {
    width: 100%;
    padding: 30px 40px;
}

.col-lg-6 h2 {
    font-size: 1.8rem;
    margin-top: 30px;
    color: #333;
}

.col-lg-6 p {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 15px;
}

.col-lg-6 ul {
    margin-top: 10px;
    margin-bottom: 20px;
}

.col-lg-6 ul li {
    font-size: 1.1rem;
    color: #555;
}

hr {
    border-top: 2px solid #ccc;
    width: 100%;
    margin-top: 15px;
    margin-bottom: 30px;
}

</style>

<?php include './admin_utils/admin_footer.php'; ?>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>