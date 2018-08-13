<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Message extends Model
{
    protected $fillable = [
        'text', 'receiver_id', 'received'
    ];

    /**
     * @var string
     */
    protected $table;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'messages';
    }


    /**
     * Get all of the owning contactable models.
     */
    public function messagable()
    {
        return $this->morphTo();
    }

    public function created_at($time = false)
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y' . ($time === true ? ' H:i' : '')) : '';
    }

    /**
     * Автор сообщения
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получатель сообщения
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class);
    }

}
