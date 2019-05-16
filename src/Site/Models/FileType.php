<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\Sortable;


class FileType extends Model
{

    use Sortable;
    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['name', 'comment', 'group_id', 'enabled', 'required', 'sort_order'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'file_types';
    }

    /**
     * Группа файла
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(FileGroup::class);
    }

    public function scopeEnabled($query)
    {
        return $query->whereEnabled(1);
    }

    public function scopeRequired($query)
    {
        return $query->whereRequired(1);
    }


    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class, 'type_id');
    }

}
