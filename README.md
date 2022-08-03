# ChirpMiner
Web application written in PHP to manage Twitter API V2.

- Using Twitteroauth by Abraham Williams
https://github.com/abraham/twitteroauth

# Installation
- You will need a config.php in your "wwwroot/" with the following code: 
```
<?php
    // Twitter configuration - you need a developer account
    // https://developer.twitter.com/en
    $access_token = "";
    $access_token_secret = "";
    $consumer_key = "";
    $consumer_secret = "";

    // Website name
    $siteName = "yourname.com";

    // Your details
    $ownAccount = "yourTwitter@";
    $listProvider = "Twitter@WithList";
?>
```

- You will need to compose "Twitteroauth" by Abraham Williams to your "vendor/" folder




