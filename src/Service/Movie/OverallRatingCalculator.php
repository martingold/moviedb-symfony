<?php declare(strict_types=1);

namespace App\Service\Movie;

use App\Entity\Movie;
use App\Entity\Rating;

class OverallRatingCalculator
{

    public function calculateOverallRating(Movie $movie): ?float
    {
        $count = $movie->getRatings()->count();
        if ($count === 0) {
            return null;
        }
        $sum = array_sum($movie->getRatings()->map(fn (Rating $rating) => $rating->getRating())->toArray());
        return ($sum * 10) / $count;
    }

}