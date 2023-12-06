<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Constructor for Controller.
     */
    public function __construct(private $name = 'User')
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.account.index', [
                'name' => $this->name,
                'user' => User::where('id', auth()->user()->id)->get()
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
            return view('admin.account.create', [
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
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if (!$validated->fails()) {
                User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                ]);

                return redirect()->to(route('user.index'))->with('success', 'Data Saved!');
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
    public function show(User $user)
    {
        try {
            return view('admin.account.role', [
                'user' => $user,
                'role' => Role::get(),
                'permission' => Permission::get(),
                'permission_distinct' => Permission::distinct()->pluck('page')
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        try {
            return view('admin.account.edit', [
                'name' => $this->name,
                'user' => $user
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if (!$validated->fails()) {
                User::where('id', $user->id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                ]);

                return redirect()->to(route('user.index'))->with('success', 'Data Updated!');
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
    public function destroy(User $user)
    {
        try {
            if ($user->hasRole('admin')) {
                return back()->with('failed', 'You are admin!');
            }
            $data = $user->find(request()->segment(2));
            User::destroy($data->id);

            return redirect()->to(route('user.index'))->with('success', 'Data Updated!');
        } catch (QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Assign Role in Permission resource in storage.
     */
    public function role(Request $request, User $user)
    {
        $dataUser = $user->find(request()->segment(2));
        if ($dataUser->hasRole($request->input('role'))) {
            return redirect()->back()->with('failed', 'Role Exists!');
        }

        $dataUser->assignRole($request->input('role'));
        return redirect()->back()->with('success', 'Role Assign!');
    }

    /**
     * Remove Role In Permission resource in storage.
     */
    public function removeRole(User $user, Role $role)
    {
        $dataUser = $user->find(request()->segment(2));
        $dataRole = $role->find(request()->segment(4));
        if ($dataUser->hasRole($dataRole)) {
            $dataUser->removeRole($dataRole);
            return redirect()->back()->with('success', 'Role Remove!');
        }

        return redirect()->back()->with('failed', 'Role not Exists!');
    }

    /**
     * Give Permission in Role resource in storage.
     */
    public function permission(Request $request, User $user)
    {
        $dataUser = $user->find(request()->segment(2));
        $permissions = Permission::all();
        $reqPermissions = [];

        foreach ($user->permissions as $user_permission) {
            foreach ($permissions as $perm) {
                $permissionName = in_array($request->input($perm->id) == "on" ? $perm->name : '', $user_permission->pluck('name')->toArray());
                dd($permissionName);
                if ($permissionName) {
                    $reqPermissions[] = $permissionName;
                }
            }
        }

        foreach ($reqPermissions as $reqPermission) {
            if ($dataUser->hasDirectPermission($reqPermission)) {
                $dataUser->revokePermissionTo($perm->id);
            }

            if (!$dataUser->hasDirectPermission($reqPermission)) {
                $dataUser->givePermissionTo($reqPermission);
            }
        }

        return redirect()->back()->with('success', 'Given Permission!');
    }

    /**
     * Revoke Permission in Role resource in storage.
     */
    public function removePermission(User $user, Permission $permission)
    {
        $dataUser = $user->find(request()->segment(2));
        $dataPermission = $permission->find(request()->segment(4));

        if ($dataUser->hasPermissionTo($dataPermission)) {
            $dataUser->revokePermissionTo($dataPermission);
            return redirect()->back()->with('success', 'Permission Revoke!');
        }

        return redirect()->back()->with('failed', 'Permission not Exists!');
    }
}
