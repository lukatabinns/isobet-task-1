<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Throwable;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // csvdate
        // Extension to the normal date validator to check specific CSV and Excel date formats
        Validator::extend('csvdate', function ($attribute, $value, $parameters, $validator) {
            // dd-mm-yy
            try {
                if (preg_match('/\d{2}-\d{2}-\d{2}/', $value) && $carbon = Carbon::createFromFormat('d-m-y', $value)) {
                    // make sure none of the values rolled over, which could mean the date was in a different format like m-d-y or y-m-d
                    [$day, $month, $year] = explode('-', $value);
                    if ($carbon->format('d') == $day && $carbon->format('m') == $month && $carbon->format('y') == $year) {
                        return true;
                    }
                }
            } catch (Throwable $e) { /* do nothing */ }

            // yyyy-mm-dd
            try {
                if (preg_match('/\d{4}-\d{2}-\d{2}/', $value) && $carbon = Carbon::createFromFormat('Y-m-d', $value)) {
                    // make sure none of the values rolled over, otherwise it might have been d-m-y
                    [$year, $month, $day] = explode('-', $value);
                    if ($carbon->format('d') == $day && $carbon->format('m') == $month && $carbon->format('Y') === $year) {
                        return true;
                    }
                }
            } catch (Throwable $e) { /* do nothing */ }

            // dd/mm/yyyy
            try {
                if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $value) && $carbon = Carbon::createFromFormat('d/m/Y', $value)) {
                    // make sure none of the values rolled over, which could mean the date was in a different format like m/d/Y
                    [$day, $month, $year] = explode('/', $value);
                    if ($carbon->format('d') == $day && $carbon->format('m') == $month && $carbon->format('Y') == $year) {
                        return true;
                    }
                }
            } catch (Throwable $e) { /* do nothing */ }

            // Excel date
            try {
                if (is_numeric($value)) {
                    $excelDate = ($value - 25569) * 86400;
                    if (Carbon::createFromFormat('U', $excelDate))
                        return true;
                }
            } catch (Throwable $e) { /* do nothing */ }

            // no match
            return false;
        }, ':attribute must be an Excel numeric date or a string in one of these formats: dd-mm-yy, dd/mm/yyyy or yyyy-mm-dd');
    }
}
