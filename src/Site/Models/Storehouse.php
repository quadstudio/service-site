<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Http\Requests\StorehouseRequest;
use QuadStudio\Service\Site\Imports\Excel\StorehouseUrl;

class Storehouse extends Model
{
    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = ['name', 'url', 'enabled', 'everyday', 'uploaded_at'];

    /**
     * @var bool
     */
    protected $casts = [
        'user_id'     => 'integer',
        'name'        => 'string',
        'url'         => 'string',
        'enabled'     => 'boolean',
        'everyday'    => 'boolean',
        'uploaded_at' => 'datetime:Y-m-d H:i:s',
    ];


    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'storehouses';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function needAutomaticUpdate()
    {
        return self::query()
            ->where('enabled', 1)
            ->where('everyday', 1)
            ->where(function ($query) {
                $query
                    ->whereNull('uploaded_at')
                    ->orWhereDate('uploaded_at', '<', Carbon::today()->toDateString());
            });
    }

    /**
     * @param $value
     */
    public function setUploadedAtAttribute($value)
    {
        $this->attributes['uploaded_at'] = $value ? Carbon::createFromFormat('d.m.Y H:i:s', $value) : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @param StorehouseRequest $request
     * @return $this
     */
    public function attachAddresses(StorehouseRequest $request)
    {
        if ($request->filled('addresses')) {
            Address::query()->findMany($request->input('addresses'))->each(function ($address) {
                $address->update(['storehouse_id' => $this->getKey()]);
            });
        }
        return $this;
    }

    public function updateFromUrl()
    {
        $data = (new StorehouseUrl())->get($this);
        $this->products()->delete();
        $this->products()->createMany($data);
        return $this->update(['uploaded_at' => date('d.m.Y H:i:s')]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(StorehouseProduct::class, 'storehouse_id');
    }

}
