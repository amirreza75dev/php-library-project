<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title><?php echo $title; ?></title>
    <?php
          session_start();
          if(isset($_SESSION['clientId']) || isset($_SESSION['employeeId'])){
    ?>
            <button id="log-out-btn">Log Out</button>
    <?php
          }
     ?>
    
</head>
<body>