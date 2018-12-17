<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Todo extends Model {

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * primary Key is a string because of being a uuid
     */
    public $keyType = 'string';

    protected $fillable = [
    	'id',
        'title',
        'description',
        'due_date',
        'done'
    ];
  
    /* autocreate new uuid  for model->id on creating */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }


}
