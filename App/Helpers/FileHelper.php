<?php

use App\Services\FileService;

function storageDisk($disk='') {
	
	return ($disk)?$disk:config('constant.file_storage_disk');	
}

function noImage() {
	
	return NULL;
}

function showDiskImage($image_path='') {

	if(!$image_path){
		return $image_path;
	}
	return ($image_path && $image_path!='/')?FileService::showFile($image_path):NULL;         
}

function humanFileSize($bytes, $decimals = 2) {
    $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    $factor = floor((strlen($bytes) - 1) / 3);
    return number_format($bytes / pow(1024, $factor), $decimals) . ' ' . @$sizes[$factor];
}
