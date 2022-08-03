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

    //OAuth callback
    define('OAUTH_CALLBACK', getenv('callback.php'));

    // Start session
    session_start();
    
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
        <title><?php echo $siteName ?></title>
        <link rel="stylesheet" href="/css/site.css" />
        <base href=""/>
        <meta name="theme-color" content="#150622"/>
    </head>
    <body>
        <div id="main">
            <div id="logo">
                    <?php
                        // Post actions
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

                        echo "<h1>ШирпМайнер</h1>";

                        if (!isset($_SESSION['access_token']))
                        {
                            // Get Twitter connection
                            $connection = new TwitterOAuth($consumer_key, $consumer_secret);

                            // Request a token
                            $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

                            // Session to store Tokens
                            $_SESSION['oauth_token'] = $request_token['oauth_token'];
                            $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

                            // Get url 
                            $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

                            echo '<a href="'.$url.'">Authorize Twitter</a>';
                        }
                        else 
                        {
	
                            $access_token = $_SESSION['access_token'];
                            $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

                            $user = $connection->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true']);
                        }
                    ?>

                    <?php

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
                    ?>
            </div>

            <div class="getTwitterIdFromName">
                <form method="post">
                    <label for="name">Get Twitter-Data from Username:</label></label>
                    <input type="text" id="name" name="name" onchange="this.form.submit()" value="<?php echo $currentAccount;?>">
                </form>
            </div>

            <?php
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
            <div class="twitterLists">
                    <a class="twitter-timeline" href="<?php echo $listId ?>"></a> 
            </div>
        </div>
        <script src="js/site.js"></script>
    </body>
</html>