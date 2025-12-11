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


    $games = $conn->prepare("SELECT * FROM reviews r, games g WHERE r.game=g.name AND r.reviewer=? ORDER BY releaseDate DESC");
    $games->execute([$_SESSION['user']]);
    $games = $games->fetchAll();

    //plug an array in as the first argument in var_exports to print the whole array. Useful for things like $_POST, $_SESSION and database query results
    //echo '<pre>' . var_export($rows, return: true) . '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Reviewers</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <header>
        <section id="savedGamesWelcome">
            <h1>Posted Game Reviews</h1>
            <p>View all of your Reviews!</p>
        </section>
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
        <section id="reviews">
            <?PHP 
            foreach($games as $g){
                //get avg score  
                $avg = $conn->prepare("
                SELECT AVG(score) AS `avgScore`
                FROM reviews
                WHERE game=?
                ");    
                $avg->execute([$g['name']]);                
                $avg = $avg->fetchObject();                
                //get rev amt
                $reviewAMT = $conn->prepare("
                SELECT COUNT(*) AS `total` 
                FROM reviews 
                WHERE game=?");
                $reviewAMT->execute([$g['name']]);
                $reviewAMT = $reviewAMT->fetchObject();
                //print game              
                printGame($g,$reviewAMT->total,$avg->avgScore);                
            }
            ?>
        </section>
    </main>

    <br>
    <footer>
        <form action="index.php" method="POST">
            <input type="submit" name="logout" value="Logout"></input>
        </form>
    </footer>
</body>
</html>