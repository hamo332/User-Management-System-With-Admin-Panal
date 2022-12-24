<?php
session_start();
if (!isset($_SESSION['username']))
{
    header("location: ./index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $title = basename($_SERVER['PHP_SELF'], '.php');
    $title = explode('-', $title);
    $title = ucfirst($title[1]);
    ?>
    <title><?=$title ?> | Admin Panel</title>
    <!-- Data-Table CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css"/>
    <!-- Bootstrap 4 CSS CDN -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <!-- Fontawesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css" />
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script type="text/javascript">

        $(document).ready(function()
        {
            $("#open-nav").click(function()
            {
                $(".admin-nav").toggleClass('animate');
                
            })
        })
    </script>
    <style>
        .admin-nav{
            width: 220px;
            min-height: 100vh;
            overflow: hidden;
            background-color: #343a40;
            transition: 0.3s all ease-in-out;
        }
        .admin-link{
            background-color: #343a40;
        }
        .admin-link:hover, .nav-active{
            background-color: #212529;
            text-decoration: none;
        }
        .animate{
            width: 0;
            transition: 0.3s all ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="admin-nav p-0">
                <h4 class="text-light text-center p-2">Admin Panel</h4>

                <div class="list-group list-group-flush">

                    <a href="admin-dashboard.php" class="list-group-item text-light admin-link <?=
                    basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php' ? 'nav-active' : '';
                    ?>"><i class="fas fa-chart-pie"></i>&nbsp;&nbsp;Dashboard</a>
                    

                    <a href="admin-users.php" class="list-group-item text-light admin-link <?=
                    basename($_SERVER['PHP_SELF']) == 'admin-users.php' ? 'nav-active' : '';
                    ?>"><i class="fas fa-user-friends"></i>&nbsp;&nbsp;Users</a>
                    
                    

                    <a href="admin-notes.php" class="list-group-item text-light admin-link <?=
                    basename($_SERVER['PHP_SELF']) == 'admin-notes.php' ? 'nav-active' : '';
                    ?>"><i class="fas fa-sticky-note"></i>&nbsp;&nbsp;Notes</a>
                    
                    

                    <a href="admin-feedback.php" class="list-group-item text-light admin-link <?=
                    basename($_SERVER['PHP_SELF']) == 'admin-feedback.php' ? 'nav-active' : '';
                    ?>"><i class="fas fa-comment"></i>&nbsp;&nbsp;Feedback</a>
                    
                    

                    <a href="admin-notification.php" class="list-group-item text-light admin-link <?=
                    basename($_SERVER['PHP_SELF']) == 'admin-notification.php' ? 'nav-active' : '';
                    ?>"><i class="fas fa-bell"></i>&nbsp;&nbsp;Notification&nbsp;<span id="checkNotification"></span> </a>
                    
                    

                    <a href="admin-deleteduser.php" class="list-group-item text-light admin-link <?=
                    basename($_SERVER['PHP_SELF']) == 'admin-deleteduser.php' ? 'nav-active' : '';
                    ?>"><i class="fas fa-user-slash"></i>&nbsp;&nbsp;Deleted Users</a>
                    
                    

                    <a href="assets/php/admin-action.php?export=excel" class="list-group-item text-light admin-link"><i class="fas fa-table"></i>&nbsp;&nbsp;Export Users</a>
                    
                    

                    <a href="#" class="list-group-item text-light admin-link"><i class="fas fa-id-card"></i>&nbsp;&nbsp;Profile</a>
                    
                    

                    <a href="#" class="list-group-item text-light admin-link"><i class="fas fa-cog"></i>&nbsp;&nbsp;Setting</a>
                    
                </div>
            </div>

            <div class="col">
                <div class="row">
                    <div class="col-lg-12 bg-primary pt-2 justify-content-between d-flex">
                        <a href="#" class="text-white" id="open-nav">
                            <h3><i class="fas fa-bars"></i></h3>
                        </a>

                        <h4 class="text-light"><?=$title?></h4>
                        <a href="assets/php/logout.php" class="text-light mt-1"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                    </div>
                </div>