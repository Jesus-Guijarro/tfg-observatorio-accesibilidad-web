<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('OSAW.TFG@gmail.com','Observatorio para el Seguimiento de la Accesibilidad Web')
            ->subject('Restablecimiento de contraseña')
            ->greeting('Hola')
            ->line('Has recibido este correo debido a que hemos recibido una petición para restablecer tu contraseña de usuario.')
            ->action('Restablece tu contraseña', url('password/reset', $this->token))
            ->line('Si no has pedido restablecer la contraseña de usuario, no es necesario realizar ninguna acción.')
            ->salutation('Un saludo, OSAW');
    
    }
}