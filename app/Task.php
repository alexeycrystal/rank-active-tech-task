<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 */
class Task extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'task_identifier',
        'task_id',
        'post_id',
        'post_key',
        'post_site',
        'se_id',
        'loc_id',
        'key_id',
        'status',
        'created_at'
    ];

    /**
     * Result for current Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function result(){
        return $this->hasOne('App\TaskResult','task_id','task_id');
    }
}
