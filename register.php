<?php
session_start();

$registration_message = "";
$registration_success = false;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "safety_management";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    
    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $registration_message = "You are not an employee.";
    } else {
        $row = $result->fetch_assoc();
        if ($row['is_registered'] == 0) {
            // Update user password and set is_registered to 1
            $update_sql = "UPDATE users SET password = ?, is_registered = '1' WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $password, $email);
            if ($update_stmt->execute()) {
                $registration_success = true;
                $registration_message = "Registration successful. <a href='login.php'>Login here</a>.";
            } else {
                $registration_message = "Error: Registration failed.";
            }
            $update_stmt->close();
        } else {
            $registration_message = "You are already registered. <a href='login.php'>Login here</a>.";
        }
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <section class="register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card p-4">
                        <h5 class="text-center">Create an Account</h5>
                        <?php if (!empty($registration_message)): ?>
                        <div class="alert <?php echo $registration_success ? 'alert-success' : 'alert-danger'; ?>">
                            <?php echo $registration_message; ?>
                        </div>
                        <?php endif; ?>
                        <form method="POST" action="" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="yourEmail" class="form-label">Your Work Email</label>
                                <input type="email" name="email" class="form-control" id="yourEmail" required>
                                <div class="invalid-feedback">Please enter a valid email.</div>
                            </div>
                            <div class="mb-3">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Please enter your password.</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirmPassword"
                                    required>
                                <div class="invalid-feedback">Passwords do not Match</div>
                            </div>
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" id="acceptTerms" required>
                                <label class="form-check-label" for="acceptTerms">I agree to the terms and
                                    conditions</label>
                                <div class="invalid-feedback">You must agree before submitting.</div>
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Create Account</button>
                            <p class="small mt-2">Already have an account? <a href="login.php">Log in</a></p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
    // Bootstrap form validation
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                var password = document.getElementById('yourPassword').value;
                var confirmPassword = document.getElementById('confirmPassword').value;
                if (password !== confirmPassword) {
                    event.preventDefault();
                    event.stopPropagation();
                    document.getElementById('confirmPassword').setCustomValidity(
                        'Passwords do not match');
                } else {
                    document.getElementById('confirmPassword').setCustomValidity('');
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>
</body>

</html>