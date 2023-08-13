<?php

class FileUploader {

    public $path = 'uploads'; //path where to store images
    public $pathToFile = 'templates/ciu_templates_blu/classes/uploads'; //path to show image 
    public $extlimit = 'no'; //Do you want to limit the extensions of files uploaded (yes/no)
    public $limitedext = array('pdf', 'zip', 'rar', 'txt', 'doc', 'docx'); //allowed Extensions
    // do not modify
    public $filename = ''; // variable to return filename of image  

    function FileUploader() { //check if folders are Writable or not //please CHOMD them 777
        if (!is_writeable($this->path)) {
            die("Error: The directory <b>($this->path)</b> is NOT writable<br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>");
        }
    }

    function file_uploader($file) {
        //for ($i = 0; $i < sizeof($file["name"]); $i++) {
            $file_type = $file["type"];//[$i];
            $file_name = $file["name"];//[$i];
            $file_size = $file["size"];//[$i];
            $file_tmp = $file["tmp_name"];//[$i];

            if ($file_name) {

                if (!is_uploaded_file($file_tmp)) {//check if you have selected a file.
                    return ("Error: Selecciona un achivo a subir " . $file_name . ".");
                }

                //get the file extension.
                $getExt = explode('.', $file_name);
                $ext = $getExt[count($getExt) - 1];
                $file_ext = strtolower($ext);


                if (($this->extlimit == "yes") && (!in_array($file_ext, $this->limitedext))) {//check file extension
                    return ("Por favor solo extensiones permitidas.");
                }

                //create a random file name
                $rand_name = md5(time());
                $rand_name = rand(0, 999999999);

                //create new file
                $UPLOAD = fopen($file_tmp, "r");
                $contents = fread($UPLOAD, $file_size);
                fclose($UPLOAD);
                $SAVEFILE = fopen($this->path . "/" . $rand_name . "." . $file_ext, "wb");
                fwrite($SAVEFILE, $contents, $file_size);
                fclose($SAVEFILE);

                // filename of image
                $this->filename[] = $rand_name . "." . $file_ext;
            }
        //}
        //print message
        return "";
    }

}

?>
