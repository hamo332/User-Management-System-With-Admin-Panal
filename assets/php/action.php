<?php
session_start();
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
require_once "auth.php";
$user = new Auth();
// Handle Register Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'register')
{
    $name = $user->test_input($_POST['name']);
    $email = $user->test_input($_POST['email']);
    $pass = $user->test_input($_POST['password']);

    $hpass = password_hash($pass, PASSWORD_DEFAULT);

    if($user->user_exist($email))
    {
        echo $user->showMessage('warning', 'This E-Mail is already registered!');
    }
    else
    {
        if($user->register($name,$email,$hpass))
        {
            echo "register";
            $_SESSION['user'] = $email;

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
                $mail->addAddress($email, 'Mohamed Ahmad');     //Add a recipient
        
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'E-Mail Verification';
                $mail->Body    = '<h3>Click The below link to Verify your E-Mali.</br>
                    <a href="http://localhost/projects/user-project/assets/verify-email.php?email='. $email . '">http://localhost/projects/user-project/reset-pass.php?email='. $email . '</a>
                    <br>Regards<br><i style="font-family:Comic Sans MS,Garamond; color:#155724;">Water Media</i></h3>';
                $mail->send();
                        echo $cuser->showMessage('success', "Verification Send To Your E-Mail.
                        Please Check Your E-Mail!");
        
            } catch (Exception $e) {
                echo $cuser->showMessage('danger', "something went weong please try again later!");
            }
        }
        else
        {
            $user->showMessage("danger", "Something went wrong! try again later...");
        }
    }
}
// Handle Login Ajax Request
if (isset($_POST['action']) && $_POST['action'] == "login")
{
      $email = $user->test_input($_POST['email']);
      $pass = $user->test_input($_POST['password']);

      $loggedInUser = $user->login($email);

      if ($loggedInUser != null)
      {
        if (password_verify($pass, $loggedInUser['password']))
        {
            if (!empty($_POST['rem']))
            {
                setcookie("email",$email, time()+(30*24*60*60), '/');
                setcookie("password",$pass, time()+(30*24*60*60), '/');
            }
            else
            {
                setcookie("email", "", 1, "/");
                setcookie("password", "", 1, "/");
            }
            echo "login";
            $_SESSION['user'] = $email;
        }
        else
        {
            echo $user->showMessage("danger", "Password is incorrect!");
        }
    }
    else
    {
    echo $user->showMessage("danger", "User not found");        
    }
}

// Handle forgot Password Ajax Request
if (isset($_POST['action']) && $_POST['action'] == "forgot")
{
    $email = $user->test_input($_POST['email']);

    $user_found = $user->currentUser($email);

    if ($user_found != null)
    {
        $token = uniqid();
        $token = str_shuffle($token);

        $user->forgot_password($token, $email);
        try {
            //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $user::USERNAME;                     //SMTP username
    $mail->Password   = $user::PASSWORD;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom(Database::USERNAME, 'Mailer');
    $mail->addAddress("$email", 'Mohamed Ahmad');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Password';
    $mail->Body    = '<h3>Click The below link to reset you password.</br>
        <a href="http://localhost/projects/user-project/assets/reset-pass.php?email='. $email . '&token=' . $token . '">http://localhost/projects/user-project/reset-pass.php?email='. $email . '&token=' . $token . '</a>
        <br>Regards<br>Water Media</h3>';
    $mail->send();
            echo $user->showMessage('success', "We have send you the reset link in your e-mail ID, please check your e-mail!");

        } catch (Exception $e) {
            echo $user->showMessage('danger', "something went weong please try again later!");
        }
    }
    else
    {
        echo $user->showMessage("info", "THis e-mail is not register");
    }
}

// Checking User is logged in or not
if (isset($_POST['action']) && $_POST['action'] == 'checkUser')
{
    if (!$user->currentUser($_SESSION['user']))
    {
        echo 'bye';
        unset($_SESSION['user']);    
    }
}
?>