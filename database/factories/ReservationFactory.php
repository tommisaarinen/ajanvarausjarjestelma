<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Reservation::class;

    private function getBusinessHours($weekday, $location_open){
        switch($weekday) {
            case 'Mon':
                $open_selected = $location_open["ma"];
            break;
            case 'Tue':
                $open_selected = $location_open["ti"];
            break;
            case 'Wed':
                $open_selected = $location_open["ke"];
            break;
            case 'Thu':
                $open_selected = $location_open["to"];
            break;
            case 'Fri':
                $open_selected = $location_open["pe"];
            break;
            case 'Sat':
                $open_selected = $location_open["la"];
            break;
            case 'Sun':
                $open_selected = $location_open["su"];
            break;
        }
        return $open_selected;
    }

    private function dateFaker($service, $location){
        $delta = Service::find($service)->t_est;
        $location_open = Location::find($location)->open;
        $deltaUNIX = $delta * 3600;
        $offset = rand(1, 60);
        $minuteOptions = array("00", "30");

        $dateStringDay = "+" . $offset . " days";
        $dateStringStart = $dateStringDay . " " . rand(8, 15) . ":" . $minuteOptions[array_rand($minuteOptions)];
        $startUNIX = strtotime($dateStringStart);
        $weekday = date("D", $startUNIX);
        
        $open_selected = $this->getBusinessHours($weekday, $location_open);

        $pass = false;

        while($pass === false){
            if(!is_null($open_selected)){
                $dateStringDay = date("Y-m-d", $startUNIX);
                $closingTimeString = $dateStringDay . " " . $open_selected[1];
                $openingTimeString = $dateStringDay . " " . $open_selected[0];
                $closingTimeUNIX = strtotime($closingTimeString);
                $openingTimeUNIX = strtotime($openingTimeString);
                if($startUNIX >= $openingTimeUNIX){
                    if(($startUNIX + $deltaUNIX) <= $closingTimeUNIX){
                        $pass = true;
                    } else {
                        $startUNIX = $startUNIX - 1800;
                        $pass = false;
                    }
                } else {
                    $startUNIX = $startUNIX + (12 * 3600);
                    $pass = false;
                }
            } else {
                $startUNIX = $startUNIX + (24 * 3600);
                $pass = false;
            }
            
            $weekday = date("D", $startUNIX);
            $open_selected = $this->getBusinessHours($weekday, $location_open);
        }

        $endUNIX = $startUNIX + $deltaUNIX;
        $formattedStart = date("Y-m-d H:i:s", $startUNIX);
        $formattedEnd = date("Y-m-d H:i:s", $endUNIX);
        $timeslot = array($formattedStart, $formattedEnd);
        return $timeslot;
    }

    public function definition()
    {
        $location_IDs = array();
        $customer_IDs = array();
        $service_IDs = array();

        $locationCollection = Location::all();
        foreach($locationCollection as $el){
            array_push($location_IDs, $el->id);
        }

        $location = $location_IDs[array_rand($location_IDs, 1)];

        $customerCollection = Customer::all();
        foreach($customerCollection as $el){
            array_push($customer_IDs, $el->id);
        }

        $serviceCollection = Service::all();
        foreach($serviceCollection as $el){
            array_push($service_IDs, $el->id);
        }

        $service = $service_IDs[array_rand($service_IDs, 1)];
        $timeslot = $this->dateFaker($service, $location);
        
        return [
            'location_id' => $location,
            'service_id' => $service,
            'customer_id' => $customer_IDs[array_rand($customer_IDs, 1)],
            't_start' => $timeslot[0],
            't_end' => $timeslot[1]
        ];
    }
}
