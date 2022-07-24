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
                        $listId = "https://twitter.com/".htmlspecialchars($_POST['Id']);
                    }
                    else
                    {
                        $listId = "https://twitter.com/".$ownAccount;
                    }

                    if(isset($_POST['name'])) 
                    {
                        $listId = "https://twitter.com/".htmlspecialchars($_POST['name']);
                        $currentAccount = htmlspecialchars($_POST['name']);
                    }
                    else
                    {
                        $currentAccount = $ownAccount;;
                    }

                    if(isset($_POST['tweetId']))
                    {
                        $listId = htmlspecialchars($_POST['tweetId']);
                    }
                    else
                    {
                        $tweetId = "https://twitter.com/AlmsNatalie/status/1549144569035608066";
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

            <div class="getTweetFromId">
                <!--
                <form method="post">
                    <label for="tweetId">Get Tweet from Url:</label></label>
                    <input type="text" id="tweetId" name="tweetId" onchange="this.form.submit()" value="<?php echo $tweetId;?>">
                </form>
                -->
            <div>

            <div class="twitterListSelect">
                <form method="post">
                    <select name="Id" onchange="this.form.submit()">
                        <option value="<?php echo $listProvider ?>/lists/1538560246209191944">SELECT TWITTERLIST</option>
                        <option value="<?php echo $listProvider ?>/lists/1538560246209191944">🌐 Media (english)</option>
                        <option value="<?php echo $listProvider ?>/lists/1537760505896501248">🌐 Authors (english)</option>
                        <option value="<?php echo $listProvider ?>/lists/1543518362877235201">🦆 Information Technology</option>
                        <option value="<?php echo $ownAccount ?>/lists/1410205580212555782" >🇩🇪 Authors</option>
                        <option value="<?php echo $ownAccount ?>/lists/1413035725143093249">🇩🇪 Activists</option>
                        <option value="<?php echo $ownAccount ?>/lists/1456380304277614596">🇩🇪 Parliament (MdB20)</option>
                        <option value="<?php echo $ownAccount ?>/lists/1423990031920861184">⚔ NATO</option>
                        <option value="<?php echo $ownAccount ?>/lists/1423230800879816705">🇺🇳 United Nations</option>
                        <option value="UnitedSpaceCats">United Space Cats 😻</option>            
                        <!--<option value="" > </option> -->
                    </select>
                </form>
            </div>
            <div class="twitterLists">
                    <a class="twitter-timeline" href="<?php echo $listId ?>"></a> 
            </div>
        </div>
        <script src="js/site.js"></script>
    </body>
</html>