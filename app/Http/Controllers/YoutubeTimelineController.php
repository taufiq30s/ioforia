<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use App\Repositories\Eloquent\EloquentYoutubeTimelineRepository;
use Carbon\Carbon;

class YoutubeTimelineController extends Controller
{
    protected $eloquentYoutubeTimeline;

    public function __construct(EloquentYoutubeTimelineRepository $eloquentYoutubeTimeline)
    {
        $this->eloquentYoutubeTimeline = $eloquentYoutubeTimeline;
    }

    public function list() {
        return response()->json($this->eloquentYoutubeTimeline->list());
    }

    public function update()
    {
        $params = [
            'channelId'     => 'UCKAV3scmhfcH5Ozc6ICZGRQ',
            'type'          => 'video',
            'part'          => 'id, snippet',
            'order'         => 'date',
            'maxResults'    => 50
        ];
        $videoResults = Youtube::searchAdvanced($params, true);
        $videoLists = [];
        $data = array();
        if ($this->eloquentYoutubeTimeline->count() == 0) {
            do {
                $params['pageToken'] = $videoResults['info']['nextPageToken'];
                $videoLists = array_merge($videoLists, $videoResults['results']);
                $videoResults = Youtube::searchAdvanced($params, true);
            } while (isset($videoResults['info']['nextPageToken']));
            $videoLists = array_merge($videoLists, $videoResults['results']);
            $x = 0;
            foreach ($videoLists as $video) {
                if ($video->snippet->liveBroadcastContent == "none") {
                    $data = array_merge($data, array([
                        'id' => $video->id->videoId,
                        'title' => $video->snippet->title,
                        'thumbnailUrl' => $video->snippet->thumbnails->default->url,
                        'publishedAt' => date('Y-m-d h:i:s', strtotime($video->snippet->publishedAt)),
                        'created_at' => Carbon::now(),
                    ]));
                }
            }
        }
        else {
            foreach ($videoLists as $video) {
                if ($video->snippet->liveBroadcastContent == "none" && !$this->eloquentYoutubeTimeline->find($video->id->videoId)) {
                    $data = array_merge($data, array([
                        'id' => $video->id->videoId,
                        'title' => $video->snippet->title,
                        'thumbnailUrl' => $video->snippet->thumbnails->default->url,
                        'publishedAt' => date('Y-m-d h:i:s', strtotime($video->snippet->publishedAt)),
                        'created_at' => Carbon::now(),
                    ]));
                }
            }
        }
        if(!empty($data)) {
            try {
                $this->eloquentYoutubeTimeline->create($data);
                return response()->json(['msg' => "Ok"]);
            } catch (\Exception $ex) {
                return response()->json(['msg' => 'Error while store data', 'detail' => $ex]);
            }
        }
    }

    public function test() {
        $date = "2022-01-10T11:30:37Z";
        $res = date('Y-m-d h:i:s', strtotime($date));
        return response()->json(['res' => $res]);        
    }
}
