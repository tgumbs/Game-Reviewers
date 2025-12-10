<?PHP
    //pass result from an sql query
    function printGame($game){
        echo"
        <article>
            <h3>".$game['name']."</h3>
            <p> Release Date: ".$game['releaseDate']."</p>
            <p>".$game['bio']."</p>
            <img src='".$game['picture']."'>
        </article>  
        ";
    } 