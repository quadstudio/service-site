<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'certificate_types';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'type_id');

    }

}
