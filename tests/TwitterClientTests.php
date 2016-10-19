<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../TwitterClient.php';
require_once __DIR__ . '/../vendor/autoload.php';

class TwitterClientTests extends TestCase {
    private $twitterClient;

    protected function setUp() {
        parent::setUp();
        $stub = $this->createMock(Abraham\TwitterOAuth\TwitterOAuth::class);
        $stub->method('get')
             ->willReturn($this->mockTweets());
        
        $this->twitterClient = new Uditiiita\TwitterClient($stub);
    }
    
    public function testItReturnsOnlyAtleastOnceRetweetedTweets() {
        $tweets = $this->twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any", 100);
        
        $this->assertEquals(2, count($tweets));
        $this->assertArraySubset(["id" => "2"], $tweets[0]);
        $this->assertArraySubset(["id" => "3"], $tweets[1]);
    }
    
    public function testItReturnsTweetsIdsInStringType() {
        $tweets = $this->twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any", 100);
        
        $this->assertInternalType('string', $tweets[0]["id"]);
        $this->assertInternalType('string', $tweets[1]["id"]);
    }
    
    private function mockTweets() {
        return (object)["statuses" => [
            (object)["retweet_count" => 0, "id"=> 1],
            (object)["retweet_count" => 3, "id"=> 2],
            (object)["retweet_count" => 1, "id"=> 3],
            (object)["retweet_count" => 0, "id"=> 4]
            ]];
    }
}