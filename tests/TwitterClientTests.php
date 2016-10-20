<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../model/TwitterClient.php';
require_once __DIR__ . '/../vendor/autoload.php';

class TwitterClientTests extends TestCase {
    /**
     * Object of TwitterClient class to be tested.
     * 
     * @var \Uditiiita\TwitterClient
     */
    private $twitterClient;
    
    private $twitterOAuthMock;

    /**
     * Setup the twitterClient object before running every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->twitterOAuthMock = $this->createMock(Abraham\TwitterOAuth\TwitterOAuth::class);
        $this->twitterOAuthMock->method('get')
                ->willReturn($this->mockTweets());
        
        $this->twitterClient = new Uditiiita\TwitterClient($this->twitterOAuthMock);
    }
    
    /**
     * Test that it returns only those tweets which are retweeted atleast once.
     */
    public function testItReturnsOnlyAtleastOnceRetweetedTweets() {
        $tweets = $this->twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any");
        
        $this->assertEquals(2, count($tweets));
        $this->assertArraySubset(["id" => "2"], $tweets[0]);
        $this->assertArraySubset(["id" => "3"], $tweets[1]);
    }
    
    /**
     * Test that it returned tweets has id of type string.
     */
    public function testItReturnsTweetsIdsInStringType() {
        $tweets = $this->twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any");
        
        $this->assertInternalType('string', $tweets[0]["id"]);
        $this->assertInternalType('string', $tweets[1]["id"]);
    }
    
    /**
     * Test the final query for hashtag search contains exclude:retweets
     */
    public function testQueryContainsRetweetsExcluding() {
        $this->twitterOAuthMock->expects($this->once())
                ->method('get')
                ->with($this->anything(), $this->callback(function($subject){
                    $query = $subject["q"];
                    return strpos($query, "exclude:retweets") != false;
                }));
        $this->twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any", 3);
    }
    
    /**
     * Test It correctly uses before ID.
     */
    public function testItDoesNotReturnsTweetsWithIdMoreThanBeforeId() {
        $this->twitterOAuthMock->expects($this->once())
                ->method('get')
                ->with($this->anything(), $this->callback(function($subject){
                    return $subject["max_id"] == 2;
                }));
        $this->twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any", 3);
    }
    
    /**
     * Test the final query for hashtag search contains exclude:retweets
     */
    public function testItCorrectlySendsFetchCount() {
        $fetchCount = rand(1, 100);
        $this->twitterOAuthMock->expects($this->once())
                ->method('get')
                ->with($this->anything(), $this->callback(function($subject) use ($fetchCount) {
                            return $subject["count"] == $fetchCount;
                }));
        $this->twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any", 3, $fetchCount);
    }
    
    /**
     * Sample data to be returned in place of mocked twitter call.
     * @return Test tweets
     */
    private function mockTweets() {
        return (object)["statuses" => [
            (object)["retweet_count" => 0, "id"=> 1],
            (object)["retweet_count" => 3, "id"=> 2],
            (object)["retweet_count" => 1, "id"=> 3],
            (object)["retweet_count" => 0, "id"=> 4]
            ]];
    }
}