<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['title', 'annotation', 'description', 'image_id', 'date', 'published'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'news';
    }

    /**
     * Изображение схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class)->withDefault([
            'storage' => 'news',
            'path'    => 'noimage.png',
        ]);
    }

    public function date()
    {
        return !is_null($this->getAttribute('date')) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->getAttribute('date')))->format('d.m.Y') : '';
    }

    public function hasDescription()
    {
        return mb_strlen($this->getAttribute('description'), "UTF-8") > 0;
    }

}
