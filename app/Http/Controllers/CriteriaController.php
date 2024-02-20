<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriteriaControllerStoreRequest;
use App\Http\Requests\CriteriaControllerUpdateRequest;
use App\Http\Resources\CriterionCollection;
use App\Http\Resources\CriterionResource;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CriteriaController extends Controller
{
    public function index(Request $request): CriterionCollection
    {
        $criteria = Criterion::all();

        return new CriterionCollection($criteria);
    }

    public function store(CriteriaControllerStoreRequest $request): CriterionResource
    {
        $criterion = Criterion::create($request->validated());

        return new CriterionResource($criterion);
    }

    public function show(Request $request, Criterion $criterion): CriterionResource
    {
        return new CriterionResource($criterion);
    }

    public function update(CriteriaControllerUpdateRequest $request, Criterion $criterion): CriterionResource
    {
        $criterion->update($request->validated());

        return new CriterionResource($criterion);
    }

    public function destroy(Request $request, Criterion $criterion): Response
    {
        $criterion->delete();

        return response()->noContent();
    }
}
