<?php

namespace NotificationChannels\Mixpanel;

use NotificationChannels\Mixpanel\Contracts\MixpanelIdentifiable;

class MixpanelMessage
{
    public $identity;
    public $trackEvents = [];
    public $person;

    public function identity($identity) {
        $this->identity = $identity;

        return $this;
    }
    
    public function track($event, array $parameters = []) {
        $this->trackEvents []= [
            'name' => $event,
            'parameters' => $parameters
        ];

        return $this;
    }

    public function person($firstName, $lastName = null, $email = null, $phone = null, $arguments = null)
    {
        $person = [
            '$first_name' => $firstName
        ];

        if(!empty($lastName)) {
            $person['$last_name'] = $lastName;
        }

        if(!empty($email)) {
            $person['$email'] = $email;
        }

        if(!empty($phone)) {
            $person['$phone'] = $phone;
        }

        if(!empty($arguments)) {
            $person = array_merge($person, $arguments);
        }

        $this->person = $person;

        return $this;
    }
}
