<?php
// ob_start();
require_once "php/header.php";
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-3">
            <?php if($verified == 'Verified!'): ?>
                <div class="card border-primary">
                    <div class="card-header lead text-center bg-primary text-white">Send Feedback To Admit!</div>
                    <div class="card-body">
                        <form action="#" method="post" class="px-4" id="feedback-form">

                            <div class="form-group">
                                <input type="text" name="subject" placeholder="Write Your Subject"
                                class="form-control-lg form-control rounder-0" required>
                            </div>

                            <div class="form-group">
                                <textarea name="feedback" class="form-control-lg form-control rounder-0" placeholder="Write Feedback Here..." required rows="8"></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="feedbackBtn" id="feedbackBtn" value="Send Feedback"
                                class="btn btn-primary btn-block btn-lg rounded-0">
                            </div>

                        </form>
                    </div>
                </div>

                <?php else: ?>
                <h1 class="text-center text-secondaty mt-5">Verify Your Email First To Send Feedback To Admin!</h1>
                <?php endif; ?>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>


<script type="text/javascript">
    $(document).ready(function()
    {

        // Send Feedback To Admin Ajax Request
        $("#feedbackBtn").click(function(e)
        {
            if ($("#feedback-form")[0].checkValidity())
            {
                e.preventDefault();

                $(this).val("Please Wait...");

                $.ajax(
                    {
                        url: './php/process.php',
                        method: 'post',
                        data: $('#feedback-form').serialize() + '&action=feedback',
                        success: function(response)
                        {
                            $("#feedback-form")[0].reset();
                            $("#feedbackBtn").val("Send Feedback");
                            swal.fire(
                                {
                                    title: 'Feedback Successfuly Send To The Admin!',
                                    type: 'success',
                                }
                            )
                        }
                    }
                )
                
            }
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