<?php

namespace App\Services\Providers;

use App\Contracts\FeedContract;

/**
 * Class Pinboard
 *
 * @package App\Services\Providers
 */
class Pinboard implements FeedContract
{

    /**
     * @return array
     */
    public function getItems() : array
    {
        // We'll store our fetched items in an array
        $items = [];

        // Get the feed contents and parse
        $feed = file_get_contents(env('RSS_URL'));
        $feed = simplexml_load_string($feed);

        // Iterate items and return them
        foreach ($feed->item as $element) {
            $items[] = [
              'key' => 'marker-' . md5($element->link),
              'link' => (string)$element->link,
              'title' => str_replace('[priv] ', '', $element->title)
            ];
        }

        return $items;
    }
}
