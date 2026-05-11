<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreAdminRequest;
use App\Http\Requests\Web\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\Web\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct(protected AdminService $admin) {}

    public function index(Request $request)
    {
        $result = $this->admin->index($request->all());

        return view('dashboard.admins.index', [
            'admins' => $result['admins']->appends($request->query()),
            'stats'  => $result['stats']
        ]);
    }

    public function create()
    {
        $data = $this->admin->rolesPermissions();

        return view(
            'dashboard.admins.create',
            [
                'roles' => $data['roles'],
                'permissions' => $data['permissions']
            ]
        );
    }

    public function store(StoreAdminRequest $request)
    {
        $this->admin->store($request->validated());

        return redirect()->route('admins.index');
    }

    public function edit(Admin $admin)
    {
        $data = $this->admin->edit($admin);

        return view(
            'dashboard.admins.edit',
            [
                'admin' => $admin,
                'roles' => $data['roles'],
                'permissions' => $data['permissions'],
                'adminRoles' => $data['adminRoles'],
                'adminDirectPermissions' => $data['adminDirectPermissions']
            ]
        );
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
