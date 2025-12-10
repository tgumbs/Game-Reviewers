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
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        session_start();
    }

    $item = [
    "name" => "Clair Obscur: Expedition 33",
    "image" => "/images/Clair_Obscur.jpg",
    "avg_rating" => 4.5,
    "reviews_count" => 200
];
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
    <section id="home">
        <h1>Welcome to Game Reviewers</h1>
        <p>Your source for honest game reviews and ratings.</p>
    </section>    
    <header>
        <nav>
               <a href="index.php">Home</a>
               <a href="#search">Search</a>
               <a href="#saved_games">Saved Games</a>
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
            <article>
                <div class="review-card">
                <h3 class="review-name">Clair Obscur: Expedition 33</h3>    
                <img src="images/clair_obscur.jpg" alt="Clair Obscur" style="width:120px; height:auto;">
                    <div class="review-content">
                        <div class="review-rating">
                            ★★★★☆
                            <span class="avg">4.5</span>
                            <span class="reviews-count">(200 reviews)</span>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                <h3 class="review-name">Mystic Quest</h3>
                <img src="images/mystic_quest.jpg" alt="Mystic Quest" style="width:120px; height:auto;">
                    <div class="review-content">
                        <div class="review-rating">
                            ★★★☆☆
                            <span class="avg">3.0</span>
                            <span class="reviews-count">(150 reviews)</span>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                <h3 class="review-name">Space Odyssey</h3>
                <img src="images/space_odyssey.jpg" alt="Space Odyssey" style="width:120px; height:auto;">
                    <div class="review-content">
                        <div class="review-rating">
                            ★★★★★
                            <span class="avg">5.0</span>
                            <span class="reviews-count">(300 reviews)</span>
                        </div>
                    </div>
                </div>
        </article>
    </section>
</main>
<script src="scripts.js"></script>

<footer>
    <form action="index.php" method="POST">
    <input type="button" name="logout" value="Logout"></input>
    </form>
</footer>
</body>
</html>