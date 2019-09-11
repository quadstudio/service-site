<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateType extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'template_types';

    /**
     * Шаблоны
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function templates()
    {
        return $this->hasMany(Template::class);
    }

}
