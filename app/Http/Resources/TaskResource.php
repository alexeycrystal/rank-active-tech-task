<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TaskResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('d M Y - H:i:s',  $this->created_at->timestamp),
            'post_id' => $this->post_id,
            'post_key' => $this->post_key,
            'post_site' => $this->post_site,
            'task_id' => $this->task_id,
            'se_id' => $this->se_id,
            'loc_id' => $this->loc_id,
            'key_id' => $this->key_id,
            'results' => $this->result,
            'status' => $this->status,
            'result' => $this->result()
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success',
            'api_version' => 'v1',
        ];
    }
}
