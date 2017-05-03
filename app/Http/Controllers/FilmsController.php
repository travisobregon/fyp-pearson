<?php

namespace App\Http\Controllers;

use App\Film;
use Folklore\GraphQL\Support\Facades\GraphQL;

class FilmsController extends Controller
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
        $page = request()->has('page') ? request()->page : 1;
        $query = "
            {
              films (page: ${page}) {
                id
                language {
                  name
                }
                title
                description
                release_year
                rental_duration
                rental_rate
                length
                replacement_cost
                rating
                stars
                special_features
                created_at
                updated_at
              }
            }
        ";
        $films = collect(GraphQL::queryAndReturnResult($query)->data['films'])->map(function ($film) {
            $film = collect($film)->map(function ($field) {
                return is_array($field) ? (object) $field : $field;
            })->toArray();

            return (object) $film;
        });

        return view('films.index', compact('films', 'page'));
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
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
