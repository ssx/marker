<?php
namespace App\Console\Commands;

use App\Contracts\FeedContract;
use App\Contracts\NetworkContract;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Class FeedRefresh
 */
class FeedRefresh extends Command
{
    /**
     * @var
     */
    private $feed;

    /**
     * @var
     */
    private $network;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "feed:refresh";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Process given RSS feed and publish posts.";


    /**
     * Execute the console command.
     *
     * @param FeedContract $feed
     * @param NetworkContract $network
     *
     * @return mixed
     */
    public function handle(FeedContract $feed, NetworkContract $network)
    {
        $this->feed = $feed;
        $this->network = $network;

        // Get all feed items
        $items = $this->feed->getItems();

        // If no items are in the list, then return early.
        if (count($items) === 0) {
            return;
        }

        // If we have items, iterate through them and post
        foreach ($items as $item) {
            $this->info('Processing: ' . $item['key']);

            // Does the item already exist in the cache?
            $returned = Cache::get($item['key'], false);

            if ($returned === false) {
                // This is a newly saved link, so post it.
                $post = '🔖 '.$item['title'] . ': 🔗 ' . $item['link'];

                // For each of the items, post a tweet.
                if (env('PUBLISH_UPDATES') === false) {
                    $this->info('Simulated Post: ' . $post);
                } else {
                    $this->network->publish($post);
                }

                // Store this in the cache.
                Cache::forever($item['key'], [
                    'created_at' => Carbon::now(),
                    'link' => $item['link'],
                    'title' => $item['title']
                ]);
            } else {
                $this->warn('Skipping existing cached link: '.$item['link']);
            }
        }
    }
}
