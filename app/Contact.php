<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static paginate(int $int)
 * @property mixed event_date
 */
class Contact extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderCreate', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
    }

    protected $fillable = [
        'name',
        'email',
        'where',
        'event_date',
        'how_find',
        'about'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getEventDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

}
