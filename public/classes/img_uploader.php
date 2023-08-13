<?php

class ImgUploader {

    public $path_original; //path where to store original images // NULL for not create 
    public $pathToFile = 'http://pajarraco.com/classes/uploads'; //path to show image 
    public $path_imgs = 'upload'; //path where to store images
    public $path_thumbs = 'upload'; //path where to store thumb images // NULL for not create 
    public $img_width = 300;
    public $thumb_width = 50; //the new width of the resized image. // in pixcel
    public $extlimit = 'yes'; //Do you want to limit the extensions of files uploaded (yes/no)
    public $limitedext = array('gif', 'jpg', 'png', 'jpeg', 'bmp'); //allowed Extensions
    // do not modify
    public $filename = ''; // variable to return filename of image  

    function ImgUploader() { //check if folders are Writable or not //please CHOMD them 777
        if ((isset($this->path_original)) && (!is_writeable($this->path_original))) {
            die("Error: The directory <b>($this->path_original)</b> is NOT writable<br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>");
        }
        if ((isset($this->path_thumbs)) && (!is_writeable($this->path_thumbs))) {
            die("Error: The directory <b>($this->path_thumbs)</b> is NOT writable<br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>");
        }
        if (!is_writeable($this->path_imgs)) {
            die("Error: The directory <b>($this->path_imgs)</b> is NOT writable<br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>");
        }
    }

    function img_uploader($file = "") {
        $file_type = $file["type"];
        $file_name = $file["name"];
        $file_size = $file["size"];
        $file_tmp = $file["tmp_name"];

        if (!is_uploaded_file($file_tmp)) {//check if you have selected a file.
            return ("Error: Selecciona una imagen a subir.");
        }

        //get the file extension.
        $getExt = explode('.', $file_name);
        $ext = $getExt[count($getExt) - 1];
        $file_ext = strtolower($ext);

        if (($this->extlimit == "yes") && (!in_array($file_ext, $this->limitedext))) {//check file extension
            return ("Por favor solo extensiones de imagenes.");
        }

        //create a random file name
        $rand_name = md5(time());
        $rand_name = rand(0, 999999999);

        //get the new width variable.
        $ImgWidth = $this->img_width;
        $ThumbWidth = $this->thumb_width;

        //keep image type
        if ($file_size) {
            if ($file_type == "image/pjpeg" || $file_type == "image/jpeg") {
                $new_img = imagecreatefromjpeg($file_tmp);
            } elseif ($file_type == "image/x-png" || $file_type == "image/png") {
                $new_img = imagecreatefrompng($file_tmp);
            } elseif ($file_type == "image/gif") {
                $new_img = imagecreatefromgif($file_tmp);
            }

            //list width and height and keep height ratio.
            list($width, $height) = getimagesize($file_tmp);
            $imgratio = $width / $height;
            if ($imgratio > 1) {
                $newwidth = $ImgWidth;
                $newheight = $ImgWidth / $imgratio;
                $newTwidth = $ThumbWidth;
                $newTheight = $ThumbWidth / $imgratio;
            } else {
                $newheight = $ImgWidth;
                $newwidth = $ImgWidth * $imgratio;
                $newTheight = $ThumbWidth;
                $newTwidth = $ThumbWidth * $imgratio;
            }

            //function for resize image.
            if (function_exists(imagecreatetruecolor)) {
                $resized_img = imagecreatetruecolor($newwidth, $newheight);
                $resized_thumb = imagecreatetruecolor($newTwidth, $newTheight);
            } else {
                die("Error: Please make sure you have GD library ver 2+<br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>");
            }

            ImageCopyResized($resized_img, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            ImageCopyResized($resized_thumb, $new_img, 0, 0, 0, 0, $newTwidth, $newTheight, $width, $height);

            //save image and thumb
            $rand_name_thumb = "thumb_" . $rand_name; // name for thumb file

            if (isset($this->path_original)) {
                ImageJpeg($new_img, "$this->path_original/$file_name");
            }
            if (isset($this->path_thumbs)) {
                ImageJpeg($resized_thumb, "$this->path_thumbs/$rand_name_thumb.$file_ext");
            }
            ImageJpeg($resized_img, "$this->path_imgs/$rand_name.$file_ext");

            // delete temporal
            ImageDestroy($resized_img);
            ImageDestroy($resized_thumb);
            ImageDestroy($new_img);

            // filename of image
            $this->filename = $rand_name . "." . $file_ext;

            //print message
            //return "<br>Image Thumb: <a href=\"$this->path_imgs/$rand_name.$file_ext\"><img src=\"$this->path_thumbs/$rand_name.$file_ext\" width=\"$newTwidth\" height=\"$newTheight\" /></a>";
        
            return "";
        }
    }

}

?>
