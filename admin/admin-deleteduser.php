<?php
require_once "assets/php/admin-header.php";
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card my-2 border-danger">
            <div class="card-header bg-danger text-white">
                <h4 class="m">Total Deleted Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllDeletedUsers">
                    <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
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
    $(document).ready(function () {
        // Fetch All Deleted Users Ajax Request
        fetchAllDeletedUsers();
        function fetchAllDeletedUsers() {
            $.ajax(
                {
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: { action: 'fetchAllDeletedUsers' },
                    success: function (response) {
                        $("#showAllDeletedUsers").html(response);
                        $("table").DataTable(
                            {
                                order: [0, 'desc'],
                            }
                        )
                    }
                }
            )
        }

        // Restor Deleted User Ajax Request
        $("body").on("click", ".restorUserIcon", function (e) {
            e.preventDefault();
            res_id = $(this).attr('id');
            swal.fire(
                {
                    title: 'Are you shure want restore this user?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmCancelColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restor it!',
                }
            ).then((result) => {
                if (result.value) {
                    $.ajax(
                        {
                            url: 'assets/php/admin-action.php',
                            method: 'post',
                            data: { res_id: res_id },
                            success: function (response) {
                                Swal.fire(
                                    'restored!',
                                    'User restored Successfuly!',
                                    'success',
                                )
                                fetchAllDeletedUsers();
                            }
                        }
                    )
                }
            })

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
    })
</script>
</body>

</html>