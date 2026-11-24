
<?php

use App\Http\Controllers\AdminUserPasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatuanKerjaController;
use App\Http\Controllers\StandarBiayaMasukanController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\TemplateDokumenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
|
| Guest is represented by unauthenticated access to public pages.
| Guest is not stored as a role in Spatie.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Authenticated internal routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->group(function (): void {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    /*
    |--------------------------------------------------------------------------
    | Master Data Resources
    |--------------------------------------------------------------------------
    */

    $masterResources = [
        'satuan-kerja' => SatuanKerjaController::class,
        'pegawai' => PegawaiController::class,
        'tempat' => TempatController::class,
        'standar-biaya-masukan' => StandarBiayaMasukanController::class,
        'template-dokumen' => TemplateDokumenController::class,
    ];

    /*
     * Explicit route parameter mapping.
     * Prevent Laravel from generating template_dokuman.
     */
    $resourceParameters = [
        'template-dokumen' => 'template_dokumen',
    ];

    // 1. CREATE
    Route::middleware('permission:master-data.create')->group(function () use (
        $masterResources,
        $resourceParameters
    ): void {

        foreach ($masterResources as $uri => $controller) {

            Route::resource($uri, $controller)
                ->parameters($resourceParameters)
                ->only(['create', 'store']);

        }
    });

    // 2. VIEW
    Route::middleware('permission:master-data.view')->group(function () use (
        $masterResources,
        $resourceParameters
    ): void {

        foreach ($masterResources as $uri => $controller) {

            Route::resource($uri, $controller)
                ->parameters($resourceParameters)
                ->only(['index', 'show']);

        }
    });

    // 3. UPDATE
    Route::middleware('permission:master-data.update')->group(function () use (
        $masterResources,
        $resourceParameters
    ): void {

        foreach ($masterResources as $uri => $controller) {

            Route::resource($uri, $controller)
                ->parameters($resourceParameters)
                ->only(['edit', 'update']);

        }
    });

    // 4. DELETE
    Route::middleware('permission:master-data.delete')->group(function () use (
        $masterResources,
        $resourceParameters
    ): void {

        foreach ($masterResources as $uri => $controller) {

            Route::resource($uri, $controller)
                ->parameters($resourceParameters)
                ->only(['destroy']);

        }
    });

    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    |
    | Restricted according to PermissionMatrix.
    | Account deletion endpoint is not exposed.
    |
    */

    // Daftar pengguna
    Route::get('/user', [UserController::class, 'index'])
        ->middleware('permission:users.view')
        ->name('user.index');

    // Form tambah pengguna
    Route::get('/user/create', [UserController::class, 'create'])
        ->middleware('permission:users.create')
        ->name('user.create');

    // Simpan pengguna
    Route::post('/user', [UserController::class, 'store'])
        ->middleware([
            'permission:users.create',
            'permission:users.assign-role',
        ])
        ->name('user.store');

    // Form edit pengguna
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission:users.update')
        ->name('user.edit');

    // Update pengguna
    Route::match(['put', 'patch'], '/user/{user}', [UserController::class, 'update'])
        ->middleware('permission:users.update')
        ->name('user.update');

    // Ubah role pengguna
    Route::put('/user/{user}/role', [UserController::class, 'updateRole'])
        ->middleware('permission:users.assign-role')
        ->name('user.role');

    // Ubah status pengguna
    Route::put('/user/{user}/status', [UserController::class, 'updateStatus'])
        ->middleware('permission:users.set-status')
        ->name('user.status');

    // Reset password pengguna
    Route::put('/user/{user}/reset-password', [AdminUserPasswordResetController::class, 'update'])
        ->middleware('permission:users.reset-password')
        ->name('user.reset-password');

});

require __DIR__.'/auth.php';
