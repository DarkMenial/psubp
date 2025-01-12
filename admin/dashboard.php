<?php include './php/check_login.php'; ?>
<?php include './admin_utils/admin_header.php'; ?>

<main class="page-wrapper">
    <div class="box">
        <div class="lg-box">
            <!-- Content of the dashboard goes here -->
            <div class="text-center">
                <h1 class="dashboard-title">Admin Dashboard</h1>
                <p class="dashboard-text">Hello, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?>!</p>
                <p class="dashboard-text">This is your admin dashboard where you can manage posts and more.</p>

                <!-- Icons section -->
                <div class="icons-section">
                    <!-- Manage Users -->
                    <div class="icon-box">
                        <a href="./manage_users.php">
                            <i class="fas fa-users"></i>
                            <div class="icon-info">
                                <div class="icon-title">10 New Users</div>
                            </div>
                        </a>
                    </div>

                    <!-- Post -->
                    <div class="icon-box">
                        <a href="./manage_posts.php">
                            <i class="fas fa-file-alt"></i>
                            <div class="icon-info">
                                <div class="icon-title">5 New Posts</div>
                            </div>
                        </a>
                    </div>

                    <!-- Recent Activity -->
                    <div class="icon-box">
                        <a href="./activity_logs.php">
                            <i class="fas fa-history"></i>
                            <div class="icon-info">
                                <div class="icon-title">10 New Activities</div>
                            </div>
                        </a>
                    </div>

                    <!-- User Feedback -->
                    <div class="icon-box">
                        <a href="./user_feedback.php">
                            <i class="fas fa-comment-alt"></i>
                            <div class="icon-info">
                                <div class="icon-title">0 New User Feedback</div>
                            </div>
                        </a>
                    </div>

                    <!-- System Notifications -->
                    <div class="icon-box">
                        <a href="./system_notifications.php">
                            <i class="fas fa-bell"></i>
                            <div class="icon-info">
                                <div class="icon-title">3 New System Notifications</div>
                            </div>
                        </a>
                    </div>

                    <!-- Support Requests -->
                    <div class="icon-box">
                        <a href="./support_requests.php">
                            <i class="fas fa-hands-helping"></i>
                            <div class="icon-info">
                                <div class="icon-title">5 New Support Requests</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="account-statistics">
                <h2 class="account-stats-title">Account Statistics</h2>
                <div class="account-stats">
                    <div class="account-stat-box">
                        <i class="fas fa-university"></i>
                        <p class="account-stat-text">Admission Office</p>
                        <p class="account-stat-count">Users: 3, Posts: 20</p>
                    </div>
                    <div class="account-stat-box">
                        <i class="fas fa-graduation-cap"></i>
                        <p class="account-stat-text">BSIT</p>
                        <p class="account-stat-count">Users: 2, Posts: 53</p>
                    </div>
                    <div class="account-stat-box">
                        <i class="fas fa-book"></i>
                        <p class="account-stat-text">BSCRIM</p>
                        <p class="account-stat-count">Users: 5, Posts: 12</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>




.box {
    width: 100%;
    display: flex;
    justify-content: center;
}



.dashboard-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: black;
}

.dashboard-text {
    font-size: 1rem;
    color: #555;
}

.icons-section {
    margin-top: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.icon-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px solid #3498db;
    margin: 5px;
    width: 120px;
    height: 120px;
    border-radius: 10px;
    padding: 1px;
    background-color: #ecf0f1;
    transition: background-color 0.3s, box-shadow 0.3s;
}

.icon-box a {
    text-decoration: none;
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
}

.icon-box:hover {
    background-color: rgba(5, 50, 5, 0.1);
    box-shadow: 0 5px 10px rgba(1, 2, 3, 0.5);
}

.icon-box i {
    font-size: 2rem;
    margin-bottom: 10px;
}

.icon-title {
    font-size: 0.8rem;
    text-align: center;
    color: #333;
    font-weight: bold;
}

.icon-info {
    text-align: center;
}

.account-statistics {
    margin-top: 20px;
}

.account-stats-title {
    font-size: 1.8rem;
    font-weight: bold;
    color: black;
    margin-bottom: 10px;
}

.account-stats {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.account-stat-box {
    padding: 20px;
    margin: 10px;
    border-radius: 10px;
    width: 220px;
    text-align: center;
    background-color: #ecf0f1;
}

.account-stat-text {
    font-weight: bold;
    color: #333;
}

.account-stat-box i {
    font-size: 25px;
}

</style>


