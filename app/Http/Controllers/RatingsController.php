<?php

namespace App\Http\Controllers;

use App\Film;
use App\Rating;
use App\Similarity;
use App\Suggestion;
use App\User;

class RatingsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Rating::updateOrCreate(
            ['user_id' => auth()->user()->id, 'film_id' => request()->filmId],
            ['stars' => request()->rating]
        );

        $film = Film::find(request()->filmId);
        $film->stars = round(Rating::where('film_id', request()->filmId)->avg('stars'));
        $film->save();

        $correlations = collect();

        foreach (User::where('id', '<>', auth()->user()->id)->get() as $otherUser) {
            $correlation = pearson(auth()->user(), $otherUser);

            if (! is_null($correlation)) {
                $correlations->push([
                    'user_id' => $otherUser->id,
                    'correlation' => $correlation
                ]);
            }
        }

        $correlations = $correlations->sortByDesc('correlation');

        $similarity = Similarity::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['other_users' => $correlations]
        );

        $suggestions = collect();

        foreach (collect($similarity->other_users)->sortByDesc('correlation') as $otherUser) {
            $ratings = User::find($otherUser['user_id'])
                ->ratings
                ->reject(function ($otherUserRating) {
                    return auth()->user()->ratings->contains(function ($userRating) use ($otherUserRating) {
                        return $userRating->film_id === $otherUserRating->film_id;
                    });
                })
                ->filter(function ($otherUserRating) {
                    return $otherUserRating->stars >= 3;
                })
                ->sortByDesc('stars')
                ->pluck('film_id');

            if (! $ratings->isEmpty()) {
                foreach ($ratings as $rating) {
                    $suggestions[] = $rating;

                    if ($suggestions->count() >= 10) {
                        break 2;
                    }
                }
            }

            $suggestions = $suggestions->flatten()->unique();
        }

        Suggestion::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['films' => $suggestions]
        );

        return $film->stars;
    }
}
