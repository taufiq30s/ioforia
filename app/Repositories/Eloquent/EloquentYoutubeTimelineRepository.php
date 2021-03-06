<?php

namespace App\Repositories\Eloquent;

use App\Repositories\YoutubeTimelineRepository;

class EloquentYoutubeTimelineRepository implements YoutubeTimelineRepository {
  protected $youtubeTimelineModel = null;

  public function __construct($model)
  {
    $this->youtubeTimelineModel = $model;
  }

  public function store(array $data) {
    // TODO
  }

  public function update(array $data) {
    //TODO
  }

  public function list() {
    return $this->youtubeTimelineModel->all()->sortBy('publishedAt');
  }

  public function find($id) {
    return $this->youtubeTimelineModel->where('id', $id)->exists();
  }

  public function count() {
    return $this->youtubeTimelineModel->count();
  }
}