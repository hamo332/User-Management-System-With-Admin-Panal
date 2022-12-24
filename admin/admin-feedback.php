<?php
require_once "assets/php/admin-header.php";
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card my-2 border-warning">
            <div class="card-header bg-warning text-white">
                <h4 class="m">Total Feedback From Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllFeedback">
                    <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply Feedback Modal -->
    <div class="modal fade" id="showReplyModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reply This Fedback</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="px-3" id="feedback-reply-form">
                        <div class="form-group">
                            <textarea name="message" id="message" rows="6" class="form-control"
                            placeholder="Wite your message here..." required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Send Reply"
                            class="btn btn-primary btn-block" id ="feedbackReplyBtn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>    


<script type="text/javascript">
    $(document).ready(function()
    {
        // Fetch All Feedback Of Users Ajax Request
    fetchAllFeedback();
    function fetchAllFeedback()
    {
        $.ajax(
        {
            url: 'assets/php/admin-action.php',
            method: 'post',
            data: {action: 'fetchAllFeedback'},
            success: function(response)
            {
                $("#showAllFeedback").html(response);
                $("table").DataTable(
                    {
                        order: [0, 'desc'],
                    }
                )
            }
        }
    )
    }

    // Get The Current Row User ID And Feedback ID
    var uid;
    var fid;
    $("body").on("click",".replyFeedbackIcon", function(e)
    {
        uid = $(this).attr('id');
        fid = $(this).attr('fid');
    });

    // Send FeedBack Reply To the user ajax request
    $("#feedbackReplyBtn").click(function(e)
    {
        if ($("#feedback-reply-form")[0].checkValidity())
        {
            let message = $("#message").val();
            e.preventDefault();
            $("#feedbackReplyBtn").val('Please Wait...');
            
            $.ajax(
                {
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {uid: uid, message: message, fid: fid},
                    success: function(response)
                    {
                        fetchAllFeedback();
                        $("#feedbackReplyBtn").val('Send Reply');
                        $("#feedback-reply-form")[0].reset();
                        Swal.fire(
                            'Sent!',
                            'Reply send successfuly to the user!',
                            'success',
                        );
                        console.log(response);
                    }
                }
            )
        }
    })
// check Notification
checkNotification();
        
        function checkNotification()
        {
            $.ajax(
                {
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {action: 'checkNotification'},
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