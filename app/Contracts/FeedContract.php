<?php

namespace App\Contracts;

/**
 * Interface FeedContract
 *
 * @package App\Contracts
 */
interface FeedContract
{
    /**
     * @return array
     */
    public function getItems() : array;
}
