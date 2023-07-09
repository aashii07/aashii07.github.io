<!DOCTYPE html>
<html>
  
<head>
  <style>
    body {
        background-image: url(../../gallery/bg.jpg);
        background-repeat: repeat;
        font-family: Arial, Helvetica, sans-serif;
    }
    /* Style for the message box */
    .message {
      width: 400px;
      padding: 20px;
      background-color: rgb(150, 200, 200);
      border-radius: 10px;
      position: relative;
      margin: 50px auto;
      margin-top: 200px;
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
      color: #595E60;
      font-size: 16px;
      line-height: 1.4;
    }

    .button-container {
      text-align: right;
      margin-top: 20px;
      margin-right: 20px;
    }

    .button-container button {
      align-items: center;
      background-image: linear-gradient(45deg,red, teal);
      border: 0;
      border-radius: 8px;
      box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
      box-sizing: border-box;
      color: #FFFFFF;
      display: flex;
      font-family: Phantomsans, sans-serif;
      font-size: 16px; /* Updated font size */
      justify-content: center;
      line-height: 1em;
      width: 120px; /* Updated width */
      padding: 2.5px; /* Updated padding */
      text-decoration: none;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      white-space: nowrap;
      cursor: pointer;
      margin-left: 260px;
      margin-top: 30px;
    }

    .button-container button:hover,
    .button-container button:active {
      outline: 0;
    }

    .button-container button span{
      background-color: rgb(5, 6, 45);
      padding: 12px; /* Updated padding */
      border-radius: 6px;
      width: 100px;
      height: 20px;
      transition: 300ms;
    }

    .button-container button:hover span{
      background: none;
    }

    hr{
        background-image: linear-gradient(to right, red, teal); /* Replace "red" and "blue" with your desired colors */
        height: 2px; /* Adjust the height of the hr element as needed */
        border: none;
    }
  </style>
</head>
<body>
  <?php
  function generateMessageBox($msg) {
    echo '<div class="message">';
    echo '<p>' . $msg . '</p>';
    echo '</div>';
  }
  ?>

 
</body>
<title>MedRush</title>
</html>
