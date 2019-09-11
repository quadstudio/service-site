<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\SingleImageable;

class Announcement extends Model implements SingleImageable
{

    /**
     * @var string
     */
    protected $table = 'announcements';

    protected $fillable = [
        'title', 'annotation', 'description',
        'image_id', 'date',
        'show_ferroli', 'show_lamborghini'
    ];

    protected $casts = [

        'title'            => 'string',
        'annotation'       => 'string',
        'description'      => 'string',
        'show_ferroli'     => 'boolean',
        'show_lamborghini' => 'boolean',
        'image_id'         => 'integer',
        'date'             => 'date:Y-m-d',
    ];

    protected $dates = [
        'date',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($announcement) {
            if ($announcement->image()->exists()) {
                $announcement->image->delete();
            }
        });
    }

    /**
     * @param $value
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }


    /**
     * Изображение схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class)->withDefault([
            'storage' => 'announcements',
            'path'    => 'noimage.png',
        ]);
    }

    public function hasDescription()
    {
        return mb_strlen($this->getAttribute('description'), "UTF-8") > 0;
    }

    /**
     * @return string
     */
    function imageStorage()
    {
        return 'announcements';
    }
}
