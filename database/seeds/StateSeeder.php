<?php

use App\Enum\TableEnum;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    public function run()
    {
        DB::table(TableEnum::STATES)->truncate();
        $states = [
            "AA" => "Armed Forces Americas",
            "AE" => "Armed Forces Europe",
            "AK" => "Alaska",
            "AL" => "Alabama",
            "AP" => "Armed Forces Pacific",
            "AR" => "Arkansas",
            "AS" => "American Samoa",
            "AZ" => "Arizona",
            "CA" => "California",
            "CO" => "Colorado",
            "CT" => "Connecticut",
            "DC" => "District of Columbia",
            "DE" => "Delaware",
            "FL" => "Florida",
            "GA" => "Georgia",
            "GU" => "Guam",
            "HI" => "Hawaii",
            "IA" => "Iowa",
            "ID" => "Idaho",
            "IL" => "Illinois",
            "IN" => "Indiana",
            "KS" => "Kansas",
            "KY" => "Kentucky",
            "LA" => "Louisiana",
            "MA" => "Massachusetts",
            "MD" => "Maryland",
            "ME" => "Maine",
            "MI" => "Michigan",
            "MN" => "Minnesota",
            "MO" => "Missouri",
            "MP" => "Northern Mariana Islands",
            "MS" => "Mississippi",
            "MT" => "Montana",
            "NC" => "North Carolina",
            "ND" => "North Dakota",
            "NE" => "Nebraska",
            "NH" => "New Hampshire",
            "NJ" => "New Jersey",
            "NM" => "New Mexico",
            "NV" => "Nevada",
            "NY" => "New York",
            "OH" => "Ohio",
            "OK" => "Oklahoma",
            "OR" => "Oregon",
            "PA" => "Pennsylvania",
            "PR" => "Puerto Rico",
            "RI" => "Rhode Island",
            "SC" => "South Carolina",
            "SD" => "South Dakota",
            "TN" => "Tennessee",
            "TX" => "Texas",
            "UM" => "United States Minor Outlying Islands",
            "UT" => "Utah",
            "VA" => "Virginia",
            "VI" => "Virgin Islands, U.S.",
            "VT" => "Vermont",
            "WA" => "Washington",
            "WI" => "Wisconsin",
            "WV" => "West Virginia",
            "WY" => "Wyoming"
        ];
        foreach ($states as $code => $name) {
            State::create([
                'country_id' => 1,
                'code' => $code,
                'name' => $name
            ]);
        }
    }
}
