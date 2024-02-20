<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstrumentStoreRequest as InstrumentControllerStoreRequest;
use App\Http\Requests\InstrumentUpdateRequest as InstrumentControllerUpdateRequest;
use App\Http\Resources\InstrumentCollection;
use App\Http\Resources\InstrumentResource;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstrumentController extends Controller
{
    public function index(Request $request): InstrumentCollection
    {
        $instruments = Instrument::all();

        return new InstrumentCollection($instruments);
    }

    public function store(InstrumentControllerStoreRequest $request): InstrumentResource
    {
        $instrument = Instrument::create($request->validated());

        return new InstrumentResource($instrument);
    }

    public function show(Request $request, Instrument $instrument): InstrumentResource
    {
        return new InstrumentResource($instrument);
    }

    public function update(InstrumentControllerUpdateRequest $request, Instrument $instrument): InstrumentResource
    {
        $instrument->update($request->validated());

        return new InstrumentResource($instrument);
    }

    public function destroy(Request $request, Instrument $instrument): Response
    {
        $instrument->delete();

        return response()->noContent();
    }
}
