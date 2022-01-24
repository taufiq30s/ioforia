<?php

namespace App\Http\Controllers;

// use Twitter;

use Atymic\Twitter\Facade\Twitter;
use Atymic\Twitter\Twitter as TwitterContract;
use Illuminate\Http\JsonResponse;

class TwitterFeedController extends Controller
{
    private $client;

    public function __construct()
    {

    }

    public function tester()
    {
        $params = [
            'tweet.fields' => 'created_at,source',
            'user.fields' => 'username,name',
            'max_results' => 10,
            'expansions' => 'author_id,in_reply_to_user_id',
            TwitterContract::KEY_RESPONSE_FORMAT => TwitterContract::RESPONSE_FORMAT_JSON,
        ];
    
        $return =  JsonResponse::fromJsonString(Twitter::searchRecent('#KKClubNews -is:retweet', $params));
        dd($return);
    }
}
