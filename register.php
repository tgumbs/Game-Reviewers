<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);  

$message = ""; // variable to hold status text

try {
    $conn = new PDO("sqlite:gameReview.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $message .= "Connected successfully to the database";
} catch(PDOException $e) {
    $message .= "Connection to the database failed: " . $e->getMessage();
}

$exists = $conn->prepare("SELECT COUNT(*) AS total FROM users WHERE username=?");
$exists->execute([$_POST['username']]);
$exists = $exists->fetchObject();

if($exists->total == 0){
    $stmt = $conn->prepare("INSERT INTO users (username,password) VALUES (?,?)");
    $stmt->execute([$_POST['username'], $_POST['password']]);  
    $message .= "<h1>Successfully added ".$_POST['username']." to users.</h1>";      
}else{
    $message .= "<h1>".$_POST['username']." already exists.</h1>";   
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <section id="registerWelcome">
        <h1><?php echo $message; ?></h1>
    </section>
    <nav>
        <a href="index.php">Home</a>
        <a href="login.html">Click here to go back to login</a>
    </nav>
</header>
</body>
</html>
