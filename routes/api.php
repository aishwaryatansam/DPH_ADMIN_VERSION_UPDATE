<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['cors','websiteApi'])->post('get-nav-files', 'Website\HomePageController@getNavFile');
Route::middleware(['cors','websiteApi'])->post('utilities', 'Website\HomePageController@utilities');

Route::middleware(['cors','websiteApi'])->group(function () {

    Route::post('districts','Website\HomePageController@getDistricts');
    Route::post('huds','Website\HomePageController@getHuds');
    Route::post('blocks','Website\HomePageController@getBlocks');
    Route::post('phc','Website\HomePageController@getPHC');
    Route::post('hsc','Website\HomePageController@getHSC');
    Route::post('contacts','Website\HomePageController@getContacts');
    Route::post('divisions','Website\DivisionController@getDivisions');
    Route::post('programs','Website\HomePageController@getPrograms');
    Route::post('media-gallery','Website\HomePageController@getMediaGallery');
});

Route::post('contact-designations','Admin\DesignationController@listDesignations');
Route::post('facility-list','Admin\FacilityHierarchyController@listFacilities');
Route::post('list-district','Admin\DistrictController@listDistrict');
Route::post('list-hud','Admin\HudController@listHUD');
Route::post('list-block','Admin\BlockController@listBlock');
Route::post('list-phc','Admin\PhcController@listPHC');
Route::post('list-hsc','Admin\HscController@listHSC');
Route::post('list-scheme', [App\Http\Controllers\Admin\SchemeController::class, 'listScheme'])->name('list-scheme');

Route::post('list-program','Admin\ProgramController@listProgram');
Route::post('list-section','Admin\SectionController@listSection');
Route::post('list-block-contacts','Admin\ContactController@listBlockContact');
Route::post('testimonial','Admin\TestimonialController@listTestimonial');
Route::post('configuration','Admin\ConfigurationController@getConfiguration');
Route::post('health-walk-locations','Admin\HealthWalkLocationController@getHealthWalkLocations');
Route::post('about-us','Admin\PageController@getAboutUs');
Route::post('ethics-committee','Admin\SiteController@getEthicsCommittee');
Route::post('scientific-committee','Admin\SiteController@getScientificCommittee');
Route::post('dph-newsletter','Admin\SiteController@getDphNewsletter');
Route::post('publication','Admin\SiteController@getPublication');
Route::post('rti-officer','Admin\RtiOfficerController@getRtiOfficer');
Route::post('social-media-post','Admin\SocialMediaPostController@getSocialMediaPost');
Route::post('events','Website\HomePageController@getEvents');

Route::post('/track-visitor', [VisitorController::class, 'trackVisitor']);
Route::get('/visitor-count', [VisitorController::class, 'getVisitorCount']);

