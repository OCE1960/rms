<?php
 namespace App\Traits;
 use Request;

 trait UploadFile {

    public function storeFile($request, $file_name){

        if($request->hasFile($file_name)){
            $extension = $request->file($file_name)->getClientOriginalExtension();
            $attachedFileName = time() . '.' . $extension;
            $request->file($file_name)->move(public_path('uploads'), $attachedFileName);
            $path_to_file = public_path('uploads').'/'.$attachedFileName;
            return $path_to_file;
        }
        
    }

    public function storeDocument($request, $file_name){

        if($request->hasFile($file_name)){
            $extension = $request->file($file_name)->getClientOriginalExtension();
            $attachedFileName = time() . '.' . $extension;
            $request->file($file_name)->move(public_path('uploads'), $attachedFileName);
            $path_to_file = 'uploads/'.$attachedFileName;
            return $path_to_file;
        }
        
    }

 }