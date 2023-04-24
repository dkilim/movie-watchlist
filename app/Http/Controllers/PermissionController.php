<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            $permission = Permission::create($request->only('name'));

            return response(new PermissionResource($permission), Response::HTTP_CREATED);
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
        $permission = new PermissionResource(Permission::find($id));

        if(!empty($permission))  return  $permission;

        return \response(['message' => "Role with id=$id was not found!"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::find($id);

        if (!empty($permission))
        {
            $permission->update($request->only('name'));

            return response(new PermissionResource($permission), Response::HTTP_ACCEPTED);
        }

        return response(['message' => "Permission with id=$id was not found"], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Permission::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
