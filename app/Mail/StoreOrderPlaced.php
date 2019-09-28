<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoreOrderPlaced extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $order;
    private $user;

    /**
     * Create a new message instance.
     *
     * @param Orders $order
     */
    public function __construct(Authenticatable $user, Orders $order)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New order on store")->view('emails.store.order_placed', ['order' => $this->order, "user" => $this->user]);
    }
}
