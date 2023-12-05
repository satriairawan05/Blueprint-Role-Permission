<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Constructor for Controller.
     */
    public function __construct(private $name = 'Permission')
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.permission.index', [
                'name' => $this->name,
                'permission' => Permission::all()
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
            return view('admin.permission.create', [
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
                Permission::create([
                    'name' => $request->input('name'),
                    'guard_name' => 'web'
                ]);

                return redirect()->to(route('permission.index'))->with('success', 'Data Saved!');
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
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        try {
            return view('admin.permission.edit', [
                'name' => $this->name,
                'permission' => $permission->find(request()->segment(2)),
                'role' => Role::all()
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255']
            ]);

            if (!$validated->fails()) {
                Permission::where()->update([
                    'name' => $request->input('name'),
                    'guard_name' => 'web'
                ]);

                return redirect()->to(route('permission.index'))->with('success', 'Data Updated!');
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
    public function destroy(Permission $permission)
    {
        try {
            $data = $permission->find(request()->segment(2));
            Permission::destroy($data->id);

            return redirect()->to(route('permission.index'))->with('success', 'Data Deleted!');
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Assign Role in Permission resource in storage.
     */
    public function assignRole(Request $request, Permission $permission)
    {
        $dataPermission = $permission->find(request()->segment(2));
        if ($dataPermission->hasRole($request->input('role'))) {
            return redirect()->back()->with('failed', 'Role Exists!');
        }
        
        $dataPermission->assignRole($request->input('role'));
        return redirect()->back()->with('success', 'Role Assign!');
    }
    
    /**
     * Remove Role In Permission resource in storage.
     */
    public function removeRole(Permission $permission, Role $role)
    {
        $dataPermission = $permission->find(request()->segment(2));
        $dataRole = $role->find(request()->segment(4));
        if($dataPermission->hasRole($dataRole)){
            $dataPermission->removeRole($dataRole);
            return redirect()->back()->with('success', 'Role Remove!');
        }

        return redirect()->back()->with('failed', 'Role not Exists!');
    }
}
