    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Permissions\PermissionManagement;
use App\Livewire\Permissions\PermissionManagementCreate;
use App\Livewire\Permissions\PermissionManagementEdit;
use App\Livewire\Roles\Indexrole;
use App\Livewire\Roles\CreateRole;
use App\Livewire\Roles\Editrole;
use App\Livewire\Admins\AdminsIndex;
use App\Livewire\Admins\AdminsCreate;
use App\Livewire\Admins\AdminsEdit;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\RoleCreate;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RolesController;

// Route::group(['domain'=>config('tenancy.central_domains.0')],function(){

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
    // for role resource
    Route::resource('roles', RolesController::class);
    Route::get('admin/roles/exportCSV', [RolesController::class, 'exportCSV'])->name('roles.exportCSV');
    Route::get('admin/roles/pdf', [RolesController::class, 'exportPDF'])->name('roles.exportPDF');




    // for role live wire
  
    // Route::get('roles', Indexrole::class)->name('roles.index');
    // Route::get('roles/create', CreateRole::class)->name('roles.create');
    // Route::get('roles/{role}/edit', Editrole::class)->name('roles.edit');


    // for permission livewire
    Route::get('permissions', PermissionManagement::class)->name('permissions');
    Route::get('/permissions/create', PermissionManagementCreate::class)->name('permissions.create');
    Route::get('permissions/{permission}/edit', PermissionManagementEdit::class)->name('permissions.edit');
    
    // route for admin live wire
    Route::get('admins', AdminsIndex::class)->name('admins.index');
    Route::get('admins/create', AdminsCreate::class)->name('admins.create');
    Route::get('admins/{admin}/edit', AdminsEdit::class)->name('admins.edit');

    

})->middleware(['auth', 'verified']);
// });

// for chart(graph)
Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');


// for testing purpopse those routes are used
// for data table
Route::get('user', [UserController::class, 'create'])->name('user.view');
Route::get('user/view', [UserController::class, 'index']);
Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
// forcustomer to testing the form and data table through the daisy ui design
Route::get('customers', [CustomerController::class, 'index'])->name('customers.index'); 
Route::get('customers/view', [CustomerController::class, 'view'])->name('customers.view'); 
Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create'); 
Route::get('customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
Route::put('customers/{id}', [CustomerController::class, 'update'])->name('customers.update');

// Route:get()
require __DIR__.'/auth.php';
