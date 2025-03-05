<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "safety_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for modal messages
$modalTitle = "";
$modalMessage = "";
$modalType = ""; // Can be "success" or "error"

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $reporter_id = 1; // Assuming a default reporter_id for now
    $incident_type = $_POST['reportType'];
    $incident_title = $_POST['incidentTitle'];
    $description = $_POST['incidentDescription'];
    $location = $_POST['incidentLocation'];
    $date_reported = $_POST['incidentDate'];
    $severity_level = $_POST['severityLevel'];
    $risk_score = 0; // Assuming a default risk_score for now
    $status = "Pending"; // Default status
    $file_path = "";

    // Handle file upload
    if (isset($_FILES['incidentFile']) && $_FILES['incidentFile']['error'] == 0) {
        $target_dir = __DIR__ . "/incident_report_files/"; // Absolute path to the folder
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }

        $file_name = basename($_FILES["incidentFile"]["name"]);
        $target_file = $target_dir . $file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["incidentFile"]["tmp_name"], $target_file)) {
            $file_path = "incident_report_files/" . $file_name; // Relative path for database storage
        } else {
            $modalTitle = "Error";
            $modalMessage = "Error uploading file.";
            $modalType = "error";
        }
    }

    // Insert data into the database
    if (empty($modalMessage)) { // Only proceed if no errors occurred during file upload
        $sql = "INSERT INTO incidents_reports (reporter_id, incident_title, incident_type, description, location, date_reported, severity_level, risk_score, status, file_path)
                VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssiss", $reporter_id, $incident_title, $incident_type, $description, $location, $date_reported, $severity_level, $risk_score, $status, $file_path);

        if ($stmt->execute()) {
            $modalTitle = "Success";
            $modalMessage = "Your <strong>$incident_type</strong> report has been submitted successfully.";
            $modalType = "success";
        } else {
            $modalTitle = "Error";
            $modalMessage = "Error: " . $stmt->error;
            $modalType = "error";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Incident</title>
    <meta name="description" content="Incident Reporting System">
    <meta name="keywords" content="safety, incident, report, management">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f8f9fa;
    }

    .main-content {
        padding: 2rem;
        max-width: 1000px;
        margin: auto;
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

    .form-label {
        font-weight: 500;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        border-color: #86b7fe;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                Safety Management
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="pagetitle text-center mb-4">
            <h1>Report an Incident</h1>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Incident Details</h5>
                    <form id="incidentForm" class="row g-3 needs-validation" novalidate action="" method="POST"
                        enctype="multipart/form-data">
                        <!-- Incident Title -->
                        <div class="col-12">
                            <label for="incidentTitle" class="form-label">Incident Title</label>
                            <input type="text" class="form-control" id="incidentTitle" name="incidentTitle" required>
                            <div class="invalid-feedback">Please enter the incident title.</div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="incidentDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="incidentDescription" name="incidentDescription" rows="5"
                                required></textarea>
                            <div class="invalid-feedback">Please provide a detailed description of the incident.</div>
                        </div>

                        <!-- Report Type -->
                        <div class="col-md-6">
                            <label for="reportType" class="form-label">Report Type</label>
                            <select class="form-select" id="reportType" name="reportType" required>
                                <option value="">Choose...</option>
                                <option value="Hazard">Hazard</option>
                                <option value="Accident">Accident</option>
                                <option value="Incident">Incident</option>
                            </select>
                            <div class="invalid-feedback">Please select the type of report.</div>
                        </div>

                        <!-- Date -->
                        <div class="col-md-6">
                            <label for="incidentDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="incidentDate" name="incidentDate" required>
                            <div class="invalid-feedback">Please select the date of the incident.</div>
                        </div>

                        <!-- Location -->
                        <div class="col-md-6">
                            <label for="incidentLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="incidentLocation" name="incidentLocation"
                                required>
                            <div class="invalid-feedback">Please specify the location of the incident.</div>
                        </div>

                        <!-- Severity Level -->
                        <div class="col-md-6">
                            <label for="severityLevel" class="form-label">Severity Level</label>
                            <select class="form-select" id="severityLevel" name="severityLevel" required>
                                <option value="">Choose...</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            <div class="invalid-feedback">Please select the severity level.</div>
                        </div>

                        <!-- File Upload -->
                        <div class="col-12">
                            <label for="incidentFile" class="form-label">Upload Image/Video</label>
                            <input type="file" class="form-control" id="incidentFile" name="incidentFile"
                                accept="image/*,video/*">
                            <div class="invalid-feedback">Please upload relevant files (optional).</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Submit Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; <strong>Safety Management System</strong>. All Rights Reserved</p>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel"><?php echo $modalTitle; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $modalMessage; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- In-Page JavaScript -->
    <script>
    // Show modal if there is a message to display
    <?php if (!empty($modalMessage)): ?>
    document.addEventListener("DOMContentLoaded", function() {
        const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
        resultModal.show();
    });
    <?php endif; ?>
    </script>
</body>

</html>