<?php

namespace App\Http\Controllers;

use App\Mail\ReservationCanceled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Location;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // ACCESSORIT

    private function getReservations() {
        $reservations = Reservation::orderBy('t_start', 'asc')->get();
        return $reservations;
    }

    private function getCustomers() {
        $customers = Customer::all();
        return $customers;
    }

    private function getCustomerInfo($id){
        $customer = Customer::where('id', $id)->get()->first();
        return $customer;
    }

    private function getLocations() {
        $locations = Location::all();
        return $locations;
    }

    private function getLocationInfo($id) {
        $location = Location::where('id', $id)->get()->first();
        return $location;
    }

    private function getAdmins() {
        $admins = Admin::all();
        return $admins;
    }

    private function getServices() {
        $services = Service::all();
        return $services;
    }

    private function getServiceInfo($id){
        $service = Service::where('id', $id)->get()->first();
        return $service;
    }



    // TOIMIPISTEIDEN HALLINTAMETODIT

    public function locationCreator(){
        $services = $this->getServices();
        return view('createlocation', ['services' => $services]);
    }

    public function locationEditor(Request $request) {
        $data = $request->validate([
            'lct_id' => 'required|integer'
        ]);
        $location = $this->getLocationInfo($data['lct_id']);
        $services = $this->getServices();
        return view('editlocation', ['location' => $location, 'services' => $services]);
    }

    private static function newLocation($data, $open, $available_services, $open_exceptions){
        $newLocation = Location::create([
            'city' => $data['city'],
            'address' => $data['address'],
            'zip' => $data['zip'],
            'name' => $data['lctname'],
            'open' => $open,
            'available_services' => $available_services,
            'open_exceptions' => $open_exceptions
        ]);
    }

    private static function updateLocation($data, $open, $available_services, $open_exceptions){
        $updatedLocation = Location::find($data['lct_id']);

        $updatedLocation->city = $data['city'];
        $updatedLocation->address = $data['address'];
        $updatedLocation->zip = $data['zip'];
        $updatedLocation->name = $data['lctname'];
        $updatedLocation->open = $open;
        $updatedLocation->available_services = $available_services;
        $updatedLocation->open_exceptions = $open_exceptions;

        $updatedLocation->save();
    }

    public static function deleteLocation(Request $request){
        $data = $request->validate(['location_id' => 'required|integer']);
        $id = $data['location_id'];
        $deleted = Location::where('id', $id)->delete();
    }

    public function locationFormHandle(Request $request) {
        $data = $request->validate([
            'action' => 'required|string',
            'lct_id' => 'nullable|integer',
            'lctname' => 'required|string',
            'address' => 'required|string',
            'zip' => 'required|string',
            'city' => 'required|string',

            'ma-open' => 'nullable|string',
            'ma-close' => 'nullable|string',
            'ti-open' => 'nullable|string',
            'ti-close' => 'nullable|string',
            'ke-open' => 'nullable|string',
            'ke-close' => 'nullable|string',
            'to-open' => 'nullable|string',
            'to-close' => 'nullable|string',
            'pe-open' => 'nullable|string',
            'pe-close' => 'nullable|string',
            'la-open' => 'nullable|string',
            'la-close' => 'nullable|string',
            'su-open' => 'nullable|string',
            'su-close' => 'nullable|string',

            'available-ma' => 'nullable|array',
            'available-ma.*' => 'integer',
            'available-ti' => 'nullable|array',
            'available-ti.*' => 'integer',
            'available-ke' => 'nullable|array',
            'available-ke.*' => 'integer',
            'available-to' => 'nullable|array',
            'available-to.*' => 'integer',
            'available-pe' => 'nullable|array',
            'available-pe.*' => 'integer',
            'available-la' => 'nullable|array',
            'available-la.*' => 'integer',
            'available-su' => 'nullable|array',
            'available-su.*' => 'integer',

            'open-exceptions' => 'sometimes|array'
        ]);

        $open = (object)[];
        $available_services = (object)[];
        $open_exceptions = (object)[];

        if(isset($data['ma-open'])){
            $open->ma = [$data['ma-open'], $data['ma-close']];
        } else {
            $open->ma = null;
        }

        if(isset($data['ti-open'])){
            $open->ti = [$data['ti-open'], $data['ti-close']];
        } else {
            $open->ti = null;
        }

        if(isset($data['ke-open'])){
            $open->ke = [$data['ke-open'], $data['ke-close']];
        } else {
            $open->ke = null;
        }

        if(isset($data['to-open'])){
            $open->to = [$data['to-open'], $data['to-close']];
        } else {
            $open->to = null;
        }

        if(isset($data['pe-open'])){
            $open->pe = [$data['pe-open'], $data['pe-close']];
        } else {
            $open->pe = null;
        }

        if(isset($data['la-open'])){
            $open->la = [$data['la-open'], $data['la-close']];
        } else {
            $open->la = null;
        }

        if(isset($data['su-open'])){
            $open->su = [$data['su-open'], $data['su-close']];
        } else {
            $open->su = null;
        }

        if(!empty($data['available-ma'])) {
            $available_services->ma = $data['available-ma'];
        } else {
            $available_services->ma = null;
        }

        if(!empty($data['available-ti'])) {
            $available_services->ti = $data['available-ti'];
        } else {
            $available_services->ti = null;
        }

        if(!empty($data['available-ke'])) {
            $available_services->ke = $data['available-ke'];
        } else {
            $available_services->ke = null;
        }

        if(!empty($data['available-to'])) {
            $available_services->to = $data['available-to'];
        } else {
            $available_services->to = null;
        }

        if(!empty($data['available-pe'])) {
            $available_services->pe = $data['available-pe'];
        } else {
            $available_services->pe = null;
        }

        if(!empty($data['available-la'])) {
            $available_services->la = $data['available-la'];
        } else {
            $available_services->la = null;
        }

        if(!empty($data['available-su'])) {
            $available_services->su = $data['available-su'];
        } else {
            $available_services->su = null;
        }

        if(isset($data['open-exceptions'])){
            foreach($data['open-exceptions'] as $exceptiondate){
                $dateUNIX = strtotime($exceptiondate[0]);
                $dateString = date("m-d", $dateUNIX);
                if(is_null($exceptiondate[1]) || is_null($exceptiondate[2])){
                    $open_exceptions->$dateString = null;
                } else {
                    $times = array($exceptiondate[1], $exceptiondate[2]);
                    $open_exceptions->$dateString = $times;
                }
            }
        }

        if($data['action'] == "create"){
            $this->newLocation($data, $open, $available_services, $open_exceptions);
        } elseif($data['action'] == "edit") {
            $this->updateLocation($data, $open, $available_services, $open_exceptions);
        }

        return redirect()->intended(url('/admin/adminpanel'));
    }



    // VARAUKSIEN HALLINTAMETODIT

    public static function deleteReservation(Request $request) {
        $data = $request->validate(['rsrv_id' => 'required|integer']);
        $id = $data['rsrv_id'];
        $reservation = Reservation::where('id', $id)->get()->first();
        $customer = Customer::where('id', $reservation->customer_id)->get()->first();
        Mail::to($customer->email)->send(new ReservationCanceled($reservation));
        $deleted = Reservation::where('id', $id)->delete();
    }

    public function updateReservation(Request $request) {
        $data = $request->validate([
            'start' => 'required|integer',
            'end' => 'required|integer',
            'rsrv_id' => 'required|integer'
        ]);

        $start = date("Y-m-d H:i:s", $data['start']);
        $end = date("Y-m-d H:i:s", $data['end']);
        $id = $data['rsrv_id'];

        $updatedReservation = Reservation::where('id', $id)->get()->first();

        $updatedReservation->t_start = $start;
        $updatedReservation->t_end = $end;

        $updatedReservation->save();

        return redirect()->intended(url('/admin/adminpanel'));
    }

    

    // PALVELUIDEN HALLINTAMETODIT

    public function serviceEditor(Request $request) {
        $data = $request->validate([
            'srvc_id' => 'required|integer'
        ]);
        $service = $this->getServiceInfo($data['srvc_id']);
        return view('editservice', ['service' => $service]);
    }

    private static function newService($data, $available, $cancellable, $cancel_within){
        $newService = Service::create([
            'name' => $data['srvcname'],
            'available' => $available,
            't_est' => $data['t_est'],
            'cancellable' => $cancellable,
            'cancel_within' => $cancel_within
        ]);
    }

    private static function updateService($data, $available, $cancellable, $cancel_within) {
        $updatedService = Service::find($data['srvc_id']);

        $updatedService->name = $data['srvcname'];
        $updatedService->available = $available;
        $updatedService->t_est = $data['t_est'];
        $updatedService->cancellable = $cancellable;
        $updatedService->cancel_within = $cancel_within;

        $updatedService->save();
    }

    public function serviceFormHandle(Request $request) {
        try {
            $data = $request->validate([
                'srvc_id' => 'nullable|integer',
                'action' => 'required|string',
                'srvcname' => 'required|string',
                't_est' => 'required|numeric',
                'available' => 'sometimes|accepted',
                'cancellable' => 'sometimes|accepted',
                'cancellable_timeframe' => 'nullable|numeric'
            ]);
        } catch(ValidationException $e) {
            dd($e->errors());
        };

        if(!isset($data['available'])) {
            $available = 0;
        } else {
            $available = 1;
        }

        if(!isset($data['cancellable'])){
            $cancellable = 0;
        } else {
            $cancellable = 1;
        }

        if(!isset($data['cancellable_timeframe'])){
            $cancel_within = null;
        } else {
            $cancel_within = $data['cancellable_timeframe'];
        }

        if($data['action'] == "create") {
            $this->newService($data, $available, $cancellable, $cancel_within);
        } elseif($data['action'] == "edit") {
            $this->updateService($data, $available, $cancellable, $cancel_within);
        }
        
        return redirect()->intended(url('/admin/adminpanel'));
    }
    
    public function deleteService(Request $request){
        $data = $request->validate([
            'service_id' => 'required|integer'
        ]);

        $id = $data['service_id'];

        //  Poistetaan palvelulle tehdyt ajanvaraukset

        $deletedReservations = Reservation::where('service_id', $id)->delete();

        $locations = $this->getLocations();
        $updatedLocationIDs = array();
        $updatedAvailableObject = (object)[];

        //  Poistetaan palvelun ID toimipisteiden tarjottavien palvelujen listasta

        foreach($locations as $location) {
            $available_services = $location->available_services;
            foreach($available_services as $day => $day_array){
                if(!is_null($day_array)){
                    if(in_array($id, $day_array)){
                        if(($key = array_search($id, $day_array)) !== false){
                            unset($day_array[$key]);
                            $updatedAvailableObject->$day = $day_array;
                        }
                        if(!in_array($location->id, $updatedLocationIDs)){
                            array_push($updatedLocationIDs, $location->id);
                        }
                    } else {
                        $updatedAvailableObject->$day = $day_array;
                    }
                } else {
                    $updatedAvailableObject->$day = null;
                }
            }

            $updatedLocation = Location::find($location->id);
            $updatedLocation->available_services = $updatedAvailableObject;
            $updatedLocation->save();
            
        }

        $deletedService = Service::where('id', $id)->delete();



    }



    // ASIAKASTILIEN HALLINTAMETODIT

    public static function deleteCustomer(Request $request) {
        $data = $request->validate(['customer_id' => 'required|integer']);
        $id = $data['customer_id'];
        $deletedReservations = Reservation::where('customer_id', $id)->delete();
        $deleted = Customer::where('id', $id)->delete();
    }

    public function customerEditor(Request $request){
        $data = $request->validate([
            'cstmr_id' => 'required|integer'
        ]);
        $customer = $this->getCustomerInfo($data['cstmr_id']);

        return view('editcustomer', ['customer' => $customer]);        
    }

    public function updateCustomer(Request $request){
        $data = $request->validate([
            'cstmr_id' => 'required|integer',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'authcode' => 'required|string'
        ]);

        $updatedCustomer = Customer::find($data['cstmr_id']);

        $updatedCustomer->firstname = $data['fname'];
        $updatedCustomer->lastname = $data['lname'];
        $updatedCustomer->email = $data['email'];
        $updatedCustomer->phone = $data['phone'];
        $updatedCustomer->authcode = $data['authcode'];

        $updatedCustomer->save();

        return redirect()->intended(url('/admin/adminpanel'));
    }

    public function deleteExpired(){
        $deletedReservations = Reservation::where('t_end', '<=', now())->get();
        $deletedReservationIDs = array();
        $deletedCustomerIDs = array();
        $deletedCustomers = array();
        
        foreach($deletedReservations as $el) {
            array_push($deletedReservationIDs, $el->id);
            $el->delete();
        }

        //  Tarkistetaan samalla, onko olemassa asiakastilejä joilla ei ole
        //  voimassaolevia varauksia. Poistetaan jos löytyy

        $customers = $this->getCustomers();

        foreach($customers as $customer) {
            $reservations = Reservation::where('customer_id', $customer->id)->get();
            if(count($reservations) == 0){
                array_push($deletedCustomers, $customer);
                array_push($deletedCustomerIDs, $customer->id);
            }
        }

        foreach($deletedCustomerIDs as $id){
            $deletedCustomer = Customer::where('id', $id)->delete();
        }

        //  Palautetaan poistettujen varauksien ID:t sisältävä array käyttöliittymän
        //  päivittämistä varten

        return["deleted" => $deletedReservationIDs];
    }



    // VALVOJATILIEN HALLINTAMETODIT

    public function createAdmin(Request $request){
        $data = $request->validate([
            'username' => 'required|unique:admins,username|string',
            'password' => 'required|confirmed|string',
            'password_confirmation' => 'required|string',
            'nimdaperm' => 'required|integer'
        ]);

        $newAdmin = Admin::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'admin' => $data['nimdaperm'] 
        ]);

        return redirect()->intended(url('/admin/adminpanel'));
    }

    public static function deleteAdmin(Request $request){
        $data = $request->validate([
            'admin_id' => 'required|integer'
        ]);
        $admins = Admin::all();
        if(count($admins) > 1){ //  Jotta ainoaa admin-käyttäjää ei voisi poistaa
            $deleted = Admin::where('id', $data['admin_id'])->delete();
        }
        
    }

    public function adminEditor(Request $request){
        $data = $request->validate([
            'admin_id' => 'required|integer'
        ]);
        return view('editadmin', ['admin_id' => $data['admin_id']]);
    }

    public function changePassword(Request $request){
        $data = $request->validate([
            'admin_id' => 'required|integer',
            'password_user' => 'required|current_password:admin',
            'password_new' => 'required|confirmed|string',
            'password_new_confirmation' => 'required|string'
        ]);

        $updatedAdmin = Admin::find($data['admin_id']);
        $updatedAdmin->password = Hash::make($data['password_new']);
        $updatedAdmin->save();
        
        return redirect()->intended(url('/admin/adminpanel'));
        
    }



    // KIRJAUTUMISMETODIT YMS

    public function adminLogin(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(auth()->guard('admin')->attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $user = auth()->user();

            return redirect()->intended(url('/admin/adminpanel'));
        }

        return back()->withErrors([
            'username' => 'Antamasi tiedot eivät täsmää.'
        ]);
        
    }

    public function adminpanel(){
        $reservations = $this->getReservations();
        $customers = $this->getCustomers();
        $locations = $this->getLocations();
        $admins = $this->getAdmins();
        $services = $this->getServices();
        return view('adminpanel', ['reservations' => $reservations, 'customers' => $customers, 'locations' => $locations, 'admins' => $admins, 'services' => $services, 'directTo' => 'home']);
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
