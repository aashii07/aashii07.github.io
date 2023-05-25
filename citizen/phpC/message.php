<!DOCTYPE html>
<html>
<head>
  <style>
    /* Style for the message box */
    .message {
      width: 400px;
      padding: 20px;
      background-color: #f9f9f9;
      border-radius: 10px;
      position: relative;
      margin: 50px auto;
      margin-top: 20%;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
      color: #aaa;
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 30px;
      font-weight: bolder;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .close:hover {
      color: red;
    }

    h2 {
      margin-top: 0;
      font-size: 25px;
    }

    p {
      color: #666;
      font-size: 16px;
      line-height: 1.4;
    }

    .button-container {
      text-align: right;
      margin-top: 20px;
      margin-right: 20px;
    }

    .button-container button {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      background-color: #0080ff;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
    }

    .button-container button:hover {
      background-color: #0059b3;
    }
  </style>
</head>
<body>
  <?php
  function generateMessageBox($msg) {
    echo '<div class="message">';
    echo '<span class="close" onclick="this.parentElement.style.display=\'none\'">&times;</span>';
    echo '<p>' . $msg . '</p>';
    echo '</div>';
  }
  ?>

 
</body>
</html>
