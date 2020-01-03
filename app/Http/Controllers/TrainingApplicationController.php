<?php

namespace App\Http\Controllers;

use App\TrainingApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->merge([
            'user_id' => auth()->id(),
        ]);
        TrainingApplication::create($request->all());
        DB::commit();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TrainingApplication  $trainingApplication
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingApplication $trainingApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrainingApplication  $trainingApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingApplication $trainingApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrainingApplication  $trainingApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingApplication $trainingApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrainingApplication  $trainingApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingApplication $trainingApplication)
    {
        //
    }
}
