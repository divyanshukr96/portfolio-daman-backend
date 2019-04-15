<?php
/**
 * Created by PhpStorm.
 * User: DIVYANSHU
 * Date: 08-04-2019
 * Time: 05:19
 */

namespace App\Events;

use App\Photo;
use Carbon\Carbon;
use App\Jobs\ProcessUploadedImage;
use Illuminate\Queue\SerializesModels;

class PhotoSaved
{
    use SerializesModels;

    public $photo;

    /**
     * Create a new event instance.
     *
     * @param Photo $photo
     */
    public function __construct(Photo $photo)
    {
        $job = (new ProcessUploadedImage($photo))->delay(Carbon::now()->addSeconds(5))->onQueue('processing');
        dispatch($job);
    }


}
