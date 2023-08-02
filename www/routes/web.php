<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvertCategoryController;
use App\Http\Controllers\Admin\AdvertAttributesController;
use App\Http\Controllers\Admin\RegionsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Profil\PersonalController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profil\Adverts\AdvertController;
use App\Http\Controllers\Profil\Adverts\CreateAdvertController;
use App\Http\Controllers\Profil\ProfilController;
use App\Http\Controllers\Profil\PhoneController;
use App\Service\GetCategories;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Service\MiscService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/show/{advert}', [HomeController::class, 'show'])->name('advert.show');
Route::post('/advert/fav/{advert}', [HomeController::class, 'makeFavourite'])->name('advert.fav');
Route::get('/search', [SearchController::class, 'search'])->name('search');


Auth::routes();
Route::get('/login/phone', [LoginController::class, 'phone'])->name('auth.phone');
Route::post('/login/phone', [LoginController::class, 'verify'])->name('auth.phonelogin');

Route::get('/verify/{verifyString}', [RegisterController::class, 'verify'])->name('register.verify');


Route::prefix('profil')->group(function() {
    Route::middleware(['auth'])->group(function() {
        Route::get('/', [ProfilController::class, 'index'])->name('profil.home');
        Route::get('/personal', [PersonalController::class, 'show'])->name('profil.personal');
        Route::get('/personal/edit', [PersonalController::class, 'edit'])->name('profil.personal.edit');
        Route::put('/personal/edit', [PersonalController::class, 'update'])->name('profil.personal.update');
        Route::post('/personal/phone', [PhoneController::class, 'request'])->name('profil.personal.verify');
        Route::get('/personal/phone', [PhoneController::class, 'form'])->name('profil.personal.verifyform');
        Route::put('/personal/phone', [PhoneController::class, 'update'])->name('profil.personal.verifyupdsate');
        Route::post('/personal/phoneauth', [PhoneController::class, 'auth'])->name('profil.personal.phoneauth');
            // Adverts
        Route::get('/personal/adverts', [AdvertController::class, 'index'])->name('profil.adverts');
        Route::get('/personal/adverts/create', [CreateAdvertController::class, 'category'])->name('profil.advert.create');
        Route::get('/personal/adverts/create/region/{category}/{region?}', [CreateAdvertController::class, 'region'])->name('profil.advert.create.region');
        Route::get('/personal/advert/create/region/{category}/{region?}', [CreateAdvertController::class, 'content'])->name('profil.advert.create.content');
        Route::post('/personal/advert/create/region/{category}/{region?}', [CreateAdvertController::class, 'store'])->name('profil.advert.create.store');
        Route::get('/personal/adverts/{advert}', [CreateAdvertController::class, 'show'])->name('profil.adverts.show');
        Route::get('/personal/adverts/{advert}/photos', [CreateAdvertController::class, 'addphotos'])->name('profil.adverts.addphotos');
        Route::post('/personal/adverts/{advert}/store', [CreateAdvertController::class, 'storephotos'])->name('profil.adverts.storephotos');
        Route::prefix('/personal/adverts/manage')->group(function() {
            Route::get('attributes/{advert}', [AdvertController::class, 'attributes'])->name('profil.attributes');
            Route::put('attributes/{advert}', [AdvertController::class, 'update_attributes'])->name('profil.update.attributes');
            Route::post('/deletephoto/{id}', [ManageController::class, 'deletephoto'])->name('profil.deletephoto');
            Route::get('/edit/{advert}/info', [ManageController::class, 'editInfo'])->name('profil.info.edit');
            Route::put('/edit/{advert}/info', [ManageController::class, 'updateInfo'])->name('profil.info.update');
            Route::get('attributes/{advert}/moderate',[AdvertController::class, 'moderate'])->name('profil.moderate');
            Route::get('attributes/{advert}/deactivate',[AdvertController::class, 'deactivate'])->name('profil.deactivate');
            Route::post('attributes/{advert}/delete',[AdvertController::class, 'delete'])->name('profil.delete');
        });
        Route::get('/personal/favourties', [AdvertController::class, 'favourites'])->name('profil.showfavourites');
        
    });
});

Route::prefix('admin')->group(function() {
    Route::middleware(['auth','can:admin-panel'])->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::resource('users', UsersController::class);
        Route::get('regions', [RegionsController::class, 'index'])->name('regions.index');
        Route::get('regions/show/{id}', [RegionsController::class, 'show'])->name('regions.show');
        Route::resource('categories', AdvertCategoryController::class);
        Route::get('/categories/inside/{id}', [AdvertCategoryController::class, 'inside'])->name('categories.inside');
        Route::post('categories/{category}/first', [AdvertCategoryController::class, 'first'])->name('categories.first');
        Route::post('categories/{category}/up', [AdvertCategoryController::class, 'up'])->name('categories.up');
        Route::post('categories/{category}/down', [AdvertCategoryController::class, 'down'])->name('categories.down');
        Route::post('categories/{category}/last', [AdvertCategoryController::class, 'last'])->name('categories.last');
        Route::resource('categories/attributes', AdvertAttributesController::class)->except('index');
         
    });
});

Route::prefix('admin/adverts/manage')->group(function() {
    Route::middleware(['auth','can:moderate'])->group(function() {
        Route::get('/', [ManageController::class, 'index'])->name('manage.index');
        Route::get('/show/{advert}', [ManageController::class, 'show'])->name('manage.show');
        Route::get('/edit/{advert}/attributes', [ManageController::class, 'attributes'])->name('manage.attributes.admin');
        Route::put('/edit/{advert}/attributes', [ManageController::class, 'attributes_update'])->name('manage.attributes.update');
        Route::post('/deletephoto/{id}', [ManageController::class, 'deletephoto'])->name('manage.deletephoto');
        Route::get('/edit/{advert}/info', [ManageController::class, 'editInfo'])->name('manage.info.admin');
        Route::put('/edit/{advert}/info', [ManageController::class, 'updateInfo'])->name('manage.info.update');
        Route::get('/approve/{advert}', [ManageController::class, 'approve'])->name('manage.approve');
        Route::get('/reject/{advert}', [ManageController::class, 'reject'])->name('manage.reject');
        Route::get('/deactivate/{advert}', [ManageController::class, 'deactivate'])->name('manage.deactivate');
        Route::post('/delete/{advert}', [ManageController::class, 'delete'])->name('manage.delete');
        
    });   
});



//Service Routes

Route::post('activate/{id}', [UsersController::class, 'activate'])->name('users.activate');
Route::get('api/getcategories/{id}', [GetCategories::class, 'give'])->name('categories.give');
Route::get('/locale/{locale}', [MiscService::class, 'locale'])->name('locale');



Route::get('/{adverts_path?}', [HomeController::class, 'filtered'])->name('index.filtered')->where('adverts_path', '.+');

