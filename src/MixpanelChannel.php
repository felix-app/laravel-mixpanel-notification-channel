<?php

namespace NotificationChannels\Mixpanel;

use Illuminate\Notifications\Notification;

use Mixpanel;

class MixpanelChannel
{
    protected $mixpanel;
    
    public function __construct(Mixpanel $mixpanel)
    {
        $this->mixpanel = $mixpanel;
    }
    
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMixpanel($notifiable);
        
        if(!empty($message->identity)) {
            $this->mixpanel->identify($message->identity);
            
            if(!empty($message->person)) {
                $this->mixpanel->people->set($message->identity, $message->person);
            }            
        }

        if(!empty($message->trackEvents)) {
            foreach($message->trackEvents as $event) {
                $this->mixpanel->track($event['name'], $event['parameters']);
            }
        }
    }
}
