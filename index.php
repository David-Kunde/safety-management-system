<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety ManagementSystem</title>
    <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="bootstrap/bootstrap.bundle.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #004e92, #000428);
        color: #fff;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .header {
        background: rgba(0, 0, 0, 0.9);
    }

    .hero {
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1rem;
    }

    .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        font-weight: normal;
    }

    .hero p {
        font-size: 1rem;
        margin-bottom: 2rem;
        font-weight: normal;
    }

    .footer {
        background: rgba(0, 0, 0, 0.9);
        padding: 1rem 0;
        text-align: center;
    }

    .footer a {
        color: #fff;
        text-decoration: underline;
    }

    .profile-image-pic {
        height: 150px;
        width: 150px;
        object-fit: cover;
        border-radius: 50%;
    }

    .btn-custom {
        margin: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 0.9rem;
        }

        .profile-image-pic {
            height: 120px;
            width: 120px;
        }

        .navbar-brand {
            font-size: 1.2rem;
        }

        .nav-link {
            font-size: 0.9rem;
        }
    }
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
            <a class="navbar-brand px-4" href="index.php">
                <img src="assets/img/logo.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
                OHSMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse align-items-center" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mx-4">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Sign up</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container d-flex justify-content-center align-items-center flex-column hero">
        <div class="text-center">
            <img src="assets/img/logo.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                alt="profile">
        </div>
        <h1>Welcome to Occupational Safety Management System</h1>
        <p>Your safety, well-being, and compliance in the workplace.</p>

        <div class="mt-4">
            <a href="incident-report.php" class="btn btn-danger btn-lg btn-custom">Report Incident</a>
            <a href="login.php?role=employee" class="btn btn-secondary btn-lg btn-custom">Login as Employee</a>
            <a href="login-admin.php?role=admin" class="btn btn-primary btn-lg btn-custom">Login as Admin</a>

        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; OHSMS. All Rights Reserved</p>
        </div>
    </footer>
</body>

</html>