<?php

use App\Models\ApprovalWorkflows;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function paymentStatuses()
{

	return [
		['id' => 1, 'name' => 'Pending'],
		['id' => 2, 'name' => 'Paid'],
	];
}


function findPaymentStatus($id)
{

	$statusArr = paymentStatuses();
	return collect($statusArr)->where('id', $id)->first()['name'] ?? '';
}

function defaultCountryCode()
{
	return "+91";
}

function _superAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['Super Admin'] ?? '';
}

function _subAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['Sub Admin'] ?? '';
}

function _stateAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['State'] ?? '';
}

function _districtAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['District'] ?? '';
}

function _hudAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['HUD'] ?? '';
}

function _blockAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['Block'] ?? '';
}

function _phcAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['PHC'] ?? '';
}

function _hscAdminUserTypeId()
{
	return array_flip(config('constant.user_type'))['HSC'] ?? '';
}

function _employeeUserTypeId()
{
	return array_flip(config('constant.user_type'))['Employee'] ?? '';
}

function _hudUserTypeId()
{
	return array_flip(config('constant.user_type'))['HUD'] ?? '';
}

function _adminUserRole()
{
	return array_flip(config('constant.user_role'))['Admin-user'] ?? '';
}


function findUserType($id)
{

	$user_types = config('constant.user_type');
	$user_type_label = $user_types[$id] ?? '';
	if ($user_type_label == 'Employee') {
		$user_type_label = 'USER';
	}
	return strtoupper($user_type_label);
}

function findUserRole($id)
{

	$user_types = config('constant.user_role');
	$user_type_label = $user_types[$id] ?? '';
	return strtoupper($user_type_label);
}

function findFacilityLevel($id)
{

	$facility_levels = config('constant.facility_level');
	$facility_level_label = $facility_levels[$id] ?? '';
	return $facility_level_label;
}

function findTestimonialRole($id)
{

	$testimonials_type = config('constant.testimonial_type');
	$testimonial_type_label = $testimonials_type[$id] ?? '';
	return $testimonial_type_label;
}

function isAdmin()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	$usertypes = array_flip(config('constant.user_type'));
	return in_array((int)$user_type_id, [$usertypes['Super Admin'], $usertypes['Sub Admin']]);
}

function isState()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	$usertypes = array_flip(config('constant.user_type'));
	return in_array((int)$user_type_id, [$usertypes['State']]);
}

function isDistrict()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	$usertypes = array_flip(config('constant.user_type'));
	return in_array((int)$user_type_id, [$usertypes['District']]);
}

function isHUD()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	$usertypes = array_flip(config('constant.user_type'));
	return in_array((int)$user_type_id, [$usertypes['HUD']]);
}

function isBlock()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	$usertypes = array_flip(config('constant.user_type'));
	return in_array((int)$user_type_id, [$usertypes['Block']]);
}

function isPHC()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	$usertypes = array_flip(config('constant.user_type'));
	return in_array((int)$user_type_id, [$usertypes['PHC']]);
}

function isHSC()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	$usertypes = array_flip(config('constant.user_type'));
	return in_array((int)$user_type_id, [$usertypes['HSC']]);
}

function isApprover()
{
	$user_role_id = auth()->user()->user_role_id ?? 3;
	$userroles = array_flip(config('constant.user_role'));
	return in_array((int)$user_role_id, [$userroles['Admin-approver']]);
}

function isVerifier()
{
	$user_role_id = auth()->user()->user_role_id ?? 3;
	$userroles = array_flip(config('constant.user_role'));
	return in_array((int)$user_role_id, [$userroles['Admin-verifier']]);
}

function isUser()
{
	$user_role_id = auth()->user()->user_role_id ?? 3;
	$userroles = array_flip(config('constant.user_role'));
	return in_array((int)$user_role_id, [$userroles['Admin-user']]);
}


function isEmployee()
{
	$user_type_id = auth()->user()->user_type_id ?? 0;
	return (int)$user_type_id == array_flip(config('constant.user_type'))['Super Admin'];
}

function _hudContactType()
{
	return array_flip(config('constant.contact_types'))['hud'] ?? '';
}

function _blockContactType()
{
	return array_flip(config('constant.contact_types'))['block'] ?? '';
}

function _phcContactType()
{
	return array_flip(config('constant.contact_types'))['phc'] ?? '';
}

function _hscContactType()
{
	return array_flip(config('constant.contact_types'))['hsc'] ?? '';
}

function formatDate($date)
{
	return Carbon::parse($date)->format('d-m-Y H:i');
}
function getConstructionStatus($statusKey)
{
	$constructionStatus = config('constant.under_construction_status');
	return $constructionStatus[$statusKey] ?? 'Unknown Status'; // Fallback if status is not found
}

