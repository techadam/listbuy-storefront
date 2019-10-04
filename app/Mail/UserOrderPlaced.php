<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Auth\Authenticatable;

class UserOrderPlaced extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $order;

    /**
     * Create a new message instance.
     *
     * @param Orders $order
     */
    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your order {$this->order->generated_id} has been placed")->view('emails.user.order_placed', ['order' => $this->order]);
    }

}
