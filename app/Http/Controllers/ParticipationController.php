<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipationStoreRequest;
use App\Http\Requests\ParticipationUpdateRequest;
use App\Http\Resources\ParticipationCollection;
use App\Http\Resources\ParticipationResource;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParticipationController extends Controller
{
    public function index(Request $request): ParticipationCollection
    {
        $participations = Participation::all();

        return new ParticipationCollection($participations);
    }

    public function store(ParticipationStoreRequest $request): ParticipationResource
    {
        $participation = Participation::create($request->validated());

        return new ParticipationResource($participation);
    }

    public function show(Request $request, Participation $participation): ParticipationResource
    {
        return new ParticipationResource($participation);
    }

    public function update(ParticipationUpdateRequest $request, Participation $participation): ParticipationResource
    {
        $participation->update($request->validated());

        return new ParticipationResource($participation);
    }

    public function destroy(Request $request, Participation $participation): Response
    {
        $participation->delete();

        return response()->noContent();
    }
}
