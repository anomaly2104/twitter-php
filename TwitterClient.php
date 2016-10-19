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
    private $endpoint = 'search/tweets';
    
    public function __construct(\Abraham\TwitterOAuth\TwitterOAuth $twitterOAuth) {
        $this->twitterOAuth = $twitterOAuth;
    }
    
    private function getTweetsWithHashTag($hashTag, $fetchCount) {
        try {
            $tweets = $this->twitterOAuth->get($this->endpoint, array(
                "q" => $hashTag,
                "count" => $fetchCount
            ));
            return $tweets -> statuses;
        } catch (Exception $ex) {
            //TODO: Handle this.
            var_dump($ex);
            return array();
        }
    }
    
    public function getTweetsWithHashTagAndMinimumOneRetweet($hashTag, $fetchCount = 100) {
        $tweetsWithHashTag = $this->getTweetsWithHashTag($hashTag, $fetchCount);
        return array_filter($tweetsWithHashTag, function ($tweet) {
            return $tweet -> retweet_count >= 1;
        });
    }
}