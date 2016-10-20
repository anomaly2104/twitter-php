$(document).ready(function () {
    var maxId = null;
    var isFetching = false;
    
    function fetchAndRenderTweets() {
        if (isFetching) {
            console.log("Already fetching!");
            return;
        }
        isFetching = true;
        fetchTweets(function (tweets) {
            renderTweets(tweets);
            updateMaxId(tweets);
            isFetching = false;
        });
    }
    
    function getAPIURL() {
        return maxId === null ? "./api/getTweets.php" : "./api/getTweets.php?beforeId=" + maxId;
    }
    
    function fetchTweets(callback) {
        $.getJSON(getAPIURL(), function (tweets) {
            twttr.ready(function () {
                callback(tweets);
            });
        });
    }
    
    function updateMaxId(tweets) {
       for (var i = 0; i < tweets.length; ++i) {
            var tweet = tweets[i];
            if (maxId == null || maxId > tweet.id) {
                maxId = tweet.id;
            }
        }
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
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            console.log("bottom!");
            fetchAndRenderTweets();
        }
    });
    
    fetchAndRenderTweets();
});

    