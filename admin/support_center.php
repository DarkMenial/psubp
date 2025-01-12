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
                <h1 class="dashboard-title">Support Center</h1>
                <hr>

                <div class="row">
                    <!-- <div class="col-lg-6">
                        <div class="support-grid">
                            <div class="support-item">
                                <i class="fas fa-envelope"></i>
                                <h2>Contact Support</h2>
                                <p>Contact our support team for assistance with any issues or queries.</p>
                                <a href="#" class="btn btn-primary">Contact Support</a>
                            </div> -->

                            <div class="col-lg-4">
                                <div class="support-item">
                                    <i class="fas fa-book"></i>
                                    <h2>FAQs & Guides</h2>
                                    <p>Explore our FAQs and in-depth guides and tutorials.</p>
                                    <a href="#" class="btn btn-secondary">Explore FAQs & Guides</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- <div class="col-lg-6">
                        <div class="support-grid">
                            <div class="support-item">
                                <i class="fas fa-ticket-alt"></i>
                                <h2>Submit a Ticket</h2>
                                <p>Submit a support ticket for specific issues or inquiries.</p>
                                <a href="#" class="btn btn-info">Submit Ticket</a>
                            </div> -->

                            <div class="support-item">
                                <i class="fas fa-wrench"></i>
                                <h2>Troubleshooting Guides</h2>
                                <p>Find step-by-step troubleshooting guides for common problems.</p>
                                <a href="#" class="btn btn-success">Troubleshooting Guides</a>
                            </div>
                        </div>
                    </div>
                </div>
</main>

<style>
/* Updated styles for Support Center section */
.system-info-section {
    padding-bottom: 620px; /* Add some padding at the bottom */
}

hr {
    border-top: 2px solid #ccc;
    width: 100%;
    margin-top: 15px;
    margin-bottom: 30px;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

.support-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px; /* Adjust the gap between items as needed */
}

.support-item {
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 20px;
}

.support-item i {
    font-size: 36px;
    margin-bottom: 10px;
    display: block;
}

.support-item h2 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.support-item p {
    margin-bottom: 20px;
}

.support-item .btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 1.1rem;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    background-color: #f05c26;
    color: #fff;
}

.support-item .btn:hover {
    background-color: #333;
    color: #fff;
}
</style>

<?php include './admin_utils/admin_footer.php'; ?>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
