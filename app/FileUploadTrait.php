<?php namespace App;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileUploadTrait {

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
     * Set all of the required values for the new file
     * @param $slug
     * @param $extension
     * @internal param $userSlug
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
     * Save the file to the FS
     *
     * @param UploadedFile $file
     * @return $this
     */
    public function store(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);

        $this->makeThumbnail();

        return $this;
    }

    /**
     * Make a thumbnail from the uploaded image
     */
    public function makeThumbnail()
    {
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }
}
