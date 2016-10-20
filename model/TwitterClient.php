<?php
namespace Uditiiita;

/**
 * Class TwitterClient.
 *
 * Helper client for interacting with the twitter API/
 *
 * @package Uditiiita
 */
class TwitterClient {
    /**
     * Twitter API OAuth Interface/
     *
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    private $twitterOAuth;
    
    /**
     * Endpoint of the API that provides search.
     */
    private $endpoint = 'search/tweets';
    
    /**
     * Constructor/
     * 
     * @param \Abraham\TwitterOAuth\TwitterOAuth $twitterOAuth Twitter OAuth client.
     */
    public function __construct(\Abraham\TwitterOAuth\TwitterOAuth $twitterOAuth) {
        $this->twitterOAuth = $twitterOAuth;
    }
    
    /**
     * Fetch tweets matching a particular hashtag.
     * 
     * @param string $hashTag HashTag to search.
     * @param int $maxId Max ID of the tweet in the result.
     * @param int $fetchCount Max number of tweets to get.
     * 
     * @return array List of tweets matching the hashtag.
     */
    private function searchTweets($query, $maxId, $fetchCount) {
        try {
            $tweets = $this->twitterOAuth->get($this->endpoint, array(
                "q" => $query,
                "count" => $fetchCount,
                "max_id" => $maxId
            ));
            return $tweets -> statuses;
        } catch (Exception $ex) {
            //No tweets if failed.
            return array();
        }
    }
    
    /**
     * Fetch tweets matching a particular hashtag and are retweeted atleast once.
     * 
     * @param string $hashTag HashTag to search.
     * @param int $beforeId Id of the tweet before which new tweets should be found.
     * @param int $fetchCount Maximum number of tweets to fetch frmo twitter.
     * 
     * @return array List of tweets matching the hashtag and are retweeted atlease once.
     */
    public function getTweetsWithHashTagAndMinimumOneRetweet($hashTag, $beforeId = NULL, $fetchCount = 100) {
        //$beforeId should not be included in the result
        $maxId = $beforeId - 1;

        //First get the tweets matching given hastag.
        $tweetsWithHashTag = $this->searchTweets(
                $this->queryWithExcludedRetweets($hashTag), 
                $maxId,
                $fetchCount);
        
        //Filter tweets which are never retweeted.
        $tweetsWithMinRetweet = array_filter($tweetsWithHashTag, function ($tweet) {
            return $tweet -> retweet_count >= 1;
        });
        
        //Create new array with the tweet IDs.
        $result = [];
        foreach ($tweetsWithMinRetweet as $tweet) {
            array_push($result, ["id"=> strval($tweet -> id)]);
        }
        return $result;
    }
    
    /**
     * Creates new twitter query with excluded retweets.
     */
    public function queryWithExcludedRetweets($query) {
        return $query . " exclude:retweets";
    }
}