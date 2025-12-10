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
      //echo "Connected successfully to the database";
    } catch(PDOException $e) {
      //echo "Connection to the database failed: " . $e->getMessage();
    } 

    if(isset($_POST['login'])){
        //check if username exists by counting the users with that username
        $stmt = $conn->prepare("SELECT COUNT(*) AS `total` FROM users WHERE username=?");
        $stmt->execute([$_POST['username']]);
        $exists = $stmt->fetchObject();
        //add new user to database
        if($exists->total == 1){
            $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
            $stmt->execute([$_POST['username']]);
            $user = $stmt->fetch();
            if($_POST['password'] == $user['password']){
                echo "Logged in as ".$_POST['username'];
                $_SESSION['user'] = $_POST['username'];      
            }else{
                echo "Incorrect Password";
            }
        }else{
            echo "account ".$_POST['username']." does not exist";   
        }
    }
    
    //plug an array in as the first argument in var_exports to print the whole array. Useful for things like $_POST, $_SESSION and database query results
    //echo '<pre>' . var_export($rows, return: true) . '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Reviewers</title>
    <link rel="stylesheet" href="style.css">
    <style>
        nav {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }
    </style>


</head>
<body>
    <header>
        <nav>
               <a href="index.php">Home</a>
               <a href="search.php">Search</a>
               <a href="savedGames.php">Saved Games</a>
               <a href="newGame.php">Post New Game</a>
               <?PHP
                if(isset($_SESSION['user']))                    
                    echo "<a href='login.html'>".$_SESSION['user']."</a>";
                else                    
                    echo "<a href='login.html'>Login</a>";
               ?>
               <a href="register.html">Sign Up</a> 
        </nav>
    </header>

    <main>
        <section id="home">
            <h1>Welcome to Game Reviewers</h1>
            <p>Your source for honest game reviews and ratings.</p>
        </section>

        <section id="searchGame">
            <form>
                Criteria for game search here!<br>
            <input type="submit" name="searchCriteria" value="Search">
            </form>
            Games here!
        </section>
    </main>

    <br>
    <form action="index.php" method="POST">
    <input type="submit" name="logout" value="Logout"></input>
    </form>
    <footer>
        <p>&copy; 2025 Game Reviewers. All rights reserved.</p>
    </footer>
</body>
</html>