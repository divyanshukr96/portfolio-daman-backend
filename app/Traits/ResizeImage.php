<?php


namespace App\Traits;


trait ResizeImage
{

    private $new_width;
    private $new_height;
    private $height;
    private $width;
    private $image_resource_id;
    private $new_image;
    private $file;

    /**
     * @param $photo
     */
    private function resize($photo)
    {
        $file = $this->getImageFilePath($photo);
        if (file_exists($file) && (filesize($file) > 2105728)) {
            list($this->width, $this->height,) = getimagesize($file);
            $this->setImageSize();
            $image_type = exif_imagetype($file);
            if ($image_type == IMAGETYPE_JPEG) {
                $this->image_resource_id = imagecreatefromjpeg($file);
                $this->new_image = imagejpeg($this->generateImage(), $file);
            } elseif ($image_type == IMAGETYPE_GIF) {
                $this->image_resource_id = imagecreatefromgif($file);
                $this->new_image = imagegif($this->generateImage(), $file);
            } elseif ($image_type == IMAGETYPE_PNG) {
                $this->image_resource_id = imagecreatefrompng($file);
                $this->new_image = imagepng($this->generateImage(), $file);
            }
        }
    }

    /**
     * @param $photo
     * @return float|int
     */
    public function getPhotoSize($photo)
    {
        $file = $this->getImageFilePath($photo);
        return file_exists($file) ? filesize($file) / (1024 * 1024) : null;
    }

    /**
     * @return false|resource
     */
    private function generateImage()
    {
        $target_layer = imagecreatetruecolor($this->new_width, $this->new_height);
        imagecopyresampled($target_layer, $this->image_resource_id, 0, 0, 0, 0, $this->new_width, $this->new_height, $this->width, $this->height);
        return $target_layer;
    }

    /**
     *
     */
    private function setImageSize()
    {
        $ration = $this->width / $this->height;
        if ($this->width > 1920) {
            $this->new_width = 1920;
            $this->new_height = intval($this->new_width * (1 / $ration));
        } elseif ($this->height > 1080) {
            $this->new_height = 1080;
            $this->new_width = intval($this->new_height * $ration);
        }
    }

    /**
     * @param $photo
     * @return string
     */
    private function getImageFilePath($photo)
    {
        $path = $photo ? $photo->year . '/' . $photo->month . '/' : '';
        return $this->file = storage_path('app/images/' . $path . $photo->name);
    }

}
