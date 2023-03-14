<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GalleryPageController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


#gallery Categories

Route::resource('gallery-category', GalleryCategoryController::class)->except([
    'edit', 'create'
]);

Route::post('gallery_category_images', [GalleryPageController::class,'gallery_category_images']);
Route::get('get_gallery_category_images/{id}',[GalleryPageController::class,'get_gallery_category_images']);
Route::get('get_front_gallery_data', [GalleryPageController::class, 'get_front_gallery_data']);

#Front APIs
Route::get('/get_header', [ FrontController::class , 'get_header_data']);
Route::get('/get_premium_offers',[ FrontController::class , 'get_premium_offers']);
Route::get('/get_rooms_list',[ FrontController::class , 'get_rooms_list']);
Route::get('/get_single_room/{slug}',[ FrontController::class , 'get_single_room']);
Route::get('/get_pages',[ FrontController::class , 'get_pages_list']);
Route::get('/get_dinings',[ FrontController::class , 'get_dining_list']);
Route::get('/get_single_dining/{slug}',[ FrontController::class , 'get_single_dining']);
Route::get('/get_offers',[ FrontController::class , 'get_offer_listing']);
Route::get('/get_single_offer/{slug}',[ FrontController::class , 'get_single_offer']);


 

#Blog
Route::resource('blogs', BlogController::class);

#Pages
Route::resource('pages', PageController::class);


#Offer
Route::resource('offers', OfferController::class);
Route::get('premium', 'OfferController@premium');


#Rooms
Route::resource('rooms', RoomController::class);

#Deal
Route::resource('deals', DealController::class);

#Dining
Route::resource('dinings', DiningController::class);


#FAQ
Route::resource('faqs', FaqController::class);
Route::get('all', 'FaqController@all');


#Categories
Route::resource('categories', CategoryController::class);

#Section
Route::get('all-sections/{id}/{lang}', [SectionController::class, 'all_sections']);
Route::post('add-section', [SectionController::class, 'store']);
Route::get('section/{id}', [SectionController::class, 'show']);
Route::get('sections/{lang}', [SectionController::class, 'index']);
Route::post('delete-section/{id}', [SectionController::class, 'destroy']);

#dashboard
Route::get('dashboard_apis','CommonController@dashboard_apis');

#Wedding
Route::resource('weddings', WeddingController::class);

#Wedding
Route::resource('todo', TodoController::class);

#Wedding
Route::resource('common', CommonController::class);
Route::get('drop-down', 'CommonController@dropDown');
Route::get('dashboard_apis', 'CommonController@dashboard_apis');


#Subscriber
Route::post('subscribe', 'EmailController@subscribe');
Route::post('contact', 'EmailController@contactform');
Route::post('book_wedding', 'EmailController@bookwedding');


#PopUp
#Subscriber
Route::post('pop-up', 'CommonController@createPopUp');
Route::get('pop-up/{id}', 'CommonController@getPopUp');






#Upload Controller
Route::post('upload_media', [UploadController::class ,'upload_media']);
Route::get('get_all_images', [UploadController::class ,'get_all_images']);
Route::delete('delete_images/{id}', [UploadController::class,'delete_images']);
Route::put('update_image/{file}/{id}', [UploadController::class,'update_image']);




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::resource('/wishlist','WishlistController');
});


Route::fallback(function () {
    echo  json_encode(['message'=>'Undefined Route']);
});



