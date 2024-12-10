<?php
namespace App\Livewire\Admins;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Traits\AuthorizationChecker;
use Illuminate\Validation\Rule;

class AdminsCreate extends Component
{
    use AuthorizationChecker;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $roles = [];
    public $username;
    public $availableRoles;

    // Validation rules
    protected $rules = [
        'name' => 'required|string|unique:users,name',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
        'roles' => 'required|min:1',
        'roles.*' => 'exists:roles,name',
    ];

    public function mount()
    {
        $this->availableRoles = Role::all();
    }

    // Real-time validation
    public function updated($propertyName)
    {
        // dd($propertyName);
        // This will validate only the updated property
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        // Authorization
        $this->checkAuthorization(auth()->user(), ['admin.create']);

        // Backend validation
        $validatedData = $this->validate();

        // Create Admin
        $admin = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'username' => $this->username,
        ]);

        $admin->assignRole($this->roles);

        // session()->flash('success', __('Admin created successfully!'));
        flash()->success('Admin Created successfully.');

        return redirect()->route('admin.admins.index');
    }

    public function render()
    {
        $this->checkAuthorization(auth()->user(), ['admin.create']);
        return view('livewire.Admins.admins-create')->layout('layouts.app');
    }
}
