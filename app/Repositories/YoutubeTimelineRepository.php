<?php

namespace App\Repositories;

interface YoutubeTimelineRepository {
  public function store(array $data);
  public function update(array $data);
  public function list();
  public function find($id);
  public function count();
}