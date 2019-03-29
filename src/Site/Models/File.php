<?php

namespace QuadStudio\Service\Site\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name', 'path', 'type_id', 'size', 'mime', 'storage'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'files';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->user_id = Auth::user()->getAuthIdentifier();
        });
        self::deleting(function ($file) {
            Storage::disk($file->storage)->delete($file->path);
        });
    }

    /**
     * @return string
     */
    public function src()
    {
        return $this->exists ? Storage::disk($this->storage)->url($this->path) : Storage::disk('products')->url('noimage.png');
    }

    /**
     * @return bool
     */
    public function getIsImageAttribute()
    {
        switch ($this->getAttribute('mime')) {
            case 'image/jpeg':
            case 'image/png':
                return true;
            default:
                return false;
        }
    }

    public function getSrcAttribute()
    {
        return $this->exists ? Storage::disk($this->storage)->url($this->path) : Storage::disk('products')->url('noimage.png');
    }

    public function getImageWidthAttribute()
    {
        if ($this->exists()) {
            list($width, $height) = getimagesize($this->src);

            return $width;
        }

        return 0;

    }

    /**
     * @return bool
     */
    public function exists()
    {
        return Storage::disk($this->storage)->exists($this->path);
    }

    public function getImageHeightAttribute()
    {
        if ($this->exists()) {
            list($width, $height) = getimagesize($this->src);

            return $height;
        }

        return 0;

    }

    /**
     * Техдокументация
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datasheets()
    {
        return $this->hasMany(Datasheet::class);
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
     * Get all of the owning contactable models.
     */
    public function fileable()
    {
        return $this->morphTo();
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

    public function canDelete()
    {
        return true;
    }

}
