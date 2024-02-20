<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerControllerStoreRequest;
use App\Http\Requests\AnswerControllerUpdateRequest;
use App\Http\Resources\AnswerCollection;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    public function index(Request $request): AnswerCollection
    {
        $answers = Answer::all();

        return new AnswerCollection($answers);
    }

    public function store(AnswerControllerStoreRequest $request): AnswerResource
    {
        $answer = Answer::create($request->validated());

        return new AnswerResource($answer);
    }

    public function show(Request $request, Answer $answer): AnswerResource
    {
        return new AnswerResource($answer);
    }

    public function update(AnswerControllerUpdateRequest $request, Answer $answer): AnswerResource
    {
        $answer->update($request->validated());

        return new AnswerResource($answer);
    }

    public function destroy(Request $request, Answer $answer): Response
    {
        $answer->delete();

        return response()->noContent();
    }
}
