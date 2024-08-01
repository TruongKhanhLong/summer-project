<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Models\Role;
use App\Services\RoleTableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Class RoleController extends Controller{
    public function index(Request $request): JsonResponse
    {
        [$search, $roles, $filters, $perPage] = $this->getTableParams($request);
        $data = RoleTableService::getInstance()->data($search, $roles, $filters, $perPage);

        return $this->sendSuccessResponse($data);
    }

    public function store(CreateRoleRequest $request)
    {
        try {
            $role = Role::create($request->all());
            return response()->json($role, 201);
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
    public function show($id)
    {
        $role = Role::find($id);
        if (is_null($role)) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        return response()->json($role);
    }
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (is_null($role)) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        $role->update($request->all());
        return response()->json($role);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if (is_null($role)) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        $role->delete();
        return response()->json(null, 204);
    }
}