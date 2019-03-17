<?php

namespace App\Contracts;

/**
 * Interface NetworkContract
 *
 * @package App\\Contracts
 */
interface NetworkContract
{
    /**
     * Publish a statue/post to this network.
     *
     * @param $status   A string to post as a post/update.
     * @return string   A HTTP URL to the posted item.
     */
    public function publish($status) : string;
}
