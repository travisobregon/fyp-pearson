<?php

namespace App\Http\Controllers;

use App\Film;
use App\Suggestion;

class SuggestionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suggestions = Suggestion::where('user_id', auth()->user()->id)->first(['films']);
        $films = [];

        if ($suggestions) {
            $films = collect(Suggestion::where('user_id', auth()->user()->id)->first(['films'])->films)
                ->map(function ($filmId) {
                    return Film::find($filmId);
                });
        }



        return view('suggestions.index', compact('films'));
    }
}
