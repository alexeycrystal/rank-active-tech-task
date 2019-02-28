<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($page) {
                return [
                    'id' => $page->id,
                    'created_at' => date('d M Y - H:i:s',  $page->created_at->timestamp),
                    'post_id' => $page->post_id,
                    'post_key' => $page->post_key,
                    'post_site' => $page->post_site,
                    'task_id' => $page->task_id,
                    'se_id' => $page->se_id,
                    'loc_id' => $page->loc_id,
                    'key_id' => $page->key_id,
                    'results' => $page->result,
                    'status' => $page->status,
                    'result' => $page->result(),
                ];
            }),
        ];
    }
}
