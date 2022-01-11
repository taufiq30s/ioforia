<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;
use App\Repositories\Eloquent\EloquentYoutubeTimelineRepository;
use Illuminate\Database\Eloquent\Collection;

class YoutubeTimelineController extends Controller 
{
    protected $eloquentYoutubeTimeline;

    public function __construct(EloquentYoutubeTimelineRepository $eloquentYoutubeTimeline) {
        $this->eloquentYoutubeTimeline = $eloquentYoutubeTimeline;
    }

    public function list() {
        $videoResults = (Youtube::listChannelVideos('UCAoy6rzhSf4ydcYjJw3WoVg', 50, 'date',  ['id', 'snippet'], true));
        $videoLists = $videoResults['results'];
        $searchInfo = (object) $videoResults['info'];
        $videoCount = $searchInfo->totalResults;
        if($this->eloquentYoutubeTimeline->count() == 0) {
            while(!is_null($searchInfo->nextPageToken)){
                $videoResults = Youtube::listChannelVideos('UCAoy6rzhSf4ydcYjJw3WoVg', 50, 'date',  ['id', 'snippet'], true, $searchInfo->nextPageToken);
                $videoLists = array_merge($videoLists, $videoResults['results']);
            }
            $data = [];
            foreach($videoLists as $video) {
                $data = array_merge($data, [
                    'id' => $video->id->videoId,
                    'title' => $video->snippet->title,
                    'thumnailUrl' => $video->snippet->thumbnails->default->url,
                    'publishedAt' => $video->snippet->publishedAt,
                    'liveBroadcastContent' => $video->snippet->liveBroadcastContent,
                ]);
            }
            $this->eloquentYoutubeTimeline->store($data);
        }

    //     $ax = [
    //         0 => (object) [
    //             'a' => 1,
    //             'b' => 2
    //         ],
    //         1 => (object) [
    //             'a' => 3,
    //             'b' => 4
    //         ],
    //     ];
    //     $bx = [
    //         0 => (object) [
    //             'a' => 5,
    //             'b' => 6
    //         ],
    //         1 => (object) [
    //             'a' => 7,
    //             'b' => 8
    //         ],
    //     ];
    //     $cx = array_merge($ax, $bx);
    //     $ex = [];
    //     foreach($cx as $data) {
    //         $ex = array_merge($ex, array([
    //             'id' => $data->a,
    //             'name' => $data->b
    //         ]));
    //     }
    //     $dx = [
    //         [
    //             'id' => 1,
    //             'name' => 2
    //         ],
    //         [
    //             'id' => 3,
    //             'name' => 4
    //         ],
    //         [
    //             'id' => 5,
    //             'name' => 6
    //         ],
    //         [
    //             'id' => 7,
    //             'name' => 8
    //         ],
    //     ];
    //     print_r("page ");
    //     print_r(0);
    //     dd($ex);
    //     dd("oke");
    }
}
