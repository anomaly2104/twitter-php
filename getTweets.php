<?php

namespace Uditiiita;

require_once 'vendor/autoload.php';
require_once 'config/config.inc.php';
require_once 'TwitterClient.php';

use \Abraham\TwitterOAuth\TwitterOAuth;
$twitterOAuth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_ACCESS_TOKEN, OAUTH_ACCESS_TOKEN_SECRET);

$twitterClient = new TwitterClient($twitterOAuth);

$twitterClient->getTweets();
