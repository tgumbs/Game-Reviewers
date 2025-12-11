<?PHP
    session_start();
    //report errors
    error_reporting(E_ALL);
    ini_set('display_errors',1);  
    include './src/print.php';
    //connect to the database 
    try {
      $conn = new PDO("sqlite:gameReview.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "Connected successfully to the database";
    } catch(PDOException $e) {
      //echo "Connection to the database failed: " . $e->getMessage();
    } 
  
    if(isset($_POST['searchCriteria'])){
        if($_POST['gameName'] == ''){
            $games = $conn->prepare("SELECT * FROM games ORDER BY releaseDate");
            $games->execute([]);
            $games = $games->fetchAll();
        }else{
            $games = $conn->prepare("SELECT * FROM games WHERE name LIKE ? ORDER BY releaseDate des");
            $games->execute(['%'.$_POST['gameName'].'%']);
            $games = $games->fetchAll();
            echo $e->getMessage();            
        }
    }else{
        $games = $conn->prepare("SELECT * FROM games ORDER BY releaseDate");
        $games->execute([]);
        $games = $games->fetchAll();
    }

    //plug an array in as the first argument in var_exports to print the whole array. Useful for things like $_POST, $_SESSION and database query results
    //echo '<pre>' . var_export($_POST, return: true) . '</pre>';
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
            <form action="search.php" method="POST">
                <label for="gameName">Game Name:</label>
                <input type="text" name="gameName" maxlength="64"><br>
            <input type="submit" name="searchCriteria" value="Search">
            </form>
        </section> 

        <section class="reviews">
            <h2>Latest Reviews</h2>
                <?PHP 
                foreach($games as $g)
                    printGame($g);
                ?>
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