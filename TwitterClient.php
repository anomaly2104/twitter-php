<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Uditiiita;

/**
 * Class TwitterClient
 *
 * Helper client for interacting with the twitter API
 *
 * @package Uditiiita
 */
class TwitterClient {
    private $twitterOAuth;
    
    private $hashTag = "#custserv";
    
    private $endpoint = 'search/tweets';
    
    private $fetchCount = 100;
    
    public function __construct(\Abraham\TwitterOAuth\TwitterOAuth $twitterOAuth) {
        $this->twitterOAuth = $twitterOAuth;
    }
    
    public function getTweets() {
        var_dump("fetching tweets for endpoint: ". $this->endpoint);
        try {
            $tweets = $this->twitterOAuth->get($this->endpoint, array(
                "q" => $this->hashTag,
                "count" => $this->fetchCount
            ));
            print_r($tweets);
            return $tweets;
        } catch (Exception $ex) {
            //TODO: Handle this.
            var_dump($ex);
            return array();
        }
    }
}