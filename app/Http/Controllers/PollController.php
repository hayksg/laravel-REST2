<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Poll as PollResource;
use App\Poll;
use Validator;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polls = Poll::all();
        return response()->json($polls, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->all();
        $poll = Poll::create($data);
        return response()->json($poll, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*$poll = Poll::find($id);
        if (is_null($poll)) {
            return response()->json(null, 404);
        }*/

        $poll = Poll::findOrFail($id);
        $response = new PollResource($poll, 200);

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        $data = $request->all();
        $poll->update($data);
        return response()->json($poll, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        $poll->delete();
        return response()->json(null, 204);
    }

    public function errors() {
        return response()->json(['msg' => 'Payment is required.'], 402); // Payment is required. - for example
    }

    public function questions(Request $request, Poll $poll) {
        $questions = $poll->questions;
        return response()->json($questions, 200);
    }
}
