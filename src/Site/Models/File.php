<?php

namespace QuadStudio\Service\Site\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name', 'path', 'type_id', 'size', 'mime',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->user_id = Auth::user()->getAuthIdentifier();
        });
        self::deleting(function ($file) {
            Storage::disk($file->storage)->delete($file->path);
        });
    }


    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', ''). 'files';
    }



    /**
     * Тип файла
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(FileType::class);
    }

    /**
     * Get all of the owning contactable models.
     */
    public function fileable()
    {
        return $this->morphTo();
    }
    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function canDelete(){
        return true;
    }

}
