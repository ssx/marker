<?php

namespace App\Services\Networks;

use App\Contracts\NetworkContract;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Twitter implements NetworkContract
{

    public function publish($status) : string
    {

        try {
            $stack = HandlerStack::create();

            $middleware = new Oauth1([
                'consumer_key' => env('TWITTER_CONSUMER_KEY'),
                'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
                'token' => env('TWITTER_ACCESS_TOKEN'),
                'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
            ]);
            $stack->push($middleware);

            $client = new Client([
                'base_uri' => 'https://api.twitter.com/1.1/',
                'handler' => $stack,
                'auth' => 'oauth'
            ]);

            // Now you don't need to add the auth parameter
            $request = $client->post('statuses/update.json', [
                'form_params' => [
                    'status' => $status
                ]
            ]);

            $response = json_decode($request->getBody(), true);

            // Return the post URL
            return 'https://twitter.com/' . $response['user']['screen_name'] .
                '/statuses/' . $response['id_str'];
        } catch (\Exception $e) {
            // Perhaps need to re-think the error
            return '';
        }
    }
}
