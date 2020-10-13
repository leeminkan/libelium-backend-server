<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;

interface DataCollectionRepository extends BaseRepository
{
    public function getByWaspmoteId(Request $request, $id);
}
