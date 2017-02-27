<?php

if (! function_exists('pearson')) {
    function pearson($user, $otherUser)
    {
        $sumXY = 0;
        $sumX = 0;
        $sumY = 0;
        $sumX2 = 0;
        $sumY2 = 0;
        $n = 0;

        foreach ($user->ratings as $rating) {
            $otherUserRatings = $otherUser->ratings;

            if (! $otherUserRatings->contains(function ($value) use ($rating) {
                return $value->film_id === $rating->film_id;
            })) {
                continue;
            } else {
                $otherUserRating = $otherUserRatings->first(function ($value) use ($rating) {
                    return $value->film_id === $rating->film_id;
                });
            }

            $n++;
            $sumXY += $rating->stars * $otherUserRating->stars;
            $sumX += $rating->stars;
            $sumY += $otherUserRating->stars;
            $sumX2 += $rating->stars ** 2;
            $sumY2 += $otherUserRating->stars ** 2;
        }

        if ($n === 0) {
            return null;
        }

        $denominator = sqrt($sumX2 - ($sumX ** 2) / $n) * sqrt($sumY2 - ($sumY ** 2) / $n);

        if ($denominator == 0) {
            return null;
        }

        return ($sumXY - ($sumX * $sumY) / $n) / $denominator;
    }
}