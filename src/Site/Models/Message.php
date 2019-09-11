<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Message extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'messages';

	/**
	 * @var array
	 */
    protected $fillable = [
        'text', 'receiver_id', 'received'
    ];

    /**
     * Get all of the owning contactable models.
     */
    public function messagable()
    {
        return $this->morphTo();
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
