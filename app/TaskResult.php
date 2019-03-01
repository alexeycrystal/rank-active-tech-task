<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskResult
 * @package App
 */
class TaskResult extends Model
{
    /**
     * List of all fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'task_id',
        'date_time',
        'position',
        'url',
        'title',
        'snippet_extra',
        'snippet',
        'count',
        'extra',
        'spell_type',
        'se_check_url'
    ];

    /**
     * Relation to Task model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task(){
        return $this->belongsTo(
            'App\Task','task_id','task_id');
    }
}
