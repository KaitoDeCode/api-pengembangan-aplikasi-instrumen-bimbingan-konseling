<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest as GroupControllerStoreRequest;
use App\Http\Requests\GroupUpdateRequest as GroupControllerUpdateRequest;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function index(Request $request): GroupCollection
    {
        $groups = Group::all();

        return new GroupCollection($groups);
    }

    public function store(GroupControllerStoreRequest $request): GroupResource
    {
        $group = Group::create($request->validated());

        return new GroupResource($group);
    }

    public function show(Request $request, Group $group): GroupResource
    {
        return new GroupResource($group);
    }

    public function update(GroupControllerUpdateRequest $request, Group $group): GroupResource
    {
        $group->update($request->validated());

        return new GroupResource($group);
    }

    public function destroy(Request $request, Group $group): Response
    {
        $group->delete();

        return response()->noContent();
    }
}
