<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static first()
 * @method static onlyTrashed()
 * @method static withTrashed()
 * @property mixed description
 */
class Description extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'photo_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderTrashed', function (Builder $builder) {
            $builder->orderBy('deleted_at', 'DESC');
        });
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    /**
     * @param $value
     * @return string
     */
    public function getDeletedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y, h:i:s');
    }

    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return Str::limit($this->description, 60);
    }

}
