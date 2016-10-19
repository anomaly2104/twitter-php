$(document).ready(function () {
    fetchTweets(function (tweets) {
        renderTweets(tweets);
    });
    
    function fetchTweets(callback) {
        $.getJSON("./api/getTweets.php", function (tweets) {
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
          
        $('#tweets').append("<div id='" + tweet.id + "' class='col-md-4 col-lg-4'></div>");
        twttr.widgets.createTweet(tweet.id, document.getElementById(tweet.id), {
          cards: 'hidden',
          conversation: 'none'
        });
    }
});

    