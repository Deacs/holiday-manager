<?php namespace App;

use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileUploadTrait {

    protected $name;

    /**
     * Take an uploaded file and associate it with the item
     *
     * @param UploadedFile $file
     * @param string $slug
     */
    public static function fromFile(UploadedFile $file, $slug)
    {
        return (new static)->saveAs($slug, $file->getClientOriginalExtension());
    }

    /**
     * Save the file to the FS
     *
     * @param UploadedFile $file
     * @return $this
     */
    public function store(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);

        if ($this->retain_aspect_ratio) {
            $this->makeConstrainedAspectRatioThumbnail();
        }
        else {
            $this->makeThumbnail();
        }


        return $this;
    }

    /**
     * Set all of the required values for the new file
     *
     * @param $slug
     * @param $extension
     *
     * @return $this
     */
    public function saveAs($slug, $extension)
    {
        $this->name             = time() . '-' .$slug . '.' . $extension;
        $this->path             = sprintf("%s/%s", $this->baseDir, $this->name);
        $this->thumbnail_path   = sprintf("%s/tn-%s", $this->baseDir, $this->name);

        return $this;
    }

    /**
     * Make a thumbnail from the uploaded image
     */
    public function makeThumbnail()
    {
        Image::make($this->path)
            ->fit($this->thumbnail_height, $this->thumbnail_width, function ($constraint) {
                $constraint->upsize();
            })->save($this->thumbnail_path);
    }

    /**
     * Make a thumbnail with a constrained aspect ratio from the uploaded image
     */
    public function makeConstrainedAspectRatioThumbnail()
    {
        Image::make($this->path)
            ->resize($this->thumbnail_height, $this->thumbnail_width, function ($constraint) {
                $constraint->aspectRatio();
            })->save($this->thumbnail_path);
    }

}
