<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = [
        'country_id', 'number', 'extra',
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
        $this->table = 'phones';
    }

    /**
     * Международный код
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Отформатированный номер телефона
     * @return string
     */
    public function format()
    {
        $result = [$this->country->getAttribute('phone')];
        if (preg_match('/^(\d{3})(\d{3})(\d{2})(\d{2})$/', $this->getAttribute('number'), $matches)) {
            $result[] = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3] . '-' . $matches[4];
        } else {
            $result[] = $this->getAttribute('number');
        }
        if (mb_strlen($this->getAttribute('extra'), 'UTF-8') > 0) {
            $result[] = "(" . trans('site::phone.extra_short') . " {$this->getAttribute('extra')})";
        }

        return implode(' ', $result);
    }

    /**
     * Get all of the owning contactable models.
     */
    public function phoneable()
    {
        return $this->morphTo();
    }

}
