<?php

namespace App\DTO;

class CarrierPayloadDto
{
    protected $width;
    protected $height;
    protected $length;

    public function setWidth($width): self
    {
        $this->width = $width;
        return $this;
    }

    public function setLength($length): self
    {
        $this->length = $length;
        return $this;
    }

    public function setHeight($height): self
    {
        $this->height = $height;
        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }
}
