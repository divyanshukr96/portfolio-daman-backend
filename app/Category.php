<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static where(string $string, $get)
 */
class Category extends Model
{
    protected $fillable = ['name', 'value'];

    /**
     * @return BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Photo::class);
    }
}
