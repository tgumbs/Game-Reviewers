<?PHP
    session_start();
    //report errors
    error_reporting(E_ALL);
    ini_set('display_errors',1);  

    //connect to the database 
    try {
      $conn = new PDO("sqlite:gameReview.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully to the database";
    } catch(PDOException $e) {
      echo "Connection to the database failed: " . $e->getMessage();
    }  

    //check if username exists by counting the users with that username
    $exists = $conn->prepare("SELECT COUNT(*) AS `total` FROM users WHERE username=?");
    $exists->execute([$_POST['username']]);
    $exists = $exists->fetchObject();
    //add new user to database
    if($exists->total == 0){
        $stmt = $conn->prepare("INSERT INTO users (
        username,
        password
        ) 
        VALUES (?,?)");
        $stmt->execute([
            $_POST['username'],
            $_POST['password']
        ]);  
        echo "<h1> successfully added ".$_POST['username']." to users.</h1>";      
    }else{
        echo "<h1>".$_POST['username']." already exists.</h1>";   
    }

    //plug an array in as the first argument in var_exports to print the whole array. Useful for things like $_POST, $_SESSION and database query results
    //echo '<pre>' . var_export($rows, return: true) . '</pre>';
?>

<a href="login.html">Click here to go back to login</a>