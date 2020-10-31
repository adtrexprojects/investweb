<?php
class imageUpload{
    var $upload_err = 0; //upload status
    var $upload_err_msg; //for keeping upload error messages
    
    //set limit upload filesize in bytes or zero if no limit
    var $max_filesize;
    
    //set allow type (mime type)
    var $allow_type;
    
    //set paths
    var $upload_path = "examples/pictures/";
    var $thumbnail_path = "examples/pictures/thumbnails/";

    //sometimes uploaded filename may contain special characters and to prevent read/write problem, you need to change it.
    var $set_name;

    //assign default thumbnail properties
    var $create_thumb = true;
    var $thumb_width = 200;
    var $thumb_height = 200;

    var $thumb_mode = ""; //exact (default), stretch, or crop

    //field name on form
    var $fieldname;

    //initialize class
    function imageUpload($fieldname){
        $this->fieldname = $fieldname;
        
        $this->max_filesize = 0;
        $this->allow_type = array("image/pjpeg"=>".jpg", "image/jpeg"=>".jpg", "image/gif"=>".gif", "image/png"=>".png", "image/x-png"=>".png");
        
        $this->upload_err_msg = array();
        
        $this->thumb_width = 0;
        $this->thumb_height = 0;
        
        $this->set_name = "";
    }
    
    function setUploadPath($path){
        $this->upload_path = $path;
    }
    
    function getUploadPath(){ 
        return $this->upload_path;
    }
    
    function setThumbPath($path){
        $this->thumbnail_path = $path;
    }
    
    function getThumbPath(){ 
        return $this->thumbnail_path;
    }
    
    function setCreateThumbnail($create){
        $this->create_thumb = $create;
    }
    
    function setMaxFileSize($size){
        $this->max_filesize = $size;
    }
    
    function setAllowFileType($type_array){
        $this->allow_type = $type_array;
    }
    
    function setThumbDimension($width, $height){
        $this->thumb_width = $width;
        $this->thumb_height = $height;
    }
    
    function isUploadError(){
        return $this->upload_err;
    }
    
    function getUploadMsg(){
        return $this->upload_err_msg;
    }
    
    function setPicName($name){
        $this->set_name = $name;    
    }

    function setThumbMode($mode){
        $mode = strtolower($mode);
        if($mode == "exact" || $mode == "stretch" || $mode == "crop")
            $this->thumb_mode = $mode;
    }
    
    //The function below is showing you the way to upload picture
    function uploadImg($fieldname = ''){
        //check if another fieldname is specified, or get fieldname that is assigned on initialization
        if($fieldname == "") $fieldname = $this->fieldname;

        //get upload info
        $pic_name = $_FILES[$fieldname]['name'];
        $pic_type = $_FILES[$fieldname]['type'];
        $pic_size = $_FILES[$fieldname]['size'];
        $pic_tmp = $_FILES[$fieldname]['tmp_name'];
        $pic_err = $_FILES[$fieldname]['error'];
    
        //check if file is uploaded, file size must exists
        if($pic_size > 0){
            //save uploaded image
            $fulldir = $this->upload_path;
            
            //check valid filesize
            if($pic_size > $this->max_filesize && $this->max_filesize != 0){
                $this->upload_err = 1;
                $this->upload_err_msg[] = "File too large, limit size $max_filesize byte.";
                return false;
            }
            
            //check if file type is allowed
            if(!isset($this->allow_type[$pic_type])){
                $this->upload_err = 1;
                $this->upload_err_msg[] = "File type not allow";
                return false;
            }
            
            //check if file doesnt exists
            if (file_exists($fulldir.$pic_name)){
                //Confirming that the file is not existing
                $this->upload_err = 1;
                $this->upload_err_msg[] = "The Uploaded 'Best View' image ALREADY EXISTS!<br/>"; 
                return false;
            }
            
            //creating the full directory folder one at a time
            $yr_dir = substr($fulldir, 0, 16);
            
            //check and set folder permission           
            if(!is_dir($yr_dir)) mkdir($yr_dir, 0755);
            if(!is_writable($yr_dir)) chmod($yr_dir, 0755);
            
            //check and set folder permission           
            if(!is_dir($fulldir)) mkdir($fulldir, 0755);
            if(!is_writable($fulldir)) chmod($fulldir, 0755);
        
            //check and set picture file name
            if($this->set_name){
                $pic_name = $this->set_name.".".substr(strrchr($pic_name, "."), 1);
            }else{
                //you may want to append date/time to file name
                //$filename = substr($pic_name, 0, strrpos($pic_name, "."));
                //$ext = substr(strrchr($pic_name, '.'), 1);
                
                //$pic_name = $filename."-".date('YmdHis').".$ext";
                
                
                $filename = substr($pic_name, 0, strrpos($pic_name, "."));
                $ext = substr(strrchr($pic_name, '.'), 1);
                $pic_name = $filename.".$ext";
                $thumbname1 = $filename."-50x50.$ext";
                $thumbname2 = $filename."-150x150.$ext";
                $thumbname3 = $filename."-300x300.$ext";
            }
            
            //save full image
            if(!move_uploaded_file($pic_tmp, $fulldir . $pic_name)) {
                $this->upload_err_msg[] = "File upload fail, could not copy the upload file";
                return false;
            }
        
            //if create_thumb is assigned to true
            if($this->create_thumb){
                //call function to build thumbnail              
                $this->setThumbDimension(50, 50);
                $this->buildThumbnail($pic_name,$thumbname1);
                
                $this->setThumbDimension(150, 150);
                $this->buildThumbnail($pic_name,$thumbname2);

                $this->setThumbDimension(300, 300);          
                $this->buildThumbnail($pic_name,$thumbname3);
            }
            
            //return picture name for another usage
            return $pic_name;
        }else{
            $this->upload_err = 1;
            $this->upload_err_msg[] = "File size is zero";

            return false;
        }
    }
    
    
    
    
    
    
    
