<?php


function sendResponse($data = [],$message='OK',$code = 200) {

	return response()->json([
		'status' => true,
		'message' => $message,
		'data' => $data,
		'errors' => [],
		'code' => $code,
	]);
}

function sendError($errors = [],$message='Error',$code = 400) {

	return response()->json([
		'status' => false,
		'message' => $message,
		'data' => [],
		'errors' => $errors,
		'code' => $code,
	]);
}

function _Ok() {
	return 200;
}

function _Created() {
	return 201;
}

function _BadRequest() {
	return 400;
}

function _Unauthorized() {
	return 401;
}

function _Forbidden() {
	return 403;
}

function _NotFound() {
	return 404;
}

function _MethodNotAllowed() {
	return 405;
}

function _Conflict() {
	return 409;
}

function _InternalServerError() {
	return 500;
}

function _ServiceNotAvailable() {
	return 503;
}

