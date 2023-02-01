<?php

namespace App\Http\Controllers;

use App\Mail\ReservationMade;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    public function newReservation_start(Request $request){
        $data = $request->validate([
            'srv' => 'required|integer',
            'lct' => 'required|integer',
            'start' => 'required|integer',
            'end' => 'required|integer',
        ]);

        $location_name = Location::find($data['lct'])->name;
        $service_name = Service::find($data['srv'])->name;

        // Testataan onko käyttäjä kirjautuneena ja viedään tieto fronttiin.
        // Jos on, frontin puolella varauslomakkeen kentät täytetään automaattisesti
        // ja annetaan input-elementeille readonly-attribuutti.

        $login = false;
        if(Auth::check()){
            $login = true;
        }

        return view('varaa', [ 'service' => $data['srv'], 'location' => $data['lct'], 'ts_start' => $data['start'], 'ts_end' => $data['end'], 'locationName' => $location_name, 'serviceName' => $service_name, 'login' => $login ]);
    }

    public function newReservation_make(Request $request){
        try{
            $data = $request->validate([
                'fname' => 'required|string',
                'lname' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|string',
                'ts_start' => 'required|integer',
                'ts_end' => 'required|integer',
                'service' => 'required|integer',
                'location' => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            dd($e);
        }

        // Testataan ensin, onko käyttäjä kirjautunut sisään
        
        $login = false;
        if(Auth::check()){
            $login = true;
        }

        if($login){ // Jos on, otetaan käyttäjän tunnistautumiskoodi ja ID talteen
            $authcode = Auth::user()->authcode;
            $cust_ID = Auth::user()->id;
        } else { // Jos ei, testataan onko käyttäjällä jo tunnukset olemassa
            $search = Customer::query('customers')
                ->where('email', '=', $data['email'])
                ->where('phone', '=', $data['phone'])
                ->where('firstname', '=', $data['fname'])
                ->where('lastname', '=', $data['lname'])
                ->limit(1)
                ->get()
                ->first();

            if(!empty($search)){
                $cust_ID = $search['id'];
                $authcode = $search['authcode'];
            } else { // Jos ei, luodaan uusi tilapäinen käyttäjätunnus
                $authcode = rand(10000,99999);

                $createdCustomer = Customer::create([
                    'firstname' => $data['fname'],
                    'lastname' => $data['lname'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'authcode' => $authcode
                ]);

                $cust_ID = $createdCustomer->id;
            }
        }

        $t_start = date("Y-m-d H:i:s", $data['ts_start']);
        $t_end = date("Y-m-d H:i:s", $data['ts_end']);

        // Luodaan uusi ajanvaraus annetuilla tiedoilla

        $createdReservation = Reservation::create([
            'location_id' => $data['location'],
            'service_id' => $data['service'],
            'customer_id' => $cust_ID,
            't_start' => $t_start,
            't_end' => $t_end
        ]);

        $customer = Customer::where('id', $cust_ID)->get()->first();

        Mail::to($customer->email)->send(new ReservationMade($createdReservation));

        return view('success', [ 'authcode' => $authcode ]);
    }

    
}
