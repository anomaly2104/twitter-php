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

    /**
     * Setup the twitterClient object before running every test.
     */
    protected function setUp() {
        parent::setUp();
        $stub = $this->createMock(Abraham\TwitterOAuth\TwitterOAuth::class);
        $stub->method('get')
             ->willReturn($this->mockTweets());
        
        $this->twitterClient = new Uditiiita\TwitterClient($stub);
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