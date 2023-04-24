<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return RoleResource::collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            $role = Role::create($request->only('name'));
            $role->permissions()->attach($request->input('permissions'));

            return response(new RoleResource($role->load('permissions')), Response::HTTP_CREATED);
        }
        catch (\Exception $e)
        {
            return  response(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = new RoleResource(Role::with('permissions')->find($id));

        if(!empty($role))  return  $role;

        return \response(['message' => "Role with id=$id was not found!"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);

        if (!empty($role))
        {
            $role->update($request->only('name'));
            $role->permissions()->sync($request->input('permissions'));

            return response(new RoleResource($role->load('permissions')), Response::HTTP_ACCEPTED);
        }

        return response(['message' => "role with id=$id was not found"], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
