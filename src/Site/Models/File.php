<?php

namespace QuadStudio\Service\Site\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

//        self::created(function($model){
//            // ... code here
//        });
//
//        self::updating(function($model){
//            // ... code here
//        });
//
//        self::updated(function($model){
//            // ... code here
//        });
//
//        self::deleting(function($model){
//            // ... code here
//        });

//        self::deleted(function($model){
//            // ... code here
//        });
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
     * Отчет по ремонту
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repair()
    {
        return $this->belongsTo(Repair::class);
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

}
