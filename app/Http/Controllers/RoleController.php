<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();

        return $this->sendResponse($roles, 'Roles retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'          => 'required|unique:roles',
            'display_name'  => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $role = Role::create($input);

        return $this->sendResponse($role, 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (is_null($role)) {
            return $this->sendError('Role not found.');
        }

        return $this->sendResponse($role, 'Role retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => [
                'required',
                Rule::unique('roles')->ignore($role->id)
            ],
            'display_name'  => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $role->name = $input['name'];
        $role->display_name = $input['display_name'];
        $role->save();

        return $this->sendResponse($role, 'Role updated successfully.');
    }

    /**
     * Assign roles to an user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assingRole(Request $request, User $user)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'roles' => 'required'
        ]);

        //Get all roles
        $allRoles = Role::pluck('id')->all();

        //dont add roles than not exist
        $rolesExist = array_intersect($allRoles, $input['roles']);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        //asign [] of roles
        $user->roles()->sync($rolesExist);

        return $this->sendResponse($user, 'Roles asigned successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->sendResponse([], 'Role deleted');
    }
}