    //The function below is about to build the thumbnail from source file specified
    function buildThumbnail($file_name, $thumb_name){
        //set source path
        $fulldir = $this->upload_path;        
        $full_path_img = $fulldir . $file_name;
        
        //set thumbnail path
        $thumbdir = $this->thumbnail_path;
        
        //check if another thumbnail name specified, or use the same name as source file
        if($thumb_name)
            $thumb_path_img = $thumbdir . $thumb_name;
        else
            $thumb_path_img = $thumbdir . $file_name;
        
        //validate source path
        if(is_file($full_path_img)){        
            $image_attribs = getimagesize($full_path_img);
            
            if(!is_dir($thumbdir)) mkdir($thumbdir, 0755);
            if(!is_writable($thumbdir)) chmod($thumbdir, 0755);
            
            //get thumbnail size
            $th_max_width = $this->thumb_width;
            $th_max_height = $this->thumb_height;
            
            //get file mime type, you can try another way if server support the method ;)
            $ext = strtolower(substr(strrchr($full_path_img, '.'), 1));
            switch($ext){
                case "png": $file_mime_type = "image/png"; break;
                case "gif": $file_mime_type = "image/gif"; break;
                case "jpg": $file_mime_type = "image/jpeg"; break;
                case "jpeg": $file_mime_type = "image/jpeg"; break;
                case "wbmp": $file_mime_type = "image/wbmp"; break;
                default: $file_mime_type = "others";
            }
            
            //find ratio of full picture compare to thumbnail
            $ratio_h = ceil(($image_attribs[1]*$th_max_width)/$image_attribs[0]);
            $ratio_w = ceil(($image_attribs[0]*$th_max_height)/$image_attribs[1]);
            
            //create source image
            if (!strcmp($file_mime_type, "image/gif")) {
               $im_old = imagecreatefromgif($full_path_img); 
            } elseif (!strcmp($file_mime_type, "image/pjpeg") || !strcmp($file_mime_type, "image/jpeg")) {
                $im_old = imagecreatefromjpeg($full_path_img); 
            } elseif (!strcmp($file_mime_type, "image/png") || !strcmp($file_mime_type, "image/x-png")) {
               $im_old = imagecreatefrompng($full_path_img); 
            } elseif (!strcmp($file_mime_type, "image/wbmp")) {
               $im_old = imagecreatefromwbmp($full_path_img); 
            } else {
               //die("Image not support");
               $this->upload_err = 1;
               $this->upload_err_msg[] = "Image not support";
            }
            
            switch($this->thumb_mode){
                case "stretch":
                    //proceed stretch mode
                    $th_width = $th_max_width;
                    $th_height = $th_max_height;

                    $im_new = imagecreatetruecolor($th_width,$th_height);
                    
                    // preserve transparency
                    if($file_mime_type == "image/gif" || $file_mime_type == "image/png"){
                        imagecolortransparent($im_new, imagecolorallocatealpha($im_new, 0, 0, 0, 127));
                        imagealphablending($im_new, false);
                        imagesavealpha($im_new, true);
                    }
                    
                    imageCopyResampled($im_new,$im_old,0,0,0,0,$th_width,$th_height, $image_attribs[0], $image_attribs[1]);
                    break;
                case "crop":
                    //proceed crop mode, thumbnail will be calculated at source image center
                    if($ratio_w<$th_max_width){
                        //based on width
                        $ratio = $th_max_width/$image_attribs[0];
                    }else{
                        //based on height
                        $ratio = $th_max_height/$image_attribs[1];
                    }
                    
                    $th_width = $image_attribs[0] * $ratio;
                    $th_height = $image_attribs[1] * $ratio;

                    $im_temp = imagecreatetruecolor($th_width,$th_height);
                    
                    // preserve transparency
                    if($file_mime_type == "image/gif" || $file_mime_type == "image/png"){
                        imagecolortransparent($im_temp, imagecolorallocatealpha($im_temp, 0, 0, 0, 127));
                        imagealphablending($im_temp, false);
                        imagesavealpha($im_temp, true);
                    }
                    
                    imageCopyResampled($im_temp,$im_old,0,0,0,0,$th_width,$th_height, $image_attribs[0], $image_attribs[1]);
                    
                    $x0 = ( $th_width - $th_max_width ) / 2;
                    $y0 = ( $th_height - $th_max_height ) / 2;
                    
                    $im_new = imagecreatetruecolor( $th_max_width, $th_max_height );
                    
                    // preserve transparency
                    if($file_mime_type == "image/gif" || $file_mime_type == "image/png"){
                        imagecolortransparent($im_new, imagecolorallocatealpha($im_new, 0, 0, 0, 127));
                        imagealphablending($im_new, false);
                        imagesavealpha($im_new, true);
                    }
                    
                    imagecopy($im_new, $im_temp, 0, 0, $x0, $y0, $th_max_width, $th_max_height);
                    break;
                default:
                    //proceed exact mode
                    if($ratio_w<$th_max_width){
                        //based on height
                        $ratio = $th_max_height/$image_attribs[1];
                    }else{
                        //based on width
                        $ratio = $th_max_width/$image_attribs[0];
                    }
                    
                    $th_width = $image_attribs[0] * $ratio;
                    $th_height = $image_attribs[1] * $ratio;

                    $im_new = imagecreatetruecolor($th_width,$th_height);
                    
                    // preserve transparency
                    if($file_mime_type == "image/gif" || $file_mime_type == "image/png"){
                        imagecolortransparent($im_new, imagecolorallocatealpha($im_new, 0, 0, 0, 127));
                        imagealphablending($im_new, false);
                        imagesavealpha($im_new, true);
                    }
                    
                    imageCopyResampled($im_new,$im_old,0,0,0,0,$th_width,$th_height, $image_attribs[0], $image_attribs[1]);
                    break;
            }
            
            //output thumbnail            
            if (!strcmp($file_mime_type, "image/gif") && function_exists("imagegif")) {
               imagegif($im_new,$thumb_path_img);
            } elseif (!strcmp($file_mime_type, "image/pjpeg") || !strcmp($file_mime_type, "image/jpeg") && function_exists("imagejpeg")) {
               imagejpeg($im_new,$thumb_path_img,100); 
            } elseif ((!strcmp($file_mime_type, "image/png") || !strcmp($file_mime_type, "image/x-png")) && function_exists("imagepng")) {
               imagepng($im_new,$thumb_path_img);
            } elseif (!strcmp($file_mime_type, "image/wbmp") && function_exists("imagewbmp")) {
               imagewbmp($im_new,$thumb_path_img);
            }elseif(function_exists("imagejpeg")){
                imagejpeg($im_new,$thumb_path_img,100);
            }
            
        }
    }


} //end of class
?>