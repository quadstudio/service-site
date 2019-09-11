<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contract extends Model
{
    public $incrementing = false;
    /**
     * @var string
     */
    protected $table = 'contracts';

    protected $fillable = [
        'contragent_id', 'date', 'territory',
        'number', 'signer', 'type_id',
        'automatic', 'phone'
    ];

    protected $casts = [
        'contragent_id' => 'integer',
        'date'          => 'date:Y-m-d',
        'territory'     => 'string',
        'number'        => 'string',
        'phone'         => 'string',
        'automatic'     => 'boolean',
        'signer'        => 'string',
        'type_id'       => 'integer',
    ];

    protected $dates = [
        'date',
    ];

    protected static function boot()
    {
        static::creating(function ($model) {
            if ($model->getAttribute('automatic')) {
                $max_id = DB::table('contracts')->max('id');
                $model->number = $model->type->getAttribute('prefix') . (++$max_id);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contragent()
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ContractType::class, 'type_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

}
