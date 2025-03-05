<?php
session_start();

// Redirect to index if the user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}       

// Database connection (XAMPP default credentials for xammpp)
$host = 'localhost';
$dbname = 'safety_management'; 
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user data based on the email from the session
    $email = $_SESSION['email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found!";
        exit();
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Staff Profile</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f8f9fa;
    }

    .sidebar {
        height: 100vh;
        background-color: #343a40;
        color: #fff;
        padding: 1rem;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .sidebar a {
        color: #fff;
        text-decoration: none;
        margin: 0.5rem 0;
    }

    .sidebar a:hover {
        text-decoration: underline;
    }

    .main-content {
        margin-left: 250px;
        padding: 2rem;
        max-width: 1000px;
        margin: auto;
    }

    .navbar-toggler {
        display: none;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .main-content {
            margin-left: 0;
        }

        .navbar-toggler {
            display: block;
        }
    }

    .footer {
        text-align: center;
        padding: 1rem 0;
        background: rgba(0, 0, 0, 0.9);
        color: #fff;
        position: relative;
        bottom: 0;
        width: 100%;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="assets/img/oshm logo.png" alt="">
                <span class="d-none d-lg-block">Safety Management</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn d-none"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Accident reported</h4>
                                <p>Fire accident at the pumping station</p>
                                <p>2 min. ago</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Missed Safety Drill</h4>
                                <p>Safety drill schedule missed</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Fire Risk</h4>
                                <p>Risk analysed and resolved</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Upcoming HSE Training</h4>
                                <p>Training schedule for week 12, 2025</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['surname']); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['surname']); ?></h6>
                            <span><?php echo htmlspecialchars($user['job_title']); ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="staff-dashboard.php">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="staff-dashboard.php">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Sidebar -->
    <div class="sidebar collapse" id="sidebarMenu">
        <!-- Sidebar content here -->
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="pagetitle">
            <h1>Profile</h1>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            <h2><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['surname']); ?></h2>
                            <h3><?php echo htmlspecialchars($user['job_title']); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>
                            </ul>

                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title text-center">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Full Name</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo htmlspecialchars($user['first_name'] . ' ' . ($user['middle_name'] ?? '') . ' ' . $user['surname']); ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Section</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo htmlspecialchars($user['section'] ?? ''); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Job Title</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo htmlspecialchars($user['job_title'] ?? ''); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Date of Employment</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo htmlspecialchars($user['date_of_employment'] ?? ''); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Home Address</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo htmlspecialchars($user['home_address'] ?? ''); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo htmlspecialchars($user['phone'] ?? ''); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php echo htmlspecialchars($user['email'] ?? ''); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>