<?php  namespace App\Http\ViewComposers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class RequestDatePicker
{
    /**
     * Bind data to the view.
     * Create the date restrictions for use in HTML5 date pickers
     * Holidays can only be requested for the current year
     * Provide a start date of today and end date of December 31st
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $restrictions = [
            'start' => Carbon::today()->toDateString(),
            'end'   => (new Carbon())->endOfYear()->toDateString(),
        ];
        $view->with('restrictions', $restrictions);
    }
}

