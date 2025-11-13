<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('register',function(){
	return redirect('/login');
});

// Route::get('password/reset',function(){
// 	return redirect('/login');
// })->name('password.request');

Route::middleware(['auth'])->group(function () {
	Route::get('/change-password','Admin\PasswordController@managePassword')->name('password.manage');
	Route::post('/update-password','Admin\PasswordController@updatePassword')->name('password.mupdate');
	Route::get('/manage-user-password/{id}','Admin\PasswordController@manageUserPassword');
	Route::get('/dashboard','Admin\DashboardController@dashboard')->name('admin.dashboard');
	Route::resource('/documents','Admin\DocumentController');
	Route::resource('/new-documents','Admin\NewDocumentController');
	Route::resource('/event-upload','Admin\EventUploadController');
	Route::get('/consolidate-export','Admin\HudController@consolidateReport');
	Route::get('/reports', 'Admin\ReportController@reportView');
});

Route::middleware(['admin'])->group(function () {


	Route::post('send-invitation','Admin\UserController@sendInvitation');
	Route::resource('/users','Admin\UserController');
	Route::get('/users-export','Admin\UserController@export')->name('users.export');
	// Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
	Route::get('/export-users', 'Admin\UserController@export')->name('export.users');

	// Route::get('/users/all-data', [UserController::class, 'getAllData'])->name('users.all-data');
	// Route::get('/users/download-excel', [UserController::class, 'downloadExcel'])->name('users.downloadExcel');


	Route::resource('/programs','Admin\ProgramController');
	Route::get('/programs-export', 'Admin\ProgramDetailController@export')->name('programsdetail.export');
	Route::get('/programs-divisions/export', 'Admin\ProgramController@export')->name('programsanddivision.export');

	Route::resource('/sections','Admin\SectionController');
	Route::get('/sections-export', 'Admin\SectionController@export')->name('sections.export');

	Route::resource('/schemes','Admin\SchemeController');
	Route::get('/schemesDetails-export','Admin\SchemeDetailController@export')->name('schemeDetails.export');


    Route::get('districts/export', [App\Http\Controllers\Admin\DistrictController::class, 'export'])->name('districts.export');
	Route::resource('/districts','Admin\DistrictController');
	Route::resource('/designations','Admin\DesignationController');
	Route::resource('/welcome-banner','Admin\WelcomeBannerController');
	Route::resource('/facilitytypes','Admin\FacilityTypeController');

	Route::resource('/masters','Admin\MasterController');
	Route::get('/master-export', 'Admin\MasterController@export')->name('master.export');
    Route::post('track-visitor', ['VisitorController::class', 'trackVisitor']);
	Route::resource('/about-us','Admin\PageController');
	Route::resource('/submenu','Admin\SubmenuController');
	Route::get('/ethics-committee','Admin\SiteController@getEhicsCommittee');
	Route::post('/ethics_committee/update','Admin\SiteController@updateEhicsCommittee');
	Route::post('/scientific_advisory_committee/update','Admin\SiteController@updateScientificAdvisoryCommittee');
	Route::post('/ethics_committee/store_banner','Admin\SiteController@storeBanner');
	Route::post('/ethics_committee/update_banner','Admin\SiteController@updateBanner');
	Route::post('/ethics_committee/store_member','Admin\SiteController@storeMember');
	Route::post('/ethics_committee/update_member','Admin\SiteController@updateMember');
	Route::post('/ethics_committee/store_certificate','Admin\SiteController@storeCertificate');
	Route::post('/ethics_committee/update_certificate','Admin\SiteController@updateCertificate');

	Route::get('/scientific-advisory-committee','Admin\SiteController@getScientificAdvisoryCommittee');
	Route::resource('/dph-newsletter','Admin\DphNewsletterController');
	Route::get('/huds-export','Admin\HudController@export')->name('huds.export');

	Route::resource('/divisions', 'Admin\DivisionController');
	Route::get('/divisions-export','Admin\DivisionController@export')->name('divisions.export');

	// Route::resource('/bulk-mailers','Admin\BulkMailerController');
	Route::resource('/testimonials','Admin\TestimonialController');
	Route::resource('/social-media','Admin\SocialMediaController');
// Social- media- post
    Route::resource('/social-media-post','Admin\SocialMediaPostController');
    // Media - Gallery
    Route::resource('/media-gallery','Admin\MediaGalleryController');
    Route::resource('/anti-curruption','Admin\AntiCurruptionController');
    Route::resource('/rti-officer','Admin\RtiOfficerController');
    // RTI - Upload PDF
    Route::post('/rti-contact-pdf','Admin\RtiOfficerController@RTI_Contact_PDF')->name('rti-contact-pdf');

    Route::resource('/facility-profile','Admin\FacilityProfileController');

	Route::resource('/partner','Admin\PartnerController');
	Route::resource('/scroller-notif','Admin\ScrollerController');
	Route::resource('/dph-icon','Admin\DphiconController');
	Route::resource('/header', 'Admin\HeaderController');
	Route::post('/header/update-logo', 'Admin\HeaderController@updateHeaderLogo')->name('header.updatelogo');
	Route::post('/header/store-banner', 'Admin\HeaderController@storeBanner')->name('header.storebanner');
	Route::post('/header/update-banner', 'Admin\HeaderController@updateBanner')->name('header.updatebanner');
	Route::post('/header/store-button', 'Admin\HeaderController@storeButton')->name('header.storeButton');
	Route::post('/header/update-button', 'Admin\HeaderController@updateButton')->name('header.updateButton');
	Route::get('/header', 'Admin\HeaderController@edit')->name('header.edit');
	Route::post('/header/update/{id}', 'Admin\HeaderController@updateHeader')->name('header.update');

	Route::get('/footer', 'Admin\FooterController@edit');
	Route::post('/footer/store-logo', 'Admin\FooterController@storeLogo')->name('footer.storelogo');
	Route::post('/footer/store-links', 'Admin\FooterController@storeLink')->name('footer.storelink');
	Route::post('/footer/update-logo', 'Admin\FooterController@updateFooterLogo')->name('footer.updatelogo');
	Route::post('/footer/update-link', 'Admin\FooterController@updateFooterLink')->name('footer.updatelink');
	Route::post('/footer/update/{id}', 'Admin\FooterController@updateFooter')->name('footer.update');
	// Route::get('/configurations', 'Admin\ConfigurationController@edit');
	// Route::post('/configurations/update/{id}', 'Admin\ConfigurationController@updateConfiguration')->name('configurations.update');
	Route::get('/documents-export','Admin\DocumentController@export1')->name('documents.export');
	

	Route::get('/schemes-export', 'Admin\SchemeDetailController@export')->name('scheme.export');
	Route::get('huds/export', [App\Http\Controllers\Admin\HudController::class, 'export'])->name('huds.export');
   Route::get('/blocks/export', [App\Http\Controllers\Admin\BlockController::class, 'export'])
     ->name('blocks.export');



});

