<?php

class Image {

	/*
    Class properties
    Encapsulation:
    Access modifiers indicate what access levels other classes can have to these properties
    1) Public    - Any other class can access the property
    2) Private   - Only this class can access the property
    3) Protected - This class and any class that inherits it can access this property
    */

	protected $image;
	protected $width;
	protected $height;
	protected $mimetype;
	
	public function display() {
		header("Content-type: {$this->mimetype}");
        switch($this->mimetype) {
            case 'image/jpeg': imagejpeg($this->image); break;
            case 'image/png': imagepng($this->image); break;
            case 'image/gif': imagegif($this->image); break;
        }
	}
	
	public function resize($width, $height) {
        $thumb = imagecreatetruecolor($width, $height);
        imagecopyresampled($thumb, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
        $this->image = $thumb;
    }	
	
}	# eoc