function findProcessedBy($currentStage, $id)
{
	$stageToUserField = [
		'hsc_upload' => 'user',
		'phc_upload' => 'user',
		'block_upload' => 'user',
		'hud_upload' => 'user',
		'district_upload' => 'user',
		'state_upload' => 'user',
		'phc_verify' => 'phcVerifier',
		'block_verify' => 'blockVerifier',
		'block_approve' => 'blockApprover',
		'hud_verify' => 'hudVerifier',
		'hud_approve' => 'hudApprover',
		'state_verify' => 'stateVerifier',
		'state_approve' => 'stateApprover',
		'published' => 'superAdmin',
		'returned_with_remarks' => 'returnedUser',
		'rejected_with_remarks' => 'rejectedUser'
	];

	if (!array_key_exists($currentStage, $stageToUserField)) {
		return null;
	}
	$relationship = $stageToUserField[$currentStage];
	// dd($relationship);

	$workflow = ApprovalWorkflows::find($id);
	if (!$workflow) {
		return null;
	}
	$user = $workflow->{$relationship};
	return $user ? $user->name : 'Unknown User';
}

function getStageBadge($currentStage)
{
	$stageBadges = [
		'hsc_upload' => '<span class="badge bg-info">HSC UPLOAD</span>',
		'phc_upload' => '<span class="badge bg-info">PHC UPLOAD</span>',
		'block_upload' => '<span class="badge bg-info">BLOCK UPLOAD</span>',
		'hud_upload' => '<span class="badge bg-info">HUD UPLOAD</span>',
		'state_upload' => '<span class="badge bg-info">STATE UPLOAD</span>',
		'phc_verify' => '<span class="badge bg-primary">PHC VERIFIED</span>',
		'block_verify' => '<span class="badge bg-primary">BLOCK VERIFIED</span>',
		'hud_verify' => '<span class="badge bg-primary">HUD VERIFIED</span>',
		'state_verify' => '<span class="badge bg-primary">STATE VERIFIED</span>',
		'block_approve' => '<span class="badge bg-success">BLOCK APPROVED</span>',
		'hud_approve' => '<span class="badge bg-success">HUD APPROVED</span>',
		'state_approve' => '<span class="badge bg-success">STATE APPROVED</span>',
		'published' => '<span class="badge bg-purple">Published</span>',
		'returned_with_remarks' => '<span class="badge bg-danger">Returned with Remarks</span>',
		'rejected_with_remarks' => '<span class="badge bg-dark">Rejected with Remarks</span>',
	];

	return $stageBadges[$currentStage] ?? '<span class="badge bg-purple">Published</span>';
}


function getApprovalData()
{
	$approvalData = [
		'current_stage' => 'hsc_upload',
		'super_admin_id' => null,
		'state_approve_id' => null,
		'hud_approve_id' => null,
		'block_approve_id' => null,
		'phc_verify_id' => null,
		'block_verify_id' => null,
		'hud_verify_id' => null,
		'state_verify_id' => null,
		
	];

	$uploadedBy = Auth::user()->id;

	if (isHSC()) {
		$approvalData['current_stage'] = 'hsc_upload';
	} elseif (isPHC() && isUser()) {
		$approvalData['current_stage'] = 'phc_upload';
	} elseif (isPHC() && isVerifier()) {
		$approvalData['current_stage'] = 'phc_verify';
		$approvalData['phc_verify_id'] = $uploadedBy;
	} elseif (isBlock() && isUser()) {
		$approvalData['current_stage'] = 'block_upload';
	} elseif (isBlock() && isVerifier()) {
		$approvalData['current_stage'] = 'block_verify';
		$approvalData['block_verify_id'] = $uploadedBy;
	} elseif (isBlock() && isApprover()) {
		$approvalData['current_stage'] = 'block_approve';
		$approvalData['block_approve_id'] = $uploadedBy;
	} elseif (isHUD() && isUser()) {
		$approvalData['current_stage'] = 'hud_upload';
	} elseif (isHUD() && isVerifier()) {
		$approvalData['current_stage'] = 'hud_verify';
		$approvalData['hud_verify_id'] = $uploadedBy;
	} elseif (isHUD() && isApprover()) {
		$approvalData['current_stage'] = 'hud_approve';
		$approvalData['hud_approve_id'] = $uploadedBy;
	} elseif (isState() && isUser()) {
		$approvalData['current_stage'] = 'state_upload';
	} elseif (isState() && isVerifier()) {
		$approvalData['current_stage'] = 'state_verify';
		$approvalData['state_verify_id'] = $uploadedBy;
	} elseif (isState() && isApprover()) {
		$approvalData['current_stage'] = 'state_approve';
		$approvalData['state_approve_id'] = $uploadedBy;
	} elseif (isAdmin()) {
		$approvalData['current_stage'] = 'published';
		$approvalData['super_admin_id'] = $uploadedBy;
	}

	return $approvalData;
}

function getImageType($imageType)
{
    return array_flip(config('constant.image_type'))[$imageType] ?? '';
}

function getDocumentType($documentType)
{
    return array_flip(config('constant.document_type'))[$documentType] ?? '';
}
