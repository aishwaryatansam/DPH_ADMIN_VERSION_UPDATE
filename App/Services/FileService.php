<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileService {




	/*
	 * this file is used to save the single images. 	 
	 * Output will be an array.
	*/
	public static function storeFile($file,$root='/') {

		if(!$file->isValid()) {
			return false;
		}

		/*if(!empty($file) && count($file->toArray())) {
			return static::storeFileArr($file,$root);
		}*/

		$disk = storageDisk();
		$originalFilename = $file->getClientOriginalName();
		$extension = $file->getClientOriginalExtension();
		$size = $file->getSize();
		$saltedFilename = saltFileName($originalFilename);

		$response = Storage::disk($disk)->putFileAs($root,$file,$saltedFilename);
		
		$returnArray = array();
		$returnArray['original_filename'] = $originalFilename;
		$returnArray['stored_filename'] = $saltedFilename;
		$returnArray['extension'] = $extension;
		$returnArray['size'] = $size;
		$returnArray['disk'] = $disk;
		$returnArray['path'] = $root;
		$returnArray['stored_file_path'] = $response;

		return $returnArray;
	}

	public static function storeAndReturnID($file,$directory) {
		$fileObj = new File();
		$file_storage_array = static::storeFile($file,$directory);
		if(!$file_storage_array) {
			return NULL;
		}
        $fileObj->fill($file_storage_array)->save();  
        return $fileObj->id;
	}

	public static function updateAndReturnID($new_file,$new_root,$old_id,$fileCollection) {

		$fileObj = new File();

		static::deleteFile($fileCollection);

		$file_storage_array = static::storeFile($new_file,$new_root);

		if($old_id && $file_storage_array){
			$fileObj->find($old_id)->fill($file_storage_array)->save();  	
		}
        

        return true;
	}


	/*
	 * this file is used to save the array type of images. 
	 * Here we called the single file put method in loop.
	 * Output will be dimensional array.
	*/
	public static function storeFileArr($file,$root='/') {

		$returnArray = array();
		foreach ($file as $eachFile) {
			if($eachFile->isValid()) {
				$returnArray[] = static::storeFile($eachFile,$root);
			}
		}

		return $returnArray;
	}

	public static function splitFilePath($file_path_with_name) {

		$exploded_filepath = explode('/', $file_path_with_name);

		$filename = last($exploded_filepath);

		$exploded_filename = explode('.', $filename);

		if(!count($exploded_filename)) {
			return $file_path_with_name;
		}

		array_pop($exploded_filepath);

		$root = implode('/', $exploded_filepath);			

		return array('filename' => $filename,'root'=>$root);		
	}

	/*
	* this function will retrieve and show the given filename based on given routes.
	*/
	public static function showFile($filename,$root='/',$disk='') {
		
		$disk = storageDisk($disk);
		
		/*if file not exists no image will be returned*/
		if(!static::fileExists($filename,$root,$disk)) {

			return NULL;			
		}

		return Storage::disk($disk)->url($root.'/'.$filename);	
		
	}

	/*
	 * this function will check if file exists in storage directory or not,
	 * respose will be in boolean
	*/
	public static function fileExists($filename,$root='/',$disk=''){

		$disk = storageDisk($disk);

		return Storage::disk($disk)->exists($root.'/'.$filename);
	}

	/*
	 * This updateImage function having four parameter, 
	 * it will remove the old image based on old_filename and its root path
	 * it will put new file into the given root , here we called storeFile function.
	*/
	public static function updateAndStoreFile($new_file,$new_root,$old_filename,$old_root='/',$disk='') {


		static::deleteDiskFile($old_filename,$old_root);

		return static::storeFile($new_file,$new_root);
	}

	public static function deleteDiskFile($filename,$old_root) {
		$old_filename = $filename;
		$disk = storageDisk();		
		// dd($old_filename,$old_root);
		if($old_filename && $old_root && static::fileExists($old_filename,$old_root)) {
			Storage::disk($disk)->delete($old_root.'/'.$old_filename);
		}
		return true;
	}
	public static function deleteFile($fileCollection) {

		$old_filename = $fileCollection->stored_filename;
		$old_root = $fileCollection->path;
 		$disk = $fileCollection->disk;

		$disk = storageDisk($disk);		
		
		if($old_filename && $old_root && static::fileExists($old_filename,$old_root)) {
			Storage::disk($disk)->delete($old_root.'/'.$old_filename);
		}
		return true;
	}
}



 
