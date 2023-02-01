<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Reservation;

class RemoveExpiredCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:rmexpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poistaa asiakaskäyttäjätilit, joilla ei ole enää voimassaolevia varauksia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $acctIDs = array();
        foreach (Customer::all() as $customer) {
            array_push($acctIDs, $customer->id);
        }
        foreach ($acctIDs as $id) {
            $count = Reservation::where('customer_id', $id)->count();
            if($count == 0){
                $deleted = Customer::where('id', $id)->delete();
            }
        }
        return 0;
    }
}
