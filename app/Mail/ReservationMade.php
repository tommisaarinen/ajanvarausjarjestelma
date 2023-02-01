<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;


class ReservationMade extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $reservation;
    public $service;
    public $location;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;

        $this->customer = Customer::where('id', $reservation->customer_id)
            ->get()
            ->first();

        $this->service = Service::where('id', $reservation->service_id)
            ->get()
            ->first();

        $this->location = Location::where('id', $reservation->location_id)
            ->get()
            ->first();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Ajanvarauksesi',
            tags: ['reservation'],
            metadata: [
                'reservation_id' => $this->reservation->id,
            ],
        );
    }

    /**
    * Get the message content definition.
    *
    * @return \Illuminate\Mail\Mailables\Content
    */
    public function content()
    {
        return new Content(
            view: 'emails.reservation.made',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservation.made');
    }
}
