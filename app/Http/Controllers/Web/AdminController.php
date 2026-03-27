<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreAdminRequest;
use App\Http\Requests\Web\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\Web\AdminService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct(protected AdminService $admin) {}

    public function index()
    {
        $admins = Admin::where('email', '!=', 'superadmin@gmail.com')->get();
        return view('dashboard.admins.index', compact('admins'));
    }
    public function create()
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $permissions = Permission::all();
        return view('dashboard.admins.create', compact('roles', 'permissions'));
    }

    public function store(StoreAdminRequest $request)
    {
        $this->admin->store($request->validated());

        return redirect()->route('dashboard-analytics');
    }

    public function edit(Admin $admin)
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $permissions = Permission::all();

        $adminRoles = $admin->roles->pluck('name')->toArray();

        $adminDirectPermissions = $admin->getDirectPermissions()->pluck('name')->toArray();

        return view('dashboard.admins.edit', compact('admin', 'roles', 'permissions', 'adminRoles', 'adminDirectPermissions'));
    }

    public function update(UpdateAdminRequest $reqeust, Admin $admin)
    {
        $this->admin->update($admin, $reqeust->validated());

        return redirect()->route('admins.index');
    }

    public function destroy(Admin $admin)
    {
        $this->admin->destroy($admin);

        return redirect()->route('admins.index');
    }
}
