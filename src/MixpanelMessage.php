<?php

namespace NotificationChannels\Mixpanel;

use NotificationChannels\Mixpanel\Contracts\MixpanelIdentifiable;

use Carbon\Carbon;

class MixpanelMessage
{
    public $identity;
    public $trackEvents = [];
    public $person;
    public $properties = [];
    public $alias;
    public $increments = [];
    public $appends = [];
    public $charges = [];

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

    public function alias($identity)
    {
        $this->alias = $identity;        
        return $this;
    }

    public function increment($property, $count = 1)
    {
        if(empty($this->increments[$property])) {
            $this->increments[$property] = 0;
        }
        
        $this->increments[$property] += (int)$count;

        return $this;
    }

    public function append($property, $value)
    {
        if(empty($this->appends[$property])) {
            $this->appends[$property] = [];
        }

        $this->appends[$property][] = $value;

        return $this;
    }

    public function charge($amount, Carbon $date = null)
    {
        if(empty($data)) {
            $this->charges []= $amount; 
        } else {
            $this->charges []= [ $amount, $date ];
        }        

        return $this;
    }

    public function property($property, $value)
    {
        $this->properties[$property] = $value;

        return $this;
    }
}
