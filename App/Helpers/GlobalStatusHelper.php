<?php

function _getGlobalStatus() {
	return array_flip(config('constant.status'));
}

function _active() {
	$statusArr = _getGlobalStatus();
	return $statusArr['Active'] ?? '';
}

function _inactive() {
	$statusArr = _getGlobalStatus();
	return $statusArr['InActive'] ?? '';
}

function _isPostVacant() {
	return (config('constant.yes_or_no'));
}

function _yes() {
	$statusArr = _isPostVacant();
	return $statusArr['yes'] ?? '';
}

function _no() {
	$statusArr = _isPostVacant();
	return $statusArr['no'] ?? '';
}

function _isUrban() {
	return (config('constant.yes_or_no'));
}

function _urban() {
	$statusArr = _isUrban();
	return $statusArr['yes'] ?? '';
}

function _notUrban() {
	$statusArr = _isUrban();
	return $statusArr['no'] ?? '';
}

function _published() {
	$statusArr = _getGlobalStatus();
	return $statusArr['Published'] ?? '';
}

function findStatus($id) {
	$statusArr = config('constant.status');
	return $statusArr[$id] ?? '--';
}
