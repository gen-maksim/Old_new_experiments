<?php

namespace App\Http\Controllers;

use App\Training;
use App\TrainingPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = Training::all();
        $trainings->loadCount('active_applications');

        return view('trainings',
            compact('trainings')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $training_places = TrainingPlace::all();
        return view('trainings.create', compact('training_places'));
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
        Training::create(array_merge($request->all(), ['owner_id' => auth()->id()]));

        DB::commit();
        return redirect(route('user.profile', auth()->id()));
    }


    /**
     * @param Training $training
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        return response([
            'data' => compact('training'),
        ]);
    }


    public function destroy(Training $training)
    {
        $training->cancel();

        return response('success');
    }
}
