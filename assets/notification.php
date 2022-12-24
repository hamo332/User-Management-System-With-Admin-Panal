<?php
require_once "php/header.php";
?>

    <div class="container">
        <div class="row justify-content-center my-2">
            <div class="col-lg-6 mt-4" id="showAllNotification">
                
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function()
        {
            // Fetch Notification of an User
            fetchNotification();
            function fetchNotification()
            {
                $.ajax(
                    {
                        url: './php/process.php',
                        method: 'post',
                        data: {action: 'fetchNotification',},
                        success: function(response)
                        {
                            $("#showAllNotification").html(response);
                        }

                    }
                )

            }

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

            
            // remove notification
            $("body").on("click", ".close", function(e)
            {
                e.preventDefault();
                notification_id = $(this).attr('id');

                $.ajax(
                    {
                        url: 'php/process.php',
                        method: 'post',
                        data: {notification_id: notification_id},
                        success: function(response)
                        {
                            checkNotification();
                            fetchNotification();
                        }
                    }
                )
            })
        })
    </script>
</body>

</html>