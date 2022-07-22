<?php
    // For debugging
    /*
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    */

    // PHP Composer
    // You need to compose the TwitterOAuth
    require 'vendor/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    // Load config.php
    require 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="twitter:widgets:theme" content="dark">
    <meta name="twitter:widgets:border-color" content="#150682">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <title>ШирпМайнинг</title>
    <link rel="stylesheet" href="/css/site.css" />
    <base href=""/>
    <!--Get Theme-Color from the Database-->
    <meta name="theme-color" content="#150621"/>
</head>
<body>
    <div id="main">
        <div id="logo">
                <?php

                if(isset($_POST['Id']))
                {
                    $listId = htmlspecialchars($_POST['Id']);
                }
                else
                {
                    $listId = "UkraineInfoBot";
                }

                if(isset($_POST['name'])) 
                {
                    $listId = htmlspecialchars($_POST['name']);
                    $currentAccount = htmlspecialchars($_POST['name']);
                }
                else
                {
                    $currentAccount = "UkraineInfoBot";;
                }

                echo "<h1>ШирпМайнинг</h1>";

                $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
                $connection->setApiVersion('2');
                $content = $connection->get('users/by', ['usernames' => $currentAccount]);

                if ($connection->getLastHttpCode() == 200) 
                {
                    echo "<!-- Everything fine -->";
                } 
                else 
                {
                    $stauscode = $connection->getLastHttpCode();
                    echo "<p>Something went wrong!</p> ";
                    echo $stauscode;
                }

                // Dump object
                //var_dump($content);

                // Dump Twitter JSON Object line by line
                echo "<ul>";
                foreach($content as $key => $value) 
                {    
                    foreach($value as $second => $secondValue) 
                    {
                        foreach($secondValue as $third => $thirdValue)
                        {
                            echo "<li>".$thirdValue."</li>";     
                        }
                    }
                }
                echo "</ul>";
                ?>
        </div>

        <div class="getTwitterIdFromName">
            <form method="post">
                <label for="name">Get Twitter-Data from Username:</label></label>
                <input type="text" id="name" name="name" onchange="this.form.submit()" value="<?php echo $currentAccount;?>">
            </form>
        </div>

        <div class="twitterListSelect">
            <form method="post">
                <select name="Id" onchange="this.form.submit()">
                    <option value="ChirpMining/lists/1538560246209191944">SELECT TWITTERLIST</option>
                    <option value="ChirpMining/lists/1538560246209191944">🌐 Media (english)</option>
                    <option value="ChirpMining/lists/1537760505896501248">🌐 Authors (english)</option>
                    <option value="ChirpMining/lists/1543518362877235201">🦆 Information Technology</option>
                    <option value="UkraineInfoBot/lists/1410205580212555782" >🇩🇪 Authors</option>
                    <option value="UkraineInfoBot/lists/1413035725143093249">🇩🇪 Activists</option>
                    <option value="UkraineInfoBot/lists/1456380304277614596">🇩🇪 Parliament (MdB20)</option>
                    <option value="UkraineInfoBot/lists/1423990031920861184">⚔ NATO</option>
                    <option value="UkraineInfoBot/lists/1423230800879816705">🇺🇳 United Nations</option>
                    <option value="UnitedSpaceCats">United Space Cats 😻</option>            
                    <!--<option value="" > </option> -->
                </select>
            </form>
        </div>
        <div class="twitterLists">
                <a class="twitter-timeline" href="https://twitter.com/<?php echo $listId ?>"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
    </div>
</body>