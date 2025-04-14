<?php

namespace App\Observers;

use App\Models\Business;
use App\Models\Appointmenter;
use App\Models\ReviewAndRating;
use Illuminate\Support\Facades\Bus;

class ReviewAndRatingObserver
{
    /**
     * Handle the ReviewAndRating "created" event.
     */
    public function created(ReviewAndRating $reviewAndRating): void
    {
        // Update the business rating
        $busineess_rating = ReviewAndRating::where('business_id', $reviewAndRating->business_id)
            // ->where('status', 'active')
            ->avg('rating');

        Business::where('id', $reviewAndRating->business_id)
            ->update([
                'rating' => $busineess_rating,
            ]);

        // Update the appointmenter rating
        if ($reviewAndRating->review_type == 'professional') {
            $appointmenter_rating = ReviewAndRating::where('review_on_id', $reviewAndRating->review_on_id)
                ->where('review_type', 'professional')
                // ->where('status', 'active')
                ->avg('rating');
            Appointmenter::where('id', $reviewAndRating->review_on_id)
                ->update([
                    'rating' => $appointmenter_rating,
                ]);
        }
    }

    /**
     * Handle the ReviewAndRating "updated" event.
     */
    public function updated(ReviewAndRating $reviewAndRating): void
    {
        //
    }

    /**
     * Handle the ReviewAndRating "deleted" event.
     */
    public function deleted(ReviewAndRating $reviewAndRating): void
    {
        //
    }

    /**
     * Handle the ReviewAndRating "restored" event.
     */
    public function restored(ReviewAndRating $reviewAndRating): void
    {
        //
    }

    /**
     * Handle the ReviewAndRating "force deleted" event.
     */
    public function forceDeleted(ReviewAndRating $reviewAndRating): void
    {
        //
    }
}
