<link rel="stylesheet" href="styles.css">
<?PHP
    //pass result from an sql query
    function printGame($game){
        echo'
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
            </article>
        ';
    } 
    function printGameFull($game, $reviews){
        echo "
        <article>
            <h2>".$game['name']."</h2>
            <p> Release Date: ".$game['releaseDate']."</p>
            <p>".$game['bio']."</p>
            <img src='".$game['picture']."'>
        </article>
        ";

        //has user logged in
        if(isset($_SESSION['user'])){
            //has user made a review on this game yet
            foreach($reviews as $r){
                if($r['reviewer'] == $_SESSION['user']){
                    $hasMadeReview = true;
                    $usersReview = $r;
                    break;
                }
                $hasMadeReview = false;
            }
            if(count($reviews) == 0)
                $hasMadeReview = false;

            if($hasMadeReview){
                echo "
                <form action='game.php' method='POST' class='makeReview'>
                    <label for='score'>Score</label>
                    <input type='number' name='score' maxlength='1' max='5' value=".$usersReview['score']." required><br> 
                    <label for='review'>Review</label><br>
                    <textarea name='review' maxlength='2000' rows='4' cols='50'>".$usersReview['review']."</textarea><br>
                    <input type='submit' name='updateReview' value='Update Review'>                   
                </form>
                ";
            }else{
                echo "
                <form action='game.php' method='POST' class='makeReview'>
                    <label for='score'>Score</label>
                    <input type='number' name='score' maxlength='1' max='5' value='' required><br> 
                    <label for='review'>Review</label><br>
                    <textarea name='review' maxlength='2000' rows='4' cols='50'></textarea><br> 
                    <input type='submit' name='newReview' value='Post Review'>                                     
                </form>
                ";
            }
        }

        foreach($reviews as $r){
            echo "
            <article class='userReview'>
                <h3>User: ".$r['reviewer']."</h3>
                <h4>Score: ".$r['score']." out of 5</h4>
                <p>".$r['review']."</p>
            </article>
            ";
        }  
    }
?>
