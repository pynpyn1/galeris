<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\URLController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FolderController as ApiFolderController;
use App\Http\Controllers\API\GalleryController as ApiGalleryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\API\PhotoController as ApiPhotoController;
use App\Http\Controllers\API\URLController as ApiURLController;
use App\Http\Controllers\API\UsersController as ApiUserController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\API\ChatBotController as ApiChatBotController;
use App\Http\Controllers\API\PackageController as APIPackageController;
use App\Http\Controllers\API\VideoController as ApiVideoController;
use App\Http\Controllers\API\QrTemplateController as ApiQrTemplateController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\Client\Event\EventController;
use App\Http\Controllers\Client\Event\PurchaseController;
use App\Http\Controllers\Client\Event\QrTemplateController as EventQrTemplateController;
use App\Http\Controllers\Client\Event\ShareController;
use App\Http\Controllers\Client\FolderController as ClientFolderController;
use App\Http\Controllers\Client\PhotoController as ClientPhotoController;
use App\Http\Controllers\Client\QrCodeController;
use App\Http\Controllers\Client\SettingChatBotController;
use App\Http\Controllers\Client\WhatsappController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\DiscordController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvidePhotoController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\EventGuestController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Client\Event\GalleryWallController;
use App\Http\Controllers\Client\Event\PhotoController as EventPhotoController;
use App\Http\Controllers\Client\Event\VideoController as EventVideoController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\QrTemplateController;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Verification Payment
Route::prefix('/payment')->group(function(){
    Route::get('/finish', function () {return redirect()->route('home.subscribe')->with('success', 'Pembayaran berhasil diproses.');});
    Route::get('/unfinish', function () {return redirect()->route('home.subscribe')->with('warning', 'Pembayaran belum selesai.');});
    Route::get('/error', function () {return redirect()->route('home.subscribe')->with('error', 'Pembayaran gagal.');});
    Route::post('/midtrans/webhook', [PurchaseController::class, 'webhook']);
});


// Contact - Latif


// Tampilan Gambar
Route::get('/url/{slug}', [ProvidePhotoController::class, 'index'])->name('provide.photo');
Route::get('/url/{slug}/livewall', [GalleryWallController::class, 'index'])->name('livewall.photo');
Route::post('/gallery/{folder}/guest', [EventGuestController::class, 'store'])->name('guest.store');


// Help
Route::prefix('/help')->name('help.')->group(function() {
    Route::get('/terms-of-services', [HelpController::class,'tos'])->name('tos');
    Route::get('/privacy-policy', [HelpController::class,'privacy'])->name('privacy');

    Route::prefix('/contact-us')->name('contactus.')->group(function() {
        Route::get('/', [HelpController::class, 'index'])->name('index');
        Route::post('/store', [HelpController::class, 'store'])->name('store');
    });
});




