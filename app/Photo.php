<?php

namespace App;

use App\Events\PhotoSaved;
use App\Traits\StoreImage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $gallery)
 * @method static where(string $string, $path)
 * @method static Paginate(int $int)
 * @method static withTrashed()
 * @method static onlyTrashed()
 * @property mixed created_at
 * @property mixed description
 * @property mixed layout
 * @property mixed carousel
 * @property mixed name
 * @property mixed month
 * @property mixed year
 * @property mixed size
 */
class Photo extends Model
{

    use SoftDeletes, StoreImage;

    protected $fillable = ['name', 'carousel', 'remove'];


    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderCreated', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });
    }


    /**
     * @return HasOne
     */
    public function layout()
    {
        return $this->hasOne('App\Layout');
    }

    /**
     * @return HasOne
     */
    public function description()
    {
        return $this->hasOne('App\Description');
    }

    /**
     * @return BelongsToMany
     */
    public function Category()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @param $image
     * @return string
     */
    public function setNameAttribute($image)
    {
        $this->attributes['size'] = $this->getImageSize($image);
        if (is_object($image)) $image = $this->generateFileNameAndStore($image, '', true);
        return $this->attributes['name'] = $image;
    }

    /**
     * @return string
     */
    public function getYearAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y');
    }

    /**
     * @return string
     */
    public function getMonthAttribute()
    {
        return Carbon::parse($this->created_at)->format('m');
    }


    protected $dispatchesEvents = [
        'created' => PhotoSaved::class
    ];

}
