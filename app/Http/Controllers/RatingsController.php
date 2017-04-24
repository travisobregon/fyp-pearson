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
        $wasSuggested = collect(Suggestion::find(auth()->id())->films)->has(request()->filmId);

        Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'film_id' => request()->filmId],
            ['stars' => request()->rating, 'was_suggested' => $wasSuggested]
        );

        $film = Film::find(request()->filmId);
        $film->stars = round(Rating::where('film_id', request()->filmId)->avg('stars'));
        $film->save();

        $correlations = collect();

        foreach (User::where('id', '<>', auth()->id())->get() as $otherUser) {
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
            ['user_id' => auth()->id()],
            ['other_users' => $correlations]
        );

        $suggestions = [];

        $nearestUsers = collect($similarity->other_users)
            ->sortByDesc('correlation')
            ->take(3);

        $totalDistance = $nearestUsers->sum('correlation');

        foreach ($nearestUsers as $nearestUser) {
            $weight = $nearestUser['correlation'] / $totalDistance;
            $neighbour = User::with('ratings')->find($nearestUser['user_id']);

            $neighbourRatings = $neighbour->ratings->reject(function ($otherUserRating) {
                return auth()->user()->ratings->contains(function ($userRating) use ($otherUserRating) {
                    return $userRating->film_id === $otherUserRating->film_id;
                });
            });

            foreach ($neighbourRatings as $neighbourRating) {
                if (isset($suggestions[$neighbourRating->film_id])) {
                    $suggestions[$neighbourRating->film_id] = $suggestions[$neighbourRating->film_id] + $neighbourRating->stars * $weight;
                } else {
                    $suggestions[$neighbourRating->film_id] = $neighbourRating->stars * $weight;
                }
            }
        };

        arsort($suggestions);

        $suggestions = collect($suggestions)->take(10)
            ->map(function ($weight, $filmId) use ($nearestUsers) {
                $predictedRating = null;
                $totalDistance = 0.0;
                $neighbours = [];

                foreach ($nearestUsers as $nearestUser) {
                    $neighbour = User::with('ratings')->find($nearestUser['user_id']);

                    if ($neighbour->ratings->contains(function ($rating) use ($filmId) {
                        return $filmId == $rating->film_id;
                    })) {
                        $totalDistance += $nearestUser['correlation'];
                        $neighbours[] = $nearestUser;
                    }
                }

                foreach ($neighbours as $neighbour) {
                    $stars = Rating::where('user_id', $neighbour['user_id'])->where('film_id', $filmId)->first()->stars;
                    $predictedRating += $stars * ($neighbour['correlation'] / $totalDistance);
                }

                return [
                    'predicted_rating' => $predictedRating,
                ];
            });

        Suggestion::updateOrCreate(
            ['user_id' => auth()->id()],
            ['films' => $suggestions]
        );

        return $film->stars;
    }
}
