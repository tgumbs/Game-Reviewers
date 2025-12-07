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
        //handle login
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
               <a href="index.html">Home</a>
               <a href="#search">Search</a>
               <a href="#saved_games">Saved Games</a>
               <a href="login.html">Login</a>
               <a href="register.html">Sign Up</a> 
        </nav>
    </header>

    <main>
        <section id="home">
            <h1>Welcome to Game Reviewers</h1>
            <p>Your source for honest game reviews and ratings.</p>
        </section>

        <section id="reviews">
            <h2>Latest Reviews</h2>
            <article>
                <h3>Game Title</h3>
                <p>Review content goes here...</p>
            </article>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Game Reviewers. All rights reserved.</p>
    </footer>
</body>
</html>