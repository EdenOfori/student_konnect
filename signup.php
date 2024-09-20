<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_konnect";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("connection failed" . mysqli_connect_error());
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $checkUserQuery = "SELECT * FROM users WHERE username='$username'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);
 $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!$checkUserResult) {
        // Display the exact MySQL error for debugging
        die(json_encode(['status' => 'error', 'message' => 'Check user query error: ' . mysqli_error($conn)]));
    }

    if (!$checkUserResult->num_rows > 0) {
        // Insert user into database
        $insertUserQuery = "INSERT INTO users(name,username,email,password,profile_image) VALUES ('$name','$username','$email','$hashedPassword', ?)";
        $insertUserStatement = mysqli_prepare($conn, $insertUserQuery);

        if (!$insertUserStatement) {
            // Display the exact MySQL error for debugging
            die(json_encode(['status' => 'error', 'message' => 'Insert user statement error: ' . mysqli_error($conn)]));
        }

        // Bind the parameters
        mysqli_stmt_bind_param($insertUserStatement, "s", $filename);

        // File upload handling
        if (isset($_FILES["uploadfile"])) {
            $uploadFile = $_FILES["uploadfile"];

            // Check if there is no error
            if ($uploadFile["error"] == UPLOAD_ERR_OK) {
                $filename = uniqid() . '_' . $uploadFile["name"]; // Unique filename to avoid conflicts
                $tempname = $uploadFile["tmp_name"];
                $folder = "./profile/" . $filename;

                // Validate file type and size before moving
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxFileSize = 2 * 1024 * 1024; // 2 MB

               if (in_array($uploadFile["type"], $allowedTypes) && $uploadFile["size"] <= $maxFileSize) {
    if (move_uploaded_file($tempname, $folder)) {
        // Execute the statement
        mysqli_stmt_execute($insertUserStatement);

        // Send a JSON success response
        die(json_encode(['status' => 'success', 'message' => 'User Registration Completed.']));
    } else {
        // Send a JSON error response with the specific message for move_uploaded_file failure
        die(json_encode(['status' => 'error', 'message' => 'Error moving uploaded file.']));
    }
} else {
    // Send a JSON error response with the specific message for invalid file type or size
    die(json_encode(['status' => 'error', 'message' => 'Invalid file type or size.']));
}
            } else {
                // Send a JSON error response
                die(json_encode(['status' => 'error', 'message' => 'Error uploading profile image.']));
            }
        } else {
            // Send a JSON error response
            die(json_encode(['status' => 'error', 'message' => 'No file uploaded.']));
        }

        mysqli_stmt_close($insertUserStatement);
    } else {
        // Send a JSON error response
        die(json_encode(['status' => 'error', 'message' => 'Sorry, Username Already Exists.']));
    }
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Student Konnect</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <script src="axios.min.js"></script>
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Student Konnect</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate method="post" id="registrationForm" enctype="multipart/form-data">
                    <div class="col-12">
                      <label for="profile" class="form-label">Your Profile Picture</label>
                      <input type="file" class="form-control" name="uploadfile" id="profile" required>
                      <div class="invalid-feedback">Please, enter an image less than 2mb</div>
                    </div>
                    <div class="col-12">
                        <label for="yourName" class="form-label">Your Name</label>
                        <input type="text" name="name" class="form-control" id="yourName" required>
                        <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                        <label for="yourEmail" class="form-label">Your Email</label>
                        <input type="email" name="email" class="form-control" id="yourEmail" required>
                        <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" name="username" class="form-control" id="yourUsername" required>
                            <div class="invalid-feedback">Please choose a username.</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                        <input class="btn btn-primary w-100" name="signup" type="submit" value= "Sign Up" />
                    </div>
                      <div class="col-12">
                        <p class="small mb-0">
                          Already have an account?
                          <a href="login.php">Click here</a>
                        </p>
                      </div>
                </form>

                </div>
              </div>

              
            </div>
          </div>
        </div>
      </section>
    </div>
  </main><!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

 <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->

<!-- Sweet alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault();

    // Perform form validation
    var name = document.getElementById("yourName").value;
    var email = document.getElementById("yourEmail").value;
    var username = document.getElementById("yourUsername").value;
    var password = document.getElementById("yourPassword").value;
    var profile = document.getElementById("profile");

    // Validate email format
    var emailRegex = /^\S+@\S+\.\S+$/;
    if (!emailRegex.test(email)) {
        // Display a SweetAlert error message for an invalid email format
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please enter a valid email address!',
        });
        return;
    }

    if (!name || !email || !username || !password || !profile.value ) {
        // Display a SweetAlert error message for incomplete or incorrect form data
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in all the fields ',
        });
    } else {
// console.log(profile);
      
        // Assume your PHP script is saved in signup.php
        var url = 'signup.php';
        let formdata = new FormData();
        formdata.append("signup",'1');
        formdata.append("name", name);
        formdata.append("email",email);
        formdata.append("username", username);
        formdata.append("password",password);
        formdata.append("uploadfile",profile.files[0]);

        axios({
            url,
            method: 'POST',
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            data: formdata
        })
        .then(response => {
          console.log(response);
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.data.message,
                }).then(() => {
                    window.location.href = 'login.php';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.data.message,
                });
            }
        })
        .catch(error => {
    console.error('Error:', error);

    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: error.response ? error.response.data.message : 'An error occurred while processing your request.',
    });
});


            }
});

</script> 


</body>
</html>