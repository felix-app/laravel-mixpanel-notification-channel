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

        $this->validateOrFailMessage($message);
        
        if(!empty($message->person)) {            
            $this->mixpanel->people->set($message->identity, $message->person);
        }

        if(!empty($message->alias)) {            
            $this->mixpanel->createAlias($message->identity, $message->alias);
        }
        
        if(!empty($message->properties)) {
            $this->mixpanel->people->set($message->identity, $message->properties);            
        }

        if(!empty($message->increments)) {
            foreach($message->increments as $property => $increment) {
                $this->mixpanel->people->increment($message->identity, $property, $increment);
            }
        }

        if(!empty($message->appends)) {
            foreach($message->appends as $property => $value) {
                $this->mixpanel->people->append($message->identity, $property, $value);
            }
        }        

        if(!empty($message->charges)) {
            foreach($message->charges as $charge) {
                if(is_array($charge)) {
                    $this->mixpanel->people->trackCharge($message->identity, $charge[0], $charge[1]->timestamp);
                } else {
                    $this->mixpanel->people->trackCharge($message->identity, $charge);
                }                
            }            
        }
        
        if(!empty($message->trackEvents)) {
            foreach($message->trackEvents as $event) {
                
                if(!empty($message->identity)) {            
                    $this->mixpanel->identify($message->identity);            
                }
                                
                $this->mixpanel->track($event['name'], $event['parameters']);
            }
        }
    }

    protected function validateOrFailMessage(MixpanelMessage $message)
    {
        if(empty($message->identity)) {

            if(!empty($message->person)) {
                throw new MixpanelChannelException("Integration Error: Need to call identity(:string) in order to create a profile with person(...).");
            }

            if(!empty($message->properties)) {
                throw new MixpanelChannelException("Integration Error: Need to call identity(:string) in order to change profile properties with property(string,string).");                
            }

            if(!empty($message->alias)) {
                throw new MixpanelChannelException("Integration Error: Need to call identity(:string) in order to add an alias with alias(string).");                
            }

            if(!empty($message->increments)) {
                throw new MixpanelChannelException("Integration Error: Need to call identity(:string) in order to increment a property with increment(string,mixed).");                
            }

            if(!empty($message->appends)) {
                throw new MixpanelChannelException("Integration Error: Need to call identity(:string) in order to append a property list with append(string,mixed).");                
            }

            if(!empty($message->charges)) {
                throw new MixpanelChannelException("Integration Error: Need to call identity(:string) in order to register a charge with charge(mixed,Carbon = null).");                
            }            
        }               
    }
}
