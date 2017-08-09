<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class UsStateCodeValidationRuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('us_state_code', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();

            // All state codes.
            $stateCodes = [
                'AL',
                'AK',
                'AZ',
                'AR',
                'AA',
                'AE',
                'AP',
                'CA',
                'CO',
                'CT',
                'DE',
                'DC',
                'FL',
                'GA',
                'HI',
                'ID',
                'IL',
                'IN',
                'IA',
                'KS',
                'KY',
                'LA',
                'ME',
                'MD',
                'MA',
                'MI',
                'MN',
                'MS',
                'MO',
                'MT',
                'NE',
                'NV',
                'NH',
                'NJ',
                'NM',
                'NY',
                'NC',
                'ND',
                'OH',
                'OK',
                'OR',
                'PA',
                'RI',
                'SC',
                'SD',
                'TN',
                'TX',
                'UT',
                'VT',
                'VA',
                'WA',
                'WV',
                'WI',
                'WY'
            ];

            return in_array($data['state'], $stateCodes);
        });
    }

    // #TODO setup psr2 thing

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
