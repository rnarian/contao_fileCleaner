<?php
    class fileCleaner extends Backend {
        public function process($arrFiles){
            foreach($arrFiles as $file){
                $getFile        = $this->Database->prepare("SELECT * FROM tl_files WHERE path = ?")->execute($file);
                $newFilename    = standardize(str_replace(".".$getFile->extension,"",strtolower($getFile->name)));
                
                $directory      = str_replace($getFile->name, "", $getFile->path);
                
                $newFile        = "../".$directory.$newFilename.".".$getFile->extension;;
                
                if(is_file($newFile)){
                    $newFilename = $newFilename."-".$getFile->id;
                }
                $newFilename = $newFilename.".".$getFile->extension;
                
                rename("../".$file, "../".$directory.$newFilename);
                
                $this->Database->prepare("UPDATE tl_files SET path = ?, name = ? WHERE id = ?")->execute($directory.$newFilename,$newFilename,$getFile->id);
                
            }
        }
    }
?>