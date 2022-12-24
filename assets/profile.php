<?php
require_once "php/header.php";
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card rounded-0 mt-3 border-primary">
                <div class="card-header border-primary">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Profile</a>
                        </li>

                        <li class="nav-item">
                            <a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab">Edit Profile</a>
                        </li>

                        <li class="nav-item">
                            <a href="#changePass" class="nav-link font-weight-bold" data-toggle="tab">Change
                                Password</a>
                        </li>
                    </ul>
                </div>


                <div class="card-body">
                    <div class="tab-content">
                    <!-- Profile Tab Content Start -->

                    
                        <div class="tab-pane container active" id="profile">
                            <div id="verifyEmailAlert"></div>
                            <div class="card-deck">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-light text-center lead">
                                        User Id : <?= $cid; ?>
                                    </div>
                                    <div class="card-body">

                                        <p class="card-text p-2 m-1 rounder" style="border:1px solid #0275d8">
                                            <b>Name : </b> <?= $cname; ?>
                                        </p>

                                        <p class="card-text p-2 m-1 rounder" style="border:1px solid #0275d8">
                                            <b>E-mail : </b> <?= $cemail; ?>
                                        </p>

                                        <p class="card-text p-2 m-1 rounder" style="border:1px solid #0275d8">
                                            <b>Gender : </b> <?= $cgender; ?>
                                        </p>

                                        <p class="card-text p-2 m-1 rounder" style="border:1px solid #0275d8">
                                            <b>Date Of Birth : </b> <?= $cdob; ?>
                                        </p>

                                        <p class="card-text p-2 m-1 rounder" style="border:1px solid #0275d8">
                                            <b>Phone : </b> <?= $cphone; ?>
                                        </p>

                                        <p class="card-text p-2 m-1 rounder" style="border:1px solid #0275d8">
                                            <b>Regsitered On : </b> <?= $reg_on; ?>
                                        </p>

                                        <p class="card-text p-2 m-1 rounder" style="border:1px solid #0275d8">
                                            <b>E-mail Verified : </b> <?= $verified; ?>

                                            <?php if($verified == 'Not Verified!') : ?>
                                            <a href="#" id="verify-email" class="float-right">Verify Now</a>
                                            <?php endif; ?>
                                        </p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="card border-primary align-self-center">
                                    <?php if(!$cphoto): ?>
                                    <img src="./img/OIP.jpg" class="img-thumbnail img-fluid" width="408px">
                                    <?php  else: ?>
                                    <img src="<?= './php/'. $cphoto; ?>" class="img-thumbnail img-fluid" width="408px"
                                        alt="">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Tab Content End -->
                        <!-- Edit Profile Tab Content Start -->
                        <div class="tab-pane container fade" id="editProfile">
                            <div class="card-deck">
                                <div class="card border-danger align-self-center">
                                    <?php if(!$cphoto): ?>
                                    <img src="./img/OIP.jpg" class="img-thumbnail img-fluid" width="408px">
                                    <?php  else: ?>
                                    <img src="<?= './php/'. $cphoto; ?>" class="img-thumbnail img-fluid" width="408px"
                                        alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="card border-danger">
                                    <form action="" method="post" class="px-3 mt-2" enctype="multipart/form-data"
                                        id="profile-update-form">
                                        <input type="hidden" name="oldimage" value="<?= $cphoto; ?>">
                                        <div class="form-group m-0">
                                            <label for="profilePhoto">Upload Profile Image</label>
                                            <input type="file" name="image" id="profilePhoto">
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="name" class="m-1">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="<?= $cname;?>">
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="gender" class="m-1">Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option disabled <?php if($cgender == null){echo 'selected';} ?>>Select
                                                </option>
                                                <option value="Male" <?php if($cgender == "Male"){echo 'selected';}; ?>>
                                                    Male</option>
                                                <option value="Female"
                                                    <?php if($cgender == "Male"){echo 'selected';}; ?>>Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="dob" class="m-1">Date of Birth</label>
                                            <input type="date" name="dob" id="dob" value="<?= $cdob; ?>"
                                                class="form-control">
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="phone" class="m-1">Phone</label>
                                            <input type="text" name="phone" id="phone" value="<?= $cphone; ?>"
                                                class="form-control" placeholder="Phone">
                                        </div>

                                        <div class="form-group mt-2">
                                            <input type="submit" name="profile_update" value="Update Profile"
                                                class="btn btn-danger btn-block" id="profileUpdateBtn">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Profile Tab Content End -->
                        <!-- Change Password Tab Content Start -->
                        <div class="tab-pane container fade" id="changePass">
                            <div class="card-deck">
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white text-center">
                                        Change Password
                                    </div>
                                    <form action="#" method='post' class="px-3 mt-2">
                                        <div class="form-group">
                                            <label for="curpass">Current Password</label>
                                            <input type="password" name="curpass" placeholder="Current Password"
                                                class="form-control form-control-lg" id="curpass" require minlength="5">
                                        </div>

                                        <div class="form-group">
                                            <label for="newpass">New Password</label>
                                            <input type="password" name="newpass" placeholder="New Password"
                                                class="form-control form-control-lg" id="newpass" require minlength="5">
                                        </div>

                                        <div class="form-group">
                                            <label for="cnewpass">Confirm New Password</label>
                                            <input type="password" name="cnewpass" placeholder="Confirm New Password"
                                                class="form-control form-control-lg" id="cnewpass" require
                                                minlength="5">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" name="changepass" value="Change Password"
                                                class="btn btn-success btn-block btn-lg" id="changePasswordBtn">
                                        </div>
                                    </form>
                                </div>
                                <div class="card border-success align-self-center">
                                    <img src="./img/changepass4.png" class="img-thumbnail img-fluid" width="408">
                                </div>
                            </div>
                        </div>
                        <!-- Change Password Tab Content End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    //profile Update Ajax Request
    $("#profile-update-form").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'php/process.php',
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            data: new FormData(this),
            success: function(response) {
                console.log(response);
            }
        });
    });

    // Verify E-Mail Ajax Request
    $("#verify-email").click(function(e)
    {
        e.preventDefault();
        $(this).text("Please Wait...");

        $.ajax(
            {
                url: 'php/process.php',
                method: 'post',
                data: {action: 'verify_email',},
                success: function(response)
                {
                    $("#verifyEmailAlert").html(response);
                    $("#verify-email").text('Verify Now');
                }
            }
        )
    })

    
            // check notificatoin
            checkNotification();
            function checkNotification()
            {
                $.ajax(
                    {
                        url: 'php/process.php',
                        method: 'post',
                        data: {action:'checkNotification',},
                        success: function(response)
                        {
                            $("#checkNotification").html(response);
                        }
                    }
                )
            }

});
</script>

</body>

</html>