// Guest
Route::middleware(['guest'])->group(function () {

    Route::prefix('/auth')->group(function() {
        Route::get('/{provider}', [SocialLoginController::class, 'redirectToProvider'])
            ->name('social.login');
        Route::get('/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);
    });


    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login/store', [AuthController::class, 'store'])->name('login.post');


});

// Middleware Global
Route::middleware(['auth'])->group(function () {


    // Phone Number Client Setting
    Route::get('/profile/phone', [AuthController::class, 'phone'])->name('auth.phone');
    Route::put('/profile/phone', [AuthController::class, 'phoneUpdate'])->name('auth.phone.store');



    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // Whatsapp
    Route::prefix('connect')->name('connect.')->group(function() {
        Route::get('/',[ConnectController::class, 'index'])->name('index');
    });


    // Profile
    Route::prefix('/profile')->name('profile.')->group(function() {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update/{profile}', [ProfileController::class, 'update'])->name('update');
        Route::put('/password/{profile}', [ProfileController::class, 'password'])->name('password');
    });


});


// Middleware Admin

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['permission:dashboard'])->name('dashboard');

    // Manage
    Route::prefix('manage')->name('manage.')->group(function () {

        // Folder
        Route::prefix('folder')->middleware(['permission:manage_folder'])->name('folder.')->group(function () {
            Route::get('/', [FolderController::class, 'index'])->name('index');
            Route::get('/data', [ApiFolderController::class, 'data'])->name('data');
            Route::get('/create', [FolderController::class, 'create'])->name('create');
            Route::post('/store', [FolderController::class, 'store'])->name('store');
            Route::get('/edit/{folder}', [FolderController::class, 'edit'])->name('edit');
            Route::put('/{folder}', [FolderController::class, 'update'])->name('update');
            Route::delete('/destroy/{folder}', [FolderController::class, 'destroy'])->name('destroy');
        });


        // Video
        Route::prefix('video')->middleware(['permission:manage_video'])->name('video.')->group(function () {
            Route::get('/', [VideoController::class, 'index'])->name('index');
            Route::get('/data', [ApiVideoController::class, 'data'])->name('data');
            Route::get('/create', [VideoController::class, 'create'])->name('create');
            Route::post('/store', [VideoController::class, 'store'])->name('store');
            Route::get('/edit/{photo}', [VideoController::class, 'edit'])->name('edit');
            Route::put('/{photo}', [VideoController::class, 'update'])->name('update');
            Route::delete('/destroy/{photo}', [VideoController::class, 'destroy'])->name('destroy');
        });

        // Foto
        Route::prefix('photo')->middleware(['permission:manage_photo'])->name('photo.')->group(function () {
            Route::get('/', [PhotoController::class, 'index'])->name('index');
            Route::get('/downloadAll', [PhotoController::class, 'download'])->name('download');
            Route::get('/data', [ApiPhotoController::class, 'data'])->name('data');
            Route::get('/create', [PhotoController::class, 'create'])->name('create');
            Route::post('/store', [PhotoController::class, 'store'])->name('store');
            Route::get('/edit/{photo}', [PhotoController::class, 'edit'])->name('edit');
            Route::put('/{photo}', [PhotoController::class, 'update'])->name('update');
            Route::delete('/destroy/{photo}', [PhotoController::class, 'destroy'])->name('destroy');

        });

        // URL Manage
        Route::prefix('url')->middleware(['permission:manage_url'])->name('url.')->group(function() {
            Route::get('/', [URLController::class, 'index'])->name('index');
            Route::get('/data', [ApiURLController::class, 'data'])->name('data');
            Route::get('/create', [URLController::class, 'create'])->name('create');
            Route::post('/store', [URLController::class, 'store'])->name('store');
            Route::delete('/destroy/{url}', [URLController::class, 'destroy'])->name('destroy');
        });

        // Manage Qr Template
        Route::get('/data', [ApiQrTemplateController::class, 'data'])->name('qr_template.data');
        Route::prefix('qr_template')->controller(QrTemplateController::class)->middleware(['permission:manage_qrtemplate'])->name('qr_template.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{package}', 'edit')->name('edit');
            Route::put('/update/{package}', 'update')->name('update');
            Route::delete('/delete/{package}', 'destroy')->name('destroy');
            Route::delete('/file/{id}', 'destroyFile')->name('destroy.file');
        });




        // Users Manage
        Route::prefix('users')->middleware(['permission:manage_users'])->name('users.')->group(function() {
            Route::get('/', [UsersController::class, 'index'])->name('index');
            Route::get('/create', [UsersController::class, 'create'])->name('create');
            Route::get('/data', [ApiUserController::class, 'data'])->name('data');
            Route::post('/store', [UsersController::class, 'store'])->name('store');
            Route::get('/edit/{user}', [UsersController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UsersController::class, 'update'])->name('update');
            Route::delete('/destroy/{user}', [UsersController::class, 'destroy'])->name('destroy');
            Route::put('/{user}/restore', [UsersController::class, 'restore'])->name('restore');
        });

        // Roles Manage
        Route::prefix('roles')->middleware(['permission:manage_roles'])->name('roles.')->group(function() {
            Route::get('/', [RolePermissionController::class, 'index'])->name('index');
            Route::get('/management', [RolePermissionController::class, 'managementIndex'])->name('group.edit');
            Route::get('/assignment', [RolePermissionController::class, 'assignmentIndex'])->name('assign.edit');
            Route::post('/group', [RolePermissionController::class, 'group'])->name('group');
            Route::delete('/group/{role_group}', [RolePermissionController::class, 'destroyGroup'])->name('group.destroy');
            Route::post('/permission', [RolePermissionController::class, 'permission'])->name('permission');
            Route::delete('/permission/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permission.destroy');
            Route::put('/assign', [RolePermissionController::class, 'assign'])->name('assign');
        });

        // Chat Bot Manage
        Route::prefix('chatbot')->middleware(['permission:manage_chatbot'])->name('chatbot.')->group(function() {
            Route::get('/', [ChatBotController::class, 'index'])->name('index');
            Route::get('/data', [ApiChatBotController::class, 'data'])->name('data');
            Route::get('/create', [ChatBotController::class, 'create'])->name('create');
            Route::post('/store', [ChatBotController::class, 'store'])->name('store');
            Route::get('/edit/{chatbot}', [ChatBotController::class, 'edit'])->name('edit');
            Route::put('/{chatbot}', [ChatBotController::class, 'update'])->name('update');
            Route::delete('/destroy/{chatbot}', [ChatBotController::class, 'destroy'])->name('destroy');
            Route::put('/{chatbot}/restore', [ChatBotController::class, 'restore'])->name('restore');
        });



        // Manage Invoice
        Route::prefix('invoice')->controller(InvoiceController::class)->middleware(['permission:manage_invoice'])->name('invoice.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/data', 'data')->name('data');
            Route::get('/edit/{purchase}', 'edit')->name('edit');
            Route::put('/update/{purchase}', 'update')->name('update');
        });

        // Manage Package
        Route::prefix('package')->controller(PackageController::class)->middleware(['permission:manage_package'])->name('package.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{package}', 'edit')->name('edit');
            Route::put('/update/{package}', 'update')->name('update');
        });
        Route::get('/data', [APIPackageController::class, 'data'])->name('package.data');

        // Manage Discount
        Route::prefix('discount')->controller(DiscountController::class)->middleware(['permission:manage_discount'])->name('discount.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/data', 'data')->name('data');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{discount}', 'edit')->name('edit');
            Route::put('/update/{discount}', 'update')->name('update');
            Route::delete('/delete/{discount}', 'destroy')->name('destroy');
        });
    });
});





