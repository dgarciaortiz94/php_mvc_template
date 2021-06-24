<?php

namespace Framework\Forms\Images;

class Images
{
    private $maxSize;
    private $types;
    private $img;


    public function __construct($img, int $maxSize, array $types)
    {
        $this->img = $img;
        $this->maxSize = $maxSize;
        $this->types = $types;
    }


    public function checkSize()
    {
        if ($this->img["size"] < $this->maxSize) {
            return true;
        }else{
            return false;
        }
    }


    public function checkType()
    {
        $type = $this->img["type"];

        if (!(strpos($type, "image/gif") || strpos($type, "image/jpeg") || strpos($type, "image/jpg") || strpos($type, "image/png"))) {
            return true;
        }else{
            return false;
        }
    }


    public function validate()
    {
        $validateSize = $this->checkSize();
        $validateType = $this->checkType();

        if ($validateSize && $validateType) {
            return true;
        }else{
            return false;
        }
    }


    public function upload(string $directory, string $name)
    {
        if (move_uploaded_file($this->img["tmp_name"], $directory . $name)){
            return true;
        }else{
            return false;
        }
    }


    public static function delete(string $directory, string $name)
    {
        if (unlink($directory . $name)) return true;
        else return false;
    }


    public static function exist(string $directory, string $name)
    {
        $filesOfProfileDir = scandir($directory);

        $existInDir = in_array($name, $filesOfProfileDir);

        if ($existInDir) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * Get the value of img
     */ 
    public function getImg()
    {
        return $this->img;
    }
}