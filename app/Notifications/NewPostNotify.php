<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotify extends Notification
{
    use Queueable;
   
    public $post;
    public function __construct($post)
    {
       $this->post = $post;
    }
 
    public function via($notifiable)
    {
        return ['mail'];
    }
   
   public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('new message')
        ->line('You have a new message from Argishti '. $this->post->user->name)
        ->line('Message: '.$this->post->message) ;
     
    }
   
    public function toArray($notifiable)
    {
        return [
            
        ];
    }
}
