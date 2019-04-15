<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, bool $true)
 * @method static create(array $data)
 * @method static onlyTrashed()
 */
class Layout extends Model
{
    use SoftDeletes;

    protected $fillable = ['about', 'title', 'cover', 'photo_id'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderCreated', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
        static::deleting(function ($layout) {
            foreach ($layout->photo()->get() as $photo) {
                $photo->delete();
            }
        });
    }


    /**
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    /**
     * @return BelongsTo
     */
    public function trash_photo()
    {
        return $this->belongsTo('App\Photo', 'photo_id', 'id')->withTrashed();
    }

}
