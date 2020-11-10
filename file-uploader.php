<?php

    /**
     *
     *  PHP Utilities - File Uploader
     *  @see https://github.com/andreazorzi/php-utilities
     *  @author Andrea Zorzi (andreazorzi) <info@zorziandrea.com>
     *  @version 1.0.0
     *
     */
    
    /**
     *
     *  Upload single file on server
     *  
     *  @param  Array   $file       $_FILES["file_name"] variable
     *  @param  String  $folder     The folder where to save the file
     *  @param  Array   $settings   {
     *          Additional settings
     *          
     *          @param  Array   $accept         File extensions accepted, must start with dot, if not set, it does not accept any file
     *          @param  String  $nameformat     Pattern to set the new file name, if not set, it keeps the original name
     *          @param  int     $iterator       Starting iterator number
     *  }
     *  
     *  @return int     Status code indicating whether the operation was successful {
     *          0: The operation was successful
     *          1: An error occurred with the uploaded file
     *          2: The uploaded file is not an allowed type
     *          3: The file was not saved
     *  }
     *
     */
    function singleFileUpload(&$file, $folder, $settings = array()){
        checkFolder($folder);
        
        if(!isset($settings["iterator"])){
            $settings["iterator"] = 0;
        }
        
        if(isset($file) && $file["error"] == 0){
            $fileinfo = getFileInfo($file["name"]);
            $filename = $file["name"];
            
            if(isset($settings["accept"]) && !in_array($fileinfo["ext"], $settings["accept"])){
                return 2;
            }
            
            if(isset($settings["nameformat"])){
                $filename = $settings["nameformat"];
                $filename = str_replace("{filename}", $fileinfo["name"], $filename);
                $filename = str_replace(".{ext}", $fileinfo["ext"], $filename);
                $filename = str_replace("{t}", time(), $filename);
                $filename = str_replace("{i}", $settings["iterator"], $filename);
                
                $settings["iterator"] += 1;
            }
            
            if(file_put_contents($folder.$filename, file_get_contents($file["tmp_name"])) !== false){
                return 0;
            }
            
            return 3;
        }
        
        return 1;
    }
    
    /**
     *
     *  Upload miltiple files on server
     *  
     *  @param  Array   $file       $_FILES["file_name"] variable
     *  @param  String  $folder     The folder where to save the file
     *  @param  Array   $settings   {
     *          Additional settings
     *          
     *          @param  Array   $accept         File extensions accepted, must start with dot, if not set, it does not accept any file
     *          @param  String  $nameformat     Pattern to set the new file name, if not set, it keeps the original name
     *          @param  int     $iterator       Starting iterator number
     *  }
     *  
     *  @return Array   Array of status codes for each uploaded files indicating whether the operation was successful {
     *          0: The operation was successful
     *          1: An error occurred with the uploaded file
     *          2: The uploaded file is not an allowed type
     *          3: The file was not saved
     *  }
     *
     */
    function multipleFileUpload(&$file, $folder, $settings = array()){
        checkFolder($folder);
        
        if(!isset($settings["iterator"])){
            $settings["iterator"] = 0;
        }
        
        $res = array();
        
        for($i = 0; $i < count($file["name"]); $i++){
            $status = 0;
            
            if($file["error"][$i] == 0){
                $fileinfo = getFileInfo($file["name"][$i]);
                $filename = $file["name"][$i];
                
                if(isset($settings["accept"]) && !in_array($fileinfo["ext"], $settings["accept"])){
                    $res[] = 2;
                }
                else{
                    if(isset($settings["nameformat"])){
                        $filename = $settings["nameformat"];
                        $filename = str_replace("{filename}", $fileinfo["name"], $filename);
                        $filename = str_replace(".{ext}", $fileinfo["ext"], $filename);
                        $filename = str_replace("{t}", time(), $filename);
                        $filename = str_replace("{i}", $settings["iterator"], $filename);
                        
                        $settings["iterator"] += 1;
                    }
                    
                    if(file_put_contents($folder.$filename, file_get_contents($file["tmp_name"][$i])) !== false){
                        $res[] = 0;
                    }
                    else{
                        $res[] = 3;
                    }
                }
            }
            else{
                $res[] = 1;
            }
        }
        
        return $res;
    }
    
    /**
     *
     *  Check if the passed folder exists, in case the folder is created
     *  
     *  @param  String  $folder     The folder path to check
     *
     */
    function checkFolder($folder){
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }
    
    /**
     *
     *  Get the information of a given file
     *  
     *  @param  String  $filename   The path of the file to check
     *  
     *  @return Array   Array that contains the name and extension of the file
     *
     */
    function getFileInfo($filename){
        $pathinfo = pathinfo($filename);
        
        return array(
            "ext" => isset($pathinfo["extension"]) ? ".".$pathinfo["extension"] : "",
            "name" => isset($pathinfo["filename"]) ? $pathinfo["filename"] : ""
        );
        
        isset($pathinfo["extension"]) ? $pathinfo["extension"] : "";
    }

?>
