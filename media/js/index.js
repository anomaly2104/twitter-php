$(document).ready(function () {
    fetchTweets(function (tweets) {
        renderTweets(tweets);
    });
    
    function fetchTweets(callback) {
        $.getJSON("./getTweets.php", function (tweets) {
            console.log("tweets fetched");
            console.log(tweets);
            twttr.ready(function () {
                console.log("twtrr loaded");
                callback(tweets);
            });
        });
    }
    
    function renderTweets(tweets) {
        console.log("rendering  tweets: " + tweets);
        
        console.log(tweets);
        
        for (var i = 0; i < tweets.length; ++i) {
            var tweet = tweets[i];
            renderTweet(tweet);
        }
    }
    
    function renderTweet(tweet) {
        console.log("rendering  tweet: ");
        console.log(tweet);

        twttr.widgets.createTweet(tweet.id, document.getElementById('tweets'), {
            cards: 'hidden'
        });
    }
});

    