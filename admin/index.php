<?php
session_start();
if (isset($_SESSION['username']))
{
    header("location: admin-dashboard.php");  
    exit();  
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <title>Login | Admin</title>
    <!-- Bootstrap 4 CSS CDN -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <!-- Fontawesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css" />
    <style type="text/css">
        html, body{
            height: 100%;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-5">
                <div class="card border-danger show-lg">
                    <div class="card-header bg-danger">
                        <h3 class="m-0 text-white"><i class="fas fa-user-cog">&nbsp;Admin Panel Login</i> </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="px-3" id="admin-login-form">
                            <div id="adminLoginAlert"></div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-lg rounded-0" placeholder="Username" required autofocus >
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-lg rounded-0" placeholder="Password" required >
                            </div>

                            <div class="form-group">
                                <input type="submit" name="admin-login" class="btn btn-danger btn-block btn-lg rounded-0" value="Login" id="adminLoginBtn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>


    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#adminLoginBtn").click(function(e)
            {
                if($("#admin-login-form")[0].checkValidity())
                {
                    e.preventDefault();

                    $(this).val('please wait...');
                    $.ajax(
                        {
                            url: 'assets/php/admin-action.php',
                            method: 'post',
                            data: $("#admin-login-form").serialize() + "&action=adminLogin",
                            success: function(response)
                            {
                                if (response === 'admin_login')
                                {
                                    window.location = "admin-dashboard.php";    
                                }else{
                                    $("#adminLoginAlert").html(response);
                                    $("#adminLoginBtn").val('Login');
                                }
                            }
                        }
                    )
                }
            })
        })
    </script>
</body>

</html>