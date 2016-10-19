$(document).ready(function () {
    fetchTweets(function (tweets) {
        renderTweets(tweets);
    });
    
    function fetchTweets(callback) {
        $.getJSON("./api/getTweets.php", function (tweets) {
            twttr.ready(function () {
                callback(tweets);
            });
        });
    }
    
    function renderTweets(tweets) {
       for (var i = 0; i < tweets.length; ++i) {
            var tweet = tweets[i];
            renderTweet(tweet);
        }
    }
    
    function renderTweet(tweet) {
        $('#tweets').append("<div id='" + tweet.id + "' class='col-md-4 col-lg-4'></div>");
        twttr.widgets.createTweet(tweet.id, document.getElementById(tweet.id), {
          cards: 'hidden',
          conversation: 'none'
        });
    }
});

    