// Middleware Client

Route::middleware(['auth', 'phone'])->group(function () {
    Route::get('/home/subscribe', [DashboardController::class, 'subscribe'])->name('home.subscribe');

    // Manage Folder
    Route::prefix('/folder/client')->middleware(['permission:create_folder'])->name('folder.client.')->group(function () {
        Route::get('/', [ClientFolderController::class, 'index'])->name("index");
        Route::get('/data', [ClientFolderController::class, 'data'])->name("data");
        Route::get('/create', [ClientFolderController::class, 'create'])->name("create");
        Route::post('/store', [ClientFolderController::class, 'store'])->name("store");
        Route::get('/edit/{photo}', [ClientFolderController::class, 'edit'])->name("edit");
        Route::put('/{photo}', [ClientFolderController::class, 'update'])->name("update");
        Route::delete('/destroy/{photo}', [ClientFolderController::class, 'destroy'])->name("destroy");
    });

    // Setting ChatBot Client
    Route::prefix('chatbot')->middleware(['permission:setting_chatbot'])->name('chatbot.')->group(function() {
            Route::put('/{chatbot}', [SettingChatBotController::class, 'update'])->name('update');
    });


    // Home
    Route::prefix('/home')->middleware(['permission:dashboard_client', 'permission:manage_qr_code', 'permission:create_folder', 'permission:upload_photo'])->name('home.')->group(function() {

        Route::get('/',[DashboardController::class, 'index'])->name('index');

        // Purchase
        Route::prefix('invoice')->name('checkout.')->middleware('auth')->group(function () {
            Route::post('/select', [PurchaseController::class, 'select'])->name('select');
            Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('show');
            Route::post('/{purchase}/confirm', [PurchaseController::class, 'confirm'])->name('confirm');
            Route::post('/{purchase}/discount', [PurchaseController::class, 'applyDiscount'])->name('applyDiscount');
            Route::get('/{purchase}/snap', [PurchaseController::class, 'snapCheckout'])->name('snapCheckout');
        });



        // Folder : public_code
        Route::get('/{folder:public_code}',[EventController::class, 'show'])->name('show');
        Route::post('/thumbnail/{folder}', [EventController::class, 'thumbnail'])->name('thumbnail');
        Route::put('/thumbnail/{folder:public_code}', [EventController::class, 'update'])->name('update');
        Route::get('/event/{folder:public_code}/download', [EventController::class, 'download'])->name('download');


        // Share Menu
        Route::get('/{folder:public_code}/share', [ShareController::class, 'index'])->name('share');
        Route::post('/{folder:public_code}/share/generate-qr', [ShareController::class, 'generateqr'])->name('generate');
        Route::post('/{folder:public_code}/remind',[ShareController::class, 'remind'])->name('remind');
        Route::post('/{folder:public_code}/import',[ShareController::class, 'import'])->name('import');
        Route::get('/{folder:public_code}/template/download', [ShareController::class, 'downloadTemplate'])->name('template.download');


        // Toggle Whatsapp Bot
        Route::post('/whatsapp/{user}/toggle', [WhatsappController::class, 'toggle'])->name('togglewa');

        // Qr Template
        Route::get('/{folder:public_code}/template', [EventQrTemplateController::class, 'index'])->name('templates');
        Route::get('/{folder:public_code}/template/{templateFile}/download',[EventQrTemplateController::class, 'download'])->name('templates.download');

        // Photo
        Route::prefix('/photo/{folder:public_code}')->middleware('permission:upload_photo')->controller(EventPhotoController::class)->name('photo.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/upload', 'store')->name('store');
            Route::delete('/all', 'destroyAll')->name('destroyAll');
            Route::delete('/{photo}', 'destroy')->name('destroy');
        });

        Route::prefix('/video/{folder:public_code}')->middleware('permission:upload_video')->controller(EventVideoController::class)->name('video.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/upload', 'store')->name('store');
            Route::delete('/all', 'destroyAll')->name('destroyAll');
            Route::delete('/{video}', 'destroy')->name('destroy');
        });
    });


});




Route::get('/', function () {
    return view('layout.welcome');
});

Route::get('/upload-too-large', function () {
    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal 1Gib.');
});


