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


    if(isset($_POST['postNewGame'])){
        $exists = $conn->prepare("SELECT COUNT(*) AS `total` FROM games WHERE name=?");
        $exists->execute([$_POST['gameName']]);
        $exists = $exists->fetchObject();    
        if($exists->total == 0){
            $location = './gamePhotos/'.$_POST['gameName'].'.JPEG';
            move_uploaded_file($_FILES['photo']['tmp_name'],$location);

            $newGame = $conn->prepare("INSERT INTO games (
            name,
            bio,
            picture,
            releaseDate
            )
            VALUES (?,?,?,?)");
            $newGame->execute([
                $_POST['gameName'],
                $_POST['bio'],
                $location,
                $_POST['releaseDate'],
            ]);
            echo $_POST['gameName']." was added to games";
        }else{
            echo "Game has already been posted";
        }     
    }
    //plug an array in as the first argument in var_exports to print the whole array. Useful for things like $_POST, $_SESSION and database query results
    //echo '<pre>' . var_export($_FILES, return: true) . '</pre>';
    //echo '<pre>' . var_export($_POST, return: true) . '</pre>';
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
        <h1>Welcome to Game Reviewers</h1>
        <p>Your source for honest game reviews and ratings.</p>
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
        <section id="postNewGame">
            <h2>Post a New Game</h2>
            <form action="newGame.php" method="POST" enctype="multipart/form-data">

                <label for="gameName">Game Name:</label>
                <input type="text" name="gameName" maxlength="64" required><br>

                <label for="bio">Bio:</label><br>
                <textarea name="bio" maxlength="2000" rows="4" cols="50"></textarea><br>

                <label for="releaseDate">Release Date:</label>
                <input type="date" name="releaseDate" maxlength="16" required><br>

                <label for="photo">Photo (only JPEGs):</label>
                <input type="file" name="photo" accept=".JPEG,.jpg" value=""><br>

                <input type="submit" name="postNewGame" value="Post New Game">

            </form>
        </section>
    </main>
    <script src="scripts.js"></script>
    <footer>
        <form action="index.php" method="POST">
            <input type="submit" name="logout" value="Logout"></input>
        </form>
    </footer>
</body>
</html>