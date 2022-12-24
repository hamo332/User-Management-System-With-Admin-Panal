<?php
require_once "php/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php
                    if ($verified == 'Not Verified!'): ?>
            <div class="alert alert-danger alert-dismissible 
                            text-center mt-2 m-0">
                <button class="close" type="button" data-dismiss="alert">&times;</button>
                <strong>Yor E-mail is not verified! We have send you an E-mail
                    Verfication link on your E-mail. Check & verify now!
                </strong>
            </div>
            <?php endif; ?>
            <h4 class="text-center text-primary
                        mt-2">Write Your Notes Here & Access Anytime Anywhere!</h4>
        </div>
    </div>
    <div class="card border-primary">
        <h5 class="card-header bg-primary d-flex justify-content-between">
            <span class="text-light lead align-self-center">All Notes</span>
            <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addNoteModal">
                <i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add New Notes
            </a>
        </h5>
        <div class="card-body">
            <div class="table-responsive" id="showNote">
                <p class="text-center mt-5"> Please Wait...</p>
            </div>
        </div>
    </div>
</div>

<!-- Start Add New Note Modal -->
<div class="modal fade" id="addNoteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title text-light">Add New Note</h4>
                <button class="close text-light" type="button" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="add-note-form" class="px-3">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control
                        form-control-lg" placeholder="Enter Title" require>
                    </div>
                    <div class="form-group">
                        <textarea name="note" class="form-control form-control-lg" placeholder="Write Your Note Here..."
                            rows="6"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" nema="addNote" id="addNoteBtn" value="Add Note"
                            class="btn btn-success btn-block btn-lg">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add New Note Modal -->


<!-- Start Edit Note Modal -->
<div class="modal fade" id="editNoteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light">Edit Note</h4>
                <button class="close text-light" type="button" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="edit-note-form" class="px-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" name="title" id="title" class="form-control
                        form-control-lg" placeholder="Enter Title" require>
                    </div>
                    <div class="form-group">
                        <textarea name="note" id="note" class="form-control form-control-lg"
                            placeholder="Write Your Note Here..." rows="6"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" nema="editNote" id="editNoteBtn" value="Update Note"
                            class="btn btn-info btn-block btn-lg">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Note Modal -->


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>    

<script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
$(document).ready(function() {

    //Add New Note Ajax Rqquest
    $("#addNoteBtn").click(function(e) {
        if ($("#add-note-form")[0].checkValidity()) {
            e.preventDefault();

            $("#addNoteBtn").val('Please Wait...');
            $.ajax({
                url: 'php/process.php',
                method: 'post',
                data: $("#add-note-form").serialize() + "&action=add_note",
                success: function(response) {
                    $("#addNoteBtn").val('Add Note');
                    $("#add-note-form")[0].reset();
                    // $("#addNoteModal").modal('hide');
                    swal.fire(
                        {
                            title: 'Note Added Successfuly',
                            type: 'success',
                        }
                    );
                    displayAllNotes();
                }
            })

        }

    });

    // Edit Note Of An User Ajax Request
    $("body").on("click", ".editBtn", function(e)
    {
        e.preventDefault();
        edit_id = $(this).attr('id');

        $.ajax(
            {
                url: 'php/process.php',
                method: 'post',
                data: {edit_id: edit_id},
                success: function(response)
                {
                    data = JSON.parse(response);
                    $("#id").val(data.id);
                    $("#title").val(data.title);
                    $("#note").val(data.note);
                }
            }
        )
    });

    // Update Note Of An User Ajax Request
    $("#editNoteBtn").click(function(e)
    {
        if ($("#edit-note-form")[0].checkValidity()) {
            e.preventDefault();

            $.ajax({
                url: 'php/process.php',
                method: 'post',
                data: $("#edit-note-form").serialize() + "&action=update_note",
                success: function(response)
                {
                    displayAllNotes();
                    swal.fire(
                        {
                            title: 'Note Updated Successfuly',
                            type: 'success',
                        }
                    );
                    $("#edit-note-form")[0].reset();
                    // $("#editNoteModal").modal('hide'); 
                }
            })

        }

    });

    // Display All Note Of An User
    displayAllNotes();
    function displayAllNotes()
    {
        $.ajax(
            {
                url: 'php/process.php',
                method:'post',
                data: {action: 'display_notes'},
                success: function(response)
                {
                    $("#showNote").html(response);
                    $("table").DataTable(
                        {
                            order: [0, 'desc'],
                        }
                    );
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
    
    // Checking user is login or note
    $.ajax(
        {
            url: 'assets/php/action.php',
            method: 'post',
            data: {action: 'checkUser'},
            success: function(response)
            {
                if (response == 'bye')
                {
                    window.location = 'index.php';    
                }
            }
        }
    )
})
</script>
</body>

</html>