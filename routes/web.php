    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Livewire\PermissionManagement;
use App\Livewire\PermissionManagementCreate;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\RoleCreate;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\PermissionController;





Route::view('/', 'welcome');
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', function () {
        Auth::logout(); 
        session()->invalidate();  
        session()->regenerateToken();  
        return redirect('/login'); 
    })->name('logout');
    Route::view('profile', 'profile')->name('profile');
    Route::resource('roles', RolesController::class);
    Route::get('permissions', PermissionManagement::class)->name('permissions');
    Route::get('/permissions/create', PermissionManagementCreate::class)->name('permissions.create');

    Route::resource('admins', AdminsController::class);
    Route::get('import', [CustomerController::class, 'import'])->name('customers.import');
    Route::get('export', [CustomerController::class, 'export'])->name('customers.export');

})->middleware(['auth', 'verified']);
// for data table
Route::get('user', [UserController::class, 'create'])->name('user.view');
Route::get('user/view', [UserController::class, 'index']);
Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
// for chart(graph)
Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');
// forcustomer to testing the form and data table through the daisy ui design
Route::get('customers', [CustomerController::class, 'index'])->name('customers.index'); 
Route::get('customers/view', [CustomerController::class, 'view'])->name('customers.view'); 
Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create'); 
Route::get('customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
Route::put('customers/{id}', [CustomerController::class, 'update'])->name('customers.update');

// Route:get()


require __DIR__.'/auth.php';
