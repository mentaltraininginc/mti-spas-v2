<?php
/* Set e-mail recipient */
$myemail  = "mooregraphicdesign@gmail.com, teambucklesfitness@gmail.com";

/* Check all form inputs using check_input function */
$name = check_input($_POST['fname'], "Enter your first name");
$comp = check_input($_POST['lname'], "Enter your last name");
$email = check_input($_POST['email'], "Enter your email address");
$phone = check_input($_POST['phone'], "Enter your phone number");
$goals = check_input($_POST['goals']);
$medhis = check_input($_POST['medhis']);

/* If e-mail is not valid show error message */
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
    show_error("E-mail address not valid");
}

// subject
$subject = 'Team Hero Contact Request';



/* Let's prepare the message for the e-mail */
$message = "Team Hero Contact Request has been submitted by:

Name: $fname $lname
E-mail: $email
Phone: $phone

Fitness Goals:
$goals

Medical History:
$medhis



End of message
";

/* Send the message using mail() function */
mail($myemail, $subject, $message);

/* Redirect visitor to the website */
header('Location: thankyou-team.html');
exit();

/* Functions we used */
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{

?>
    <html>
    <body>

    <b>Please correct the following error:</b><br />
    <?php echo $myError; ?>

    </body>
    </html>
<?php
exit();
}
?>
