<?php
// Include the message_box.php file
include 'message.php';

// Define the message

$msg .= 'hello';
$msg .= '<div class="button-container">';
$msg .= '<button onclick="window.location.href=\'another_page.php\'">Click Me</button>';
$msg .= '</div>';

// Call the generateMessageBox() function and pass the message
generateMessageBox($msg);
?>
