<?php
require_once "assets/php/admin-header.php";
?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card my-2 border-secondary">
                <div class="card-header bg-secondary text-white">
                    <h4 class="m">Total Notes By All Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="showAllNotes">
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
    $(document).ready(function()
    {
        // Fetch All Notes Ajax Request
    fetchAllNotes();
    function fetchAllNotes()
    {
        $.ajax(
        {
            url: 'assets/php/admin-action.php',
            method: 'post',
            data: {action: 'fetchAllNotes'},
            success: function(response)
            {
                $("#showAllNotes").html(response);
                $("table").DataTable(
                    {
                        order: [0, 'desc'],
                    }
                )
            }
        }
    )
    }

    // Delete Note Ajax Request
    $("body").on("click",".deleteNoteIcon", function(e)
    {
        e.preventDefault();
        note_id = $(this).attr('id');
        swal.fire(
            {
                title: 'Are you shure?',
                text: 'You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmCancelColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }
        ).then((result)=>
        {
            if (result.value)
            {
                $.ajax(
                    {
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: {note_id: note_id},
                        success: function(response)
                        {
                            Swal.fire(
                                'Deleted!',
                                'Note deleted Successfuly!',
                                'success',
                            )
                            fetchAllNotes();
                        }
                    }
                )    
            }
        })
        
    });
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
