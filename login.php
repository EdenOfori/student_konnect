<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_konnect";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent SQL injection
    $username = $conn->real_escape_string($_POST["username"]);
   $password = $_POST["password"];

    // Prepare and bind the query to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, check password
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"];

         // Compare the entered password with the stored hashed password
        if (password_verify($password, $storedPassword)) {
            // Password is correct
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Login successful']);
            $_SESSION["username"] = $row["username"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["id"] = $row["user_id"];
            // print_r($row);
            // die();



        } else {
            // Incorrect password
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid Password']);
        }
    } else {
        // User not found
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid Username']);
    }

    // Close the database connection
    $conn->close();

    // Stop further execution
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Student Konnect</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />
  </head>

  <body>
    <main>
      <div class="container">
        <section
          class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        >
          <div class="container">
            <div class="row justify-content-center">
              <div
                class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center"
              >
                <div class="d-flex justify-content-center py-4">
                  <a
                    href="index.html"
                    class="logo d-flex align-items-center w-auto"
                  >
                    <img src="assets/img/logo.png" alt="" />
                    <span class="d-none d-lg-block">Student Konnect</span>
                  </a>
                </div>
                <!-- End Logo -->
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">
                        Login to Your Account
                      </h5>
                      <p class="text-center small">
                        Enter your username & password to login
                      </p>
                    </div>

                    <form class="row g-3 needs-validation"  novalidate method="post" id="signinForm"> 
                      <div class="col-12">
                        <label for="yourUsername" class="form-label"
                          >Username</label
                        >
                        <div class="input-group has-validation">
                          <span class="input-group-text" id="inputGroupPrepend"
                            >@</span
                          >
                          <input
                            type="text"
                            name="username"
                            class="form-control"
                            id="yourUsername"
                            required
                          />
                          <div class="invalid-feedback">
                            Please enter your username.
                          </div>
                        </div>
                      </div>

                      <div class="col-12">
                        <label for="yourPassword" class="form-label"
                          >Password</label
                        >
                        <input
                          type="password"
                          name="password"
                          class="form-control"
                          id="yourPassword"
                          required />
                        <div class="invalid-feedback">
                          Please enter your password!
                        </div>
                      </div>

                      
                      <div class="col-12">
                        <input class="btn btn-primary w-100" name="signin" type="submit" value= "Login" />
                    </div>
                    
                      <div class="col-12">
                        <p class="small mb-0">
                          Don't have an account?
                          <a href="signup.php">Create an account</a>
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
    </main>
    <!-- End #main -->

    <a
      href="#"
      class="back-to-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

   
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById("signinForm").addEventListener("submit", function(event) {
    event.preventDefault();

    // Perform form validation
    var username = document.getElementById("yourUsername").value;
    var password = document.getElementById("yourPassword").value;

    if (!username || !password) {
        // Display a SweetAlert error message for incomplete or incorrect form data
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in all the fields',
        });
    } else {
        // If all validation checks pass, proceed with form submission
        // Assume your PHP script is saved in login.php
        var url = 'login.php';
        
        // Create a FormData object and append form data
        let formData = new FormData();
        formData.append("signin", '2');
        formData.append("username", username);
        formData.append("password", password);

        // Use Axios for the request
        axios({
            url: url,
            method: 'POST',
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            data: formData
        })
        .then(response => {
            if (response.data.status === 'success') {
                // Display a SweetAlert success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Login successful',
                }).then(() => {
                    window.location.href = 'home.php';
                });
            } else {
                // Display a SweetAlert error message based on the error message received
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.data.message,
                });
            }
        })
        .catch(error => {
            // Display a SweetAlert error message
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred while processing your request.',
            });
        });
    }
});
</script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <!-- <script src="axios.min.js"></script> -->
  </body>
</html>
