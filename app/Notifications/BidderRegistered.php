<?php

namespace App\Notifications;

use App\TuChance\Models\Bidder;

class BidderRegistered extends BaseNotification
{
    /**
     * The folder the messages for this notifications are stored
     * @var string
     */
    protected $translations = 'bidder/created';

    /**
     * Bidder created
     * @var \App\TuChance\Models\Bidder
     */
    protected $bidder;

    /**
     * Create a new event instance.
     * @param  \App\TuChance\Models\Bidder $bidder
     * @return void
     */
    public function __construct(Bidder $bidder)
    {
        $this->bidder = $bidder;
    }

    /**
     * Append bidder data to mail message
     * @param  \Illuminate\Notifications\Messages\MailMessage $message
     * @param  mixed                                          $notifiable
     * @return void
     */
    public function toMailData($message, $notifiable)
    {
        $message->line("Nombre: {$this->bidder->name}");
        $message->line("Nombre contacto: {$this->bidder->user->name}");
        $message->line("Correo electrónico: {$this->bidder->user->email}");
    }

    /**
     * Url for action button
     * @param  mixed $notifiable
     * @return string
     */
    public function url($notifiable)
    {
        return url("admin/oferentes/edita/{$this->bidder->id}");
    }
}
