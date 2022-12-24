<?php
require_once "session.php";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
// End Require PHPMailer

// Handle Add New Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'add_note')
{
    $title = $cuser->test_input($_POST['title']);
    $note = $cuser->test_input($_POST['note']);

    $cuser->add_new_note($cid, $title, $note);

    // Insert Note To Notification Table
    $cuser->notidicatoin($cid, 'admin', 'New Note Added');
}

// Handle Display All Notes Of An User
if (isset($_POST['action']) && $_POST['action'] == 'display_notes')
{
    $output = '';
    $notes = $cuser->get_notes($cid);
    if ($notes)
    {
        $output .= '<table class="table table-striped text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead><tbody>';
        // substr($row['note'], 0, 75) 
        foreach ($notes as $row)
        {
                $output .= '
                <tr>
                    <td>'. $row['id'] . '</td>
                    <td>'. $row['title'] .'</td>
                    <td>'. $row['note'] .'</td>
                    <td>
                        <a href="#" id="'. $row['id'] .'" title="View Details" class="text-success infoBtn">
                            <i class="fas fa-info-circle fa-ls"></i>&nbsp;
                        </a>

                        <a href="#" id="'. $row['id'] .'" title="Edit Note" class="text-primary editBtn">
                            <i class="fas fa-edit fa-ls" data-toggle="modal"
                                data-target="#editNoteModal"></i>&nbsp;
                        </a>

                        <a href="#" id="'. $row['id'] .'" title="Delete Details" class="text-danger deleteBtn">
                            <i class="fas fa-trash-alt fa-ls"></i>
                        </a>
                    </td>
                </tr>';
        }
        $output .= '</tbody>
            </table>';
        echo $output;
    }
    else
    {
        echo '<h3 class="text-center text-secondary">:( You have no written any note yet! Write your note now</h3>';
    }
}

// Handle Edite Note Of User Ajax Request
if (isset($_POST['edit_id']))
{
    $id = $_POST['edit_id'];

    $row = $cuser->edit_note($id);
    echo json_encode($row);
}

// Handle Update Note Of An User Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'update_note')
{
    $id = $cuser->test_input($_POST['id']);
    $title = $cuser->test_input($_POST['title']);
    $note = $cuser->test_input($_POST['note']);

    $cuser->update_note($id, $title, $note);

    // Insert Note To Notification Table
    $cuser->notidicatoin($cid, 'admin', 'Note Updated');
}

// Handle Delete Note Of An User Ajax Request
if (isset($_POST['del_id']))
{
    $id = $_POST['del_id'];
    
    $cuser->delete_note($id);
    // Insert Note To Notification Table
    $cuser->notidicatoin($cid, 'admin', 'Note deleted');
}

// Handle Display a Note of An User Ajax Request
if (isset($_POST['info_id']))
{
    $id = $_POST['info_id'];
    
    $row = $cuser->edit_note($id);

    echo json_encode($row);
}

// Handle Profile Update Ajax Request
if (isset($_FILES['image']))
{
    print_r($_FILES['image']);
    $name = $cuser->test_input($_POST['name']);
    $gender = $cuser->test_input($_POST['gender']);
    $dob = $cuser->test_input($_POST['dob']);
    $phone = $cuser->test_input($_POST['phone']);

    $oldImage = $_POST['oldimage'];
    $folder = 'uploads/';

    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
    {
        $newImage = $folder . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

        if ($oldImage != null)
        {
            unlink($oldImage);    
        }
    }
    else
    {
        $newImage = $oldImage;
    }
    $cuser->update_profile($name, $gender, $dob, $phone, $newImage, $cid);
        // Insert Note To Notification Table
        $cuser->notidicatoin($cid, 'admin', 'Profile update');
}

// Handle Change Password Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'change_pass')
{
    $currentPass = $_POST['curpass'];    
    $newPass = $_POST['newpass'];    
    $cnewPass = $_POST['cnewpass'];    

    $hnewPass = password_hash($newPass, PASSWORD_DEFAULT);

    if ($newPass != $cnewPass)
    {
        echo $cuser->showMessage('danger', 'Password did not matched!');    
    }else
    {
        if (password_verify($currentPass, $cpass))
        {
            $cuser->change_password($hnewPass, $cid);
            echo $cuser->showMessage('success', 'Password Changed Successfuly!');
        }
        else
        {
            echo $cuser->showMessage('danger', 'Current Password Is Wrong');
            // Insert Note To Notification Table
            $cuser->notidicatoin($cid, 'admin', 'Password Changed');
            
        }
    }
}

// Handle Verify E-Mail Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'verify_email')
{
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = Database::USERNAME;                     //SMTP username
        $mail->Password   = Database::PASSWORD;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom(Database::USERNAME, 'Mailer');
        $mail->addAddress($cemail, 'Mohamed Ahmad');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'E-Mail Verification';
        $mail->Body    = '<h3>Click The below link to Verify your E-Mali.</br>
            <a href="http://localhost/projects/user-project/assets/verify-email.php?email='. $cemail . '">http://localhost/projects/user-project/reset-pass.php?email='. $cemail . '</a>
            <br>Regards<br><i style="font-family:Comic Sans MS,Garamond; color:#155724;">Water Media</i></h3>';
        $mail->send();
                echo $cuser->showMessage('success', "Verification Send To Your E-Mail.
                Please Check Your E-Mail!");

    } catch (Exception $e) {
        echo $cuser->showMessage('danger', "something went weong please try again later!");
    }
}

// Handel Send Feedback To Admon Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'feedback')
{
    $subject = $cuser->test_input($_POST['subject']);
    $feedback = $cuser->test_input($_POST['feedback']);

    $cuser->send_feedback($subject, $feedback, $cid);
    // Insert Note To Notification Table
    $cuser->notidicatoin($cid, 'admin', 'Feedback Writen');
}


// Handle Fetch Notificaton fetchNotification
if (isset($_POST['action']) && $_POST['action'] == 'fetchNotification')
{
    $notification = $cuser->fetchNotification($cid);
    $output = "";
    if($notification)
    {
        foreach ($notification as $row)
        {
            $output .= '
                <div class="alert alert-danger" rol="alert">
                    <button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"> &times;</span>
                    </button>
                    <h4 class="alert-heading">New Notofication</h4>
                    <p class="mb-0 lead">'.$row['message'].'</p>
                    <hr class="my-2">
                    <p class="mb-0 float-left">Reply of feedback from Admin</p>
                    <p class="mb-0 float-right">'.$cuser->timeInAgo($row['created_at']).'</p>
                    <div class="clearfix"></div>
                </div>
                ';
        }
        echo $output;
    }else
    {
        echo '<h3 class="text-center text-secondary mt-5">No any new notification</h3>';
    }
}

    // check notificatoin
if (isset($_POST['action']) && $_POST['action'] == 'checkNotification')
{
    if ($cuser->fetchNotification($cid))
    {
        echo '<i class="fas fa-circle fa-sm text-danger"></i>';    
    }else {
        echo '';
    }
}


// remove notification
if (isset($_POST['notification_id']))
{
    $id = $_POST['notification_id'];
    $cuser->removeNotification($id);  
}
?>