Route::middleware(['privilege'])->group(function () {
	Route::get('/profile','Admin\DashboardController@userProfile')->name('admin.userProfile');
	Route::post('/update-profile/{id}','Admin\DashboardController@updateUserProfile')->name('admin.updateUserProfile');
	Route::resource('/contacts','Admin\ContactController');
	Route::resource('/facility_hierarchy','Admin\FacilityHierarchyController');
	Route::get('/facility_hierarchy/export','Admin\FacilityHierarchyController@export')->name('facility_hierarchy.export');
	Route::get('/profile/update','Admin\ContactController@updateSelfContact');
	Route::resource('/huds','Admin\HudController');
	Route::get('/huds/destroy-document/{block}', 'Admin\HudController@destroyDocument');

	Route::resource('/blocks','Admin\BlockController');
	Route::get('/blocks/destroy-document/{block}', 'Admin\BlockController@destroyDocument');

   Route::get('phc/export', [App\Http\Controllers\Admin\PhcController::class, 'export'])->name('phc.export');

	Route::resource('/phc','Admin\PhcController');
	Route::get('/phc/destroy-document/{block}', 'Admin\PhcController@destroyDocument');
Route::get('/hsc/export', 'Admin\HscController@export')->name('hsc.export');

	Route::resource('/hsc','Admin\HscController');
	Route::resource('/tags','Admin\TagController');
	Route::resource('/popular','Admin\PopularController');
	Route::get('/hsc/destroy-document/{block}', 'Admin\HscController@destroyDocument');
	// Route::get('/hsc-export','Admin\HscController@export')->name('hsc.export');
	
// Route::get('/hsc/export', [App\Http\Controllers\Admin\HscController::class, 'export'])->name('hsc.export');

Route::get('/hsc/get-phc/{blockId}', 'Admin\HscController@getPhcByBlock')->name('hsc.getPhcByBlock');

	Route::get('/hw-location','Admin\HealthWalkLocationController@index');
	Route::post('/hw-location-submit','Admin\HealthWalkLocationController@store');
	Route::resource('/health-walk','Admin\HealthWalkController');

	Route::resource('/programdetails','Admin\ProgramDetailController');

	Route::resource('/schemedetails','Admin\SchemeDetailController');
	Route::get('/schemedetails-export','Admin\SchemeController@export')->name('scheme.export');


	Route::prefix('approval')->group(function () {
        Route::get('/documents', 'Admin\DocumentApprovalController@index')->name('documentsapproval.index');
        Route::get('/documents/{id}', 'Admin\DocumentApprovalController@show')->name('documentsapproval.show');
        Route::post('/documents/{id}/{action}', 'Admin\DocumentApprovalController@handleAction')->name('documentsapproval.handle');
		Route::post('/documents/bulk-action', 'Admin\DocumentApprovalController@performBulkAction')->name('documentsapproval.bulk-action');
Route::post('contacts/get-designation', [App\Http\Controllers\Admin\ContactController::class, 'getDesignation'])
    ->name('contacts.getDesignation');

		Route::get('/programdetails', 'Admin\PorgramDetailApprovalController@index')->name('programdetailsapproval.index');
        Route::get('/programdetails/{id}', 'Admin\PorgramDetailApprovalController@show')->name('programdetailsapproval.show');
        Route::post('/programdetails/{id}/{action}', 'Admin\PorgramDetailApprovalController@handleAction')->name('programdetailsapproval.handle');
		Route::post('/programdetails/bulk-action', 'Admin\PorgramDetailApprovalController@performBulkAction')->name('programdetailsapproval.bulk-action');

		Route::get('/schemedetails', 'Admin\SchemeDetailApprovalController@index')->name('schemedetailsapproval.index');
        Route::get('/schemedetails/{id}', 'Admin\SchemeDetailApprovalController@show')->name('schemedetailsapproval.show');
        Route::post('/schemedetails/{id}/{action}', 'Admin\SchemeDetailApprovalController@handleAction')->name('schemedetailsapproval.handle');
		Route::post('/schemedetails/bulk-action', 'Admin\SchemeDetailApprovalController@performBulkAction')->name('schemedetailsapproval.bulk-action');

		Route::get('/uploadevent', 'Admin\EventUploadApprovalController@index')->name('uploadeventapproval.index');
        Route::get('/uploadevent/{id}', 'Admin\EventUploadApprovalController@show')->name('uploadeventapproval.show');
        Route::post('/uploadevent/{id}/{action}', 'Admin\EventUploadApprovalController@handleAction')->name('uploadeventapproval.handle');
		Route::post('/uploadevent/bulk-action', 'Admin\EventUploadApprovalController@performBulkAction')->name('uploadeventapproval.bulk-action');

		Route::get('/contact', 'Admin\ContactApprovalController@index')->name('contactapproval.index');
        Route::get('/contact/{id}', 'Admin\ContactApprovalController@show')->name('contactapproval.show');
        Route::post('/contact/{id}/{action}', 'Admin\ContactApprovalController@handleAction')->name('contactapproval.handle');
		Route::post('/contact/bulk-action', 'Admin\ContactApprovalController@performBulkAction')->name('contactapproval.bulk-action');

		Route::get('/facilityprofile', 'Admin\FacilityProfileApprovalController@index')->name('facilityapproval.index');
        Route::get('/facilityprofile/{id}', 'Admin\FacilityProfileApprovalController@show')->name('facilityapproval.show');
        Route::post('/facilityprofile/{id}/{action}', 'Admin\FacilityProfileApprovalController@handleAction')->name('facilityapproval.handle');
		Route::post('/facilityprofile/bulk-action', 'Admin\FacilityProfileApprovalController@performBulkAction')->name('facilityapproval.bulk-action');
    });

});





