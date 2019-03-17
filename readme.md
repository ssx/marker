### Marker

This application will take your bookmarked items from bookmarking services and
post them to supported social networks.


### Installation

Clone the repo, composer install.

The initial supported input service is [Pinboard](https://pinboard.in/) by
using your user RSS feed (look for 'RSS' link in your dashboard) and store that
in the `env` variable `RSS_URL`.

Out of the box, Twitter is the initial supported network. You will need to
obtain your own set of Twitter OAuth credentials including:

 - `TWITTER_CONSUMER_KEY`
 - `TWITTER_CONSUMER_SECRET`
 - `TWITTER_ACCESS_TOKEN`
 - `TWITTER_ACCESS_TOKEN_SECRET`

You'll need to configure your cron system to run the command
`php artisan schedule:run` every minute. In turn, this will query your input
source every five minutes for new content.


### Extending &amp; Adding Sources

If you want to write new input adapters, take a look at
`app/Contracts/FeedContract.php` file. If you want to write a new output
network then you'll need to implement the methods found within the
`app/Contracts/NetworkContract.php`.

After writing your own implementations, update the bindings in
`app\Providers\AppServiceProvider.php` to point at your newly written classes.


### Simulate Updates

There is also a `env` variable called `PUBLISH_UPDATES` which can be set to
`false` to prevent updates being published. If you wish to test that your
items are being pulled correctly but not publish them, use this option.


### Inspiration

I put this together after speaking to [Daniel Sinclair](https://twitter.com/@_danielsinclair)
on Twitter, who in turn stole in from [Jason Black](https://twitter.com/itsjasonblack).
