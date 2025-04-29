<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_permission;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    public function setPermission(Request $request, $admin_id)
    {

        $request->validate([
            'permission' => 'required|array',
            'permission.*' => 'required|string',
        ]);

        Admin_permission::where('admin_id', $admin_id)->delete();

        foreach ($request->permission as $permission) {
            Admin_permission::create([
                'admin_id' => $admin_id,
                'permissions' => $permission
            ]);
        }

        $permissions = Admin_permission::where('admin_id', $admin_id)->get();

        return response()->json(['success' => true, 'permissions' => $permissions]);
    }

    public function getPermissions($admin_id) 
    {
        $permissions = Admin_permission::where('admin_id', $admin_id)->get();
        $permission = $permissions->count();
        return response()->json(['success' => true, 'permissions' => $permissions, 'permission' => $permission]);
    }
}
