<?php 
  session_start();

  if (isset($_SESSION['username'])) {
  	# database connection file
  	include 'app/db.conn.php';

  	include 'app/helpers/user.php';
  	include 'app/helpers/conversations.php';
    include 'app/helpers/timeAgo.php';
    include 'app/helpers/last_chat.php';

  	# Getting User data data
  	$user = getUser($_SESSION['username'], $conn);

  	# Getting User conversations
  	$conversations = getConversation($user['user_id'], $conn);
	// print_r($conversations);
  // print_r($user);
// die();

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
    
  


<!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="student.jpg" alt="">
        <span class="d-none d-lg-block">Student Konnect</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

  

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a> -->
        <!-- </li>End Search Icon-->
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

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
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->
          
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="profile/<?=$user['profile_image']?>"  class="rounded-circle">
           
            <span class="d-none d-md-block dropdown-toggle ps-2"><?=$user['name']?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?=$user['name']?></h6>
              <!-- <span>Web Designer</span> -->
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            
            

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
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

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

<li class="nav-heading">Pages</li>

<li class="nav-item">
<a class="nav-link collapsed" href="profile.php">
<i class="ri-account-circle-fill"></i>
<span>Profile</span>
</a>
</li><!-- End Profile Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="courses.php">
<i class="bi bi-menu-button-wide"></i>
<span>Courses</span>
</a>
</li><!-- End Courses Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="notification.php">
<i class="bi bi-bell"></i>
<span>Notifications</span>
</a>
</li><!-- End Notifications Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="friends.php">
<i class="ri-chat-smile-3-line"></i>
<span>Friends</span>
</a>
</li><!-- End Friends Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="home.php">
<i class="ri-admin-line"></i>
<span>Private Chat</span>
</a>
</li><!-- End Contact Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="#">
<i class="ri-wechat-line"></i>
<span>Chat Rooms</span>
</a>
</li><!-- End Register Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="#">
<i class="bi bi-bookmark-plus-fill"></i>
<span>Interests</span>
</a>
</li><!-- End F.A.Q Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="logout.php">
<i class="bi bi-box-arrow-in-left"></i>
<span>Logout</span>
</a>
</li><!-- End Login Page Nav -->
<li class="nav-item">
<a class="nav-link collapsed" href="pages-faq.html">
<i class="bi bi-question-circle"></i>
<span>Help and Support</span>
</a>
</li><!-- End F.A.Q Page Nav -->
</ul>
</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Courses Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active">Courses</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <a href="https://www.udacity.com/school/data-science"><h5 class="card-title">Data Science</h5></a>
              <p>Build expertise in data streaming, business analytics, data visualization, data analysis, data science programming, data engineering, data architecture, predictive analytics, and more. With the skills you learn in our data science courses, you can launch or advance a successful career in the field.</p>
            </div>
          </div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
             <a href="https://www.udacity.com/school/artificial-intelligence"><h5 class="card-title">Artificial Intelligence</h5></a> 
              <p>AI is one of the most transformational and fastest-growing technologies of our time. Our School of Artificial Intelligence offers AI training and machine learning courses as well as programs focusing on deep learning, computer vision, natural language processing, and AI product management.</p>
            </div>
          </div>
          

        </div>
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <a href="https://www.udacity.com/school/programming"><h5 class="card-title">Programming & Development</h5></a>
              <p>Programming is a critical skill in today's digital economy, and there is a shortage of qualified developers. We offer online computer programming courses in development basics, iOS, Android, Java, Javascript, C++, React, Python, front end development, and full stack development.</p>
            </div>
          </div>
          

        </div>
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <a href="https://www.udacity.com/school/cloud-computing"><h5 class="card-title">Cloud Computing</h5></a>
              <p>Today, all companies, big and small, are adopting cloud computing to enable their digital transformation. The growth of this technology has created incredible demand for cloud specialists, from cloud developers and cloud DevOps roles to more specialized roles such as solutions architects and cloud security engineers. Build solutions for Azure, AWS, or hybrid systems.</p>
            </div>
          </div>
          

        </div><div class="col-lg-6">

          <div class="card">
            <div class="card-body">
             <a href="https://www.udacity.com/school/cybersecurity"><h5 class="card-title">Cybersecurity</h5></a> 
              <p>Build expertise in security analysis, security engineering, enterprise security, security architecture, ethical hacking, and data privacy. With the skills you learn in our cybersecurity courses, you can launch or advance a successful career in the field.</p>
            </div>
          </div>
          

        </div>


      </div>
    </section>


  </main><!-- End #main -->



 <a href="#"  class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



</body>
</html>

<?php 
}else {
  header("location: login.php");
  exit;
}
?>