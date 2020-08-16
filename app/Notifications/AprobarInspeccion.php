<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AprobarInspeccion extends Notification
{
    use Queueable;

    public $inspeccion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inspeccion)
    {
      $this->inspeccion = $inspeccion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
              ->subject('Evaluar inspeccicón')
              ->greeting('Saludos '.$this->inspeccion->proceso->cliente->nombre(). '!')
              ->line('Estas recibiendo este email porque se ha generado una inspección al vehículo: '.$this->inspeccion->proceso->vehiculo->vehiculo().' y es necesario que evalues la inspección.')
              ->action('Ver inspección', route('proceso.show', ['proceso' => $this->inspeccion->proceso->id]))
              ->line('Puedes comunicarte con nosotros ante cualquier duda.')
              ->salutation(config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
