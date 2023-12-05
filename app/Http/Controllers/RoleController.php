<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Constructor for Controller.
     */
    public function __construct(private $name = 'Role')
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.role.index', [
                'name' => $this->name,
                'role' => Role::all()
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.role.create', [
                'name' => $this->name
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255']
            ]);

            if (!$validated->fails()) {
                Role::create([
                    'name' => $request->input('name'),
                    'guard_name' => 'web'
                ]);

                return redirect()->to(route('role.index'))->with('success', 'Data Saved!');
            } else {
                return redirect()->back()->with('failed', $validated->getMessageBag());
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        try {
            return view('admin.role.edit', [
                'name' => $this->name,
                'role' => $role->find(request()->segment(2)),
                'permission' => Permission::all()
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255']
            ]);

            if (!$validated->fails()) {
                Role::where('id', $role->id)->update([
                    'name' => $request->input('name'),
                    'guard_name' => 'web'
                ]);

                return redirect()->to(route('role.index'))->with('success', 'Data Updated!');
            } else {
                return redirect()->back()->with('failed', $validated->getMessageBag());
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $data = $role->find(request()->segment(2));
            Role::destroy($data->id);

            return redirect()->to(route('role.index'))->with('success', 'Data Deleted!');
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Give Permission in Role resource in storage.
     */
    public function givePermission(Request $request, Role $role)
    {
        $dataRole = $role->find(request()->segment(2));
        if ($dataRole->givePermissionTo($request->input('permission'))) {
            return redirect()->back()->with('failed', 'Permission Exists!');
        }

        $dataRole->givePermissionTo($request->input('permission'));
        return redirect()->back()->with('success', 'Given Permission!');
    }

    /**
     * Revoke Permission in Role resource in storage.
     */
    public function revokePermission(Role $role, Permission $permission)
    {
        $dataRole = $role->find(request()->segment(2));
        $dataPermission = $permission->find(request()->segment(4));
        if ($dataRole->hasPermissionTo($dataPermission)) {
            $dataRole->revokePermissionTo($dataPermission);

            return redirect()->back()->with('success', 'Permission Revoke!');
        }
        return redirect()->back()->with('failed', 'Permission not Exists!');
    }
}
