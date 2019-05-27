<?php
/**
 * Created for Kodmaster23.
 * User: Thiago Traczykowski
 */

namespace Kodmaster23\LaravelQuickStart\Services;

use Illuminate\Support\Facades\Storage;

class FileManager
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $images;
    /**
     * @var string
     */
    private $disk;

    public function __construct(
        string $name = '',
        array $images = [],
        string $disk = 's3'
    )
    {
        $this->setData($name, $images, $disk);
    }

    public function setData(
        string $name,
        array $images = [],
        string $disk = 's3'
    )
    {
        $this->name = $name;
        $this->images = $images;
        $this->disk = $disk;
    }

    public function upload()
    {
        $return = [];
        foreach ($this->images as $key => $image){
            $name = $this->name.'-'.$key;
            Storage::disk($this->disk)->put($name, $image);
            $return[] = Storage::disk(($this->disk)->url($name));
        }

        return $return;
    }
}
