<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ApprovalWorkflows;
use App\Models\EventUpload;
use Illuminate\Support\Facades\Auth;

class EventUploadApprovalController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        // dd($userId);
        $results = ApprovalWorkflows::getQueriedResult('App\Models\EventUpload');
        $pushedDocs = ApprovalWorkflows::getQueriedResult('App\Models\EventUpload', ['published']);
        $verifiedDocs = ApprovalWorkflows::getQueriedResult('App\Models\EventUpload', ['phc_verify', 'block_verify', 'hud_verify', 'state_verify']);
        $approvedDocs = ApprovalWorkflows::getQueriedResult('App\Models\EventUpload', ['phc_approve', 'block_approve', 'hud_approve', 'state_approve']);
        $pendingDocs = ApprovalWorkflows::getQueriedResult('App\Models\EventUpload', ['hsc_upload', 'phc_upload', 'block_upload', 'hud_upload', 'state_upload']);
        $returnedDocs = ApprovalWorkflows::getQueriedResult('App\Models\EventUpload', ['returned_with_remarks']);
        $rejectedDocs = ApprovalWorkflows::getQueriedResult('App\Models\EventUpload', ['rejected_with_remarks']);
        // dd($results['paginatedResult']->toarray());
        return view('admin.approval-management.eventupload.list', compact('results', 'pushedDocs', 'verifiedDocs', 'approvedDocs', 'pendingDocs', 'returnedDocs', 'rejectedDocs', 'userId'));
    }

    public function handleAction($documentId, $action, Request $request)
    {
        $document = ApprovalWorkflows::find($documentId);

        $upload_event = EventUpload::find($document->model_id);
        if (!$document) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $user = auth()->user();


        $resubmitStages = [
            6 => [ 
                3 => 'hsc_upload',  
            ],

            5 => [
                1 => 'phc_upload',
                2 => 'phc_verify',   
                3 => 'phc_upload',
            ],

            4 => [
                1 => 'block_upload',
                2 => 'block_verify',
                3 => 'block_upload',  
            ],

            3 => [ 
                1 => 'hud_upload',  
                2 => 'hud_verify',   
                3 => 'hud_upload',    
            ],

            2 => [ 
                1 => 'district_uplaod',    
            ],

            1 => [ 
                1 => 'state_upload', 
                2 => 'state_verify',   
                3 => 'state_upload',    
            ],
        ];

        switch ($action) {
            case 'phc_verify':
                if ($document->current_stage == 'hsc_upload' || $document->current_stage == 'phc_upload') {
                    $document->current_stage = 'phc_verify';
                    $document->phc_verify_id = $user->id;
                    $document->phc_verify_at = now();
                    $document->save();
                    return createdResponse("Document Verified Successfully");
                }
                break;

            case 'block_verify':
                if ($document->current_stage == 'block_upload') {
                    $document->current_stage = 'block_verify';
                    $document->block_verify_id = $user->id;
                    $document->block_verify_at = now();
                    $document->save();
                    return createdResponse("Document Verified Successfully");
                }
                break;

            case 'hud_verify':
                if ($document->current_stage == 'hud_upload' || $document->current_stage == 'block_approve') {
                    $document->current_stage = 'hud_verify';
                    $document->hud_verify_id = $user->id;
                    $document->hud_verify_at = now();
                    $document->save();
                    return createdResponse("Document Verified Successfully");
                }
                break;

            case 'state_verify':
                if ($document->current_stage == 'state_upload' || $document->current_stage == 'district_upload' || $document->current_stage == 'hud_approve') {
                    $document->current_stage = 'state_verify';
                    $document->state_verify_id = $user->id;
                    $document->state_verify_at = now();
                    $document->save();
                    return createdResponse("Document Verified Successfully");
                }
                break;

            case 'block_approve':
                if ($document->current_stage == 'phc_verify' || $document->current_stage == 'block_verify') {
                    $document->current_stage = 'block_approve';
                    $document->block_approve_id = $user->id;
                    $document->block_approve_at = now();
                    $document->save();
                    return createdResponse("Document Approved Successfully");
                }
                break;

            case 'hud_approve':
                if ($document->current_stage == 'hud_verify') {
                    $document->current_stage = 'hud_approve';
                    $document->hud_approve_id = $user->id;
                    $document->hud_approve_at = now();
                    $document->save();
                    return createdResponse("Document Approved Successfully");
                }
                break;

            case 'state_approve':
                if ($document->current_stage == 'state_verify') {
                    $document->current_stage = 'state_approve';
                    $document->state_approve_id = $user->id;
                    $document->state_approve_at = now();
                    $document->save();
                    return createdResponse("Document Approved Successfully");
                }
                break;


            case 'publish':
                if ($document->current_stage == 'state_approve') {
                    $document->current_stage = 'published';
                    $document->super_admin_id = $user->id;
                    $document->save();
                    $upload_event->status = 1;
                    $upload_event->save();
                    return createdResponse("Document Published Successfully");
                }
                break;

            case 'return':
                if ($document->status !== 'published') {
                    $document->current_stage = 'returned_with_remarks';
                    $document->returned_user_id = $user->id;
                    $document->remarks = $request->remarks;
                    $document->save();
                    return createdResponse("Document returned with remarks successfully.");
                }
                break;

            case 'reject':
                if ($document->status !== 'published') {
                    $document->current_stage = 'rejected_with_remarks';
                    $document->rejected_user_id = $user->id;
                    $document->remarks = $request->remarks;
                    $document->save();
                    return createdResponse("Document Rejected with remarks successfully.");
                }
                break;

            case 'resubmit':
                if ($document->current_stage == 'returned_with_remarks') {

                    $nextStage = $resubmitStages[$user->user_type_id][$user->user_role_id] ?? null;
                    // dd($nextStage);
                    if ($nextStage) {
                        $document->current_stage = $nextStage;
                        $document->remarks = null;
                        $document->save();

                        return createdResponse("Document Resubmitted Successfully to stage: {$nextStage}");
                    } else {
                        return createdResponse("No valid stage transition for this user type and role.", 400);
                    }
                }
                break;

            default:
                return response()->json(['message' => 'Invalid action'], 400);
        }

        return response()->json(['message' => 'Action not allowed for the current stage'], 400);
    }

    public function performBulkAction(Request $request)
    {
        $action = $request->input('action');
        $remarks = $request->input('remarks');
        $documentIds = $request->input('documentIds');

        if (empty($documentIds)) {
            return response()->json(['success' => false, 'message' => 'No documents selected.']);
        }

        try {
            foreach ($documentIds as $id) {
                $document = EventUpload::find($id);

                if ($document) {
                    switch ($action) {
                        case 'publish':
                            $document->current_stage = 'published';
                            break;
                        case 'approve':
                            $document->current_stage = 'approved';
                            break;
                        case 'verify':
                            $document->current_stage = 'verified';
                            break;
                        case 'return':
                            $document->current_stage = 'returned_with_remarks';
                            $document->remarks = $remarks;
                            break;
                        case 'reject':
                            $document->current_stage = 'rejected_with_remarks';
                            $document->remarks = $remarks;
                            break;
                    }
                    $document->save();
                }
            }

            return response()->json(['success' => true, 'message' => ucfirst($action) . ' action completed successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
