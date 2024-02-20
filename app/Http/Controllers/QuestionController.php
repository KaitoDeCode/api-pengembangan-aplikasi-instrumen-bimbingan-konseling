<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest as QuestionControllerStoreRequest;
use App\Http\Requests\QuestionUpdateRequest as QuestionControllerUpdateRequest;
use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    public function index(Request $request): QuestionCollection
    {
        $questions = Question::all();

        return new QuestionCollection($questions);
    }

    public function store(QuestionControllerStoreRequest $request): QuestionResource
    {
        $question = Question::create($request->validated());

        return new QuestionResource($question);
    }

    public function show(Request $request, Question $question): QuestionResource
    {
        return new QuestionResource($question);
    }

    public function update(QuestionControllerUpdateRequest $request, Question $question): QuestionResource
    {
        $question->update($request->validated());

        return new QuestionResource($question);
    }

    public function destroy(Request $request, Question $question): Response
    {
        $question->delete();

        return response()->noContent();
    }
}
