Twitter PHP Client  
==================
[![Build Status](https://travis-ci.org/uditiiita/twitter-php.svg?branch=master)](https://travis-ci.org/uditiiita/twitter-php)

A simple Twitter API client in PHP that fetches and displays Tweets those 
* a) Have been re-Tweeted at least once and 
* b) Contain the hashtag #custserv

## Highlights

* Configurable Search Term
* Allow you to view older Tweets with infinite scroll
* Readable and reusable
* Easy to extend
* Complete Unit tests.

## Installation

### Dependencies

* PHP >= 5.6
* [Composer]

### App setup on Twitter

* [Register your app on Twitter]
* Get Consumer Key (API Key), Consumer Secret (API Secret) from Application Settings.
* Get Access Token, Access Token Secret from "Your Access Token" Settings.

### Setup

* Close this repo at your document root.
* Go to the home diretory of your repo.
* Run `composer install` from command line.
* Create a copy of file config/sample-config.inc.php to config/config.inc.php.
* Add your Twitter credentials in config.inc.php.
* Open localhost in your browser.

## Testing

* Run phpunit in source directory home.

## Future Improvements

* Cache tweet data
* Improve styling for tweets.
* Show loading spinner while fetching tweets.

## Author

[Udit Agarwal], udit.ag@directi.com

[Composer]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
[Register your app on Twitter]: https://apps.twitter.com/app/new
[Udit Agarwal]: https://github.com/uditiiita