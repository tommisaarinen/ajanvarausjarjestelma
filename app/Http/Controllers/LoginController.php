<?php

namespace App\Http\Controllers;

use App\Mail\ReservationCanceled;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Service;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    private function getReservations(){
        $reservations = Reservation::where('customer_id', Auth::user()->id)
            ->orderBy('t_start', 'asc')
            ->get();

        return $reservations;    
    }

    public function gotoDashboard(){
        try {
            $reservations = $this->getReservations();
        } catch (Exception $e) {
            return redirect('/');
        }
        
        return view('dashboard', [ 'reservations' => $reservations ]);
    }

    public function cancelReservation(Request $request){
        $data = $request->validate([
            'reservation_id' => 'required|integer'
        ]);

        $reservationID = $data['reservation_id'];
        $reservation = Reservation::where('id', $reservationID)->get()->first();
        $customer = Customer::where('id', $reservation->customer_id)->get()->first();
        Mail::to($customer->email)->send(new ReservationCanceled($reservation));
        $deleted = Reservation::where('id', $reservationID)->delete();
        return redirect()->intended(url('/dashboard'));
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'tel_email' => ['required'],
            'authcode' => ['required']
        ]);

        $isEmail = strpos($credentials['tel_email'], '@') !== false;

        
        $user = Customer::when($isEmail, function ($q) use ($credentials) {
            $q->where('email', $credentials['tel_email']);
        })->when(!$isEmail, function ($q) use ($credentials) {
            $q->where('phone', $credentials['tel_email']);
        })->first();

        if ($user && ($credentials['authcode'] == $user->authcode)){
            Auth::loginUsingId($user->id);
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'tel_email' => 'Antamasi tiedot eivät täsmää.'
        ])->onlyInput('tel_email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
