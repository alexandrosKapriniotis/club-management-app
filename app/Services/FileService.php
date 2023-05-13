<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileService
{
    public function __construct(string $disk = 'public')
    {
        $this->disk = $disk;
    }

    protected string $disk = 'public';

    /**
     * @return Filesystem
     */
    public function getDisk(): Filesystem
    {
        return Storage::disk($this->disk);
    }
    /**
     * @param UploadedFile $file
     * @param string $type
     * @param int $size
     * @return string
     */
    public function savePicture(UploadedFile $file, string $type, int $size): string
    {
        $filename = uniqid(time(), true) . '.' . $file->getClientOriginalExtension();
        $image = Image::make($file)->resize($size,null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($filename);
        if (!$this->getDisk()->exists($type)) {
            $this->getDisk()->makeDirectory($type);
        }
        $this->getDisk()->put($type . '/' . $filename, $image);

        return $filename;
    }

    /**
     * @param string $file
     * @param string $type
     */
    public function deleteFile(string $file, string $type): void
    {
        $this->getDisk()->delete($type.'/'.$file);
    }

    /**
     * @param UploadedFile $file
     * @param string $type
     * @return string
     */
    public function saveFile(UploadedFile $file, string $type): string
    {
        $filename = uniqid(time(), true) . '.' . $file->getClientOriginalExtension();
        if (!$this->getDisk()->exists($type)) {
            $this->getDisk()->makeDirectory($type);
        }
        $this->getDisk()->putFileAs(
            $type , $file, $filename
        );

        return $filename;
    }

    public function getUrl(string $filename, string $type): string
    {
        return $this->getDisk()->url($type . '/' . $filename);
    }
}
