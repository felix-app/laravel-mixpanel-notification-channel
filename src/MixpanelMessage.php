<?php

namespace NotificationChannels\Mixpanel;

use Carbon\Carbon;

class MixpanelMessage
{
    /**
     * Person identity used to track events
     *
     * @var mixed $identity
     * @access public
     */
    public $identity;
    
    /**
     * Events to track 
     *
     * @var mixed $trackEvents
     * @access public
     */
    public $trackEvents = [];
    
    /**
     * User profile data to store
     *
     * @var mixed $person
     * @access public
     */
    public $person;
    
    /**
     * User profile property to add or modify
     *
     * @var mixed $properties
     * @access public
     */
    public $properties = [];
    
    /**
     * User profile identity alias to set to this and all future Notifications
     *
     * @var mixed $alias
     * @access public
     */
    public $alias;
    
    /**
     * User profile property increment
     *
     * @var mixed $increments
     * @access public
     */
    public $increments = [];
    
    /**
     * User profile property append
     *
     * @var mixed $appends
     * @access public
     */
    public $appends = [];
    
    /**
     * User profile charge amount
     *
     * @var mixed $charges
     * @access public
     */
    public $charges = [];
    
    /**
     * Sets the profile identity to track notification events
     *
     * @param mixed $identity
     * @access public
     * @return MixpanelMessage
     */
    public function identity($identity) {
        $this->identity = $identity;

        return $this;
    }
    
    /**
     * Sets an event to store
     *
     * @param mixed $event
     * @param array $parameters
     * @access public
     * @return MixpanelMessage
     */
    public function track($event, array $parameters = []) {
        $this->trackEvents []= [
            'name' => $event,
            'parameters' => $parameters
        ];

        return $this;
    }

    /**
     * Sets a person person profile to store
     *
     * @param mixed $firstName
     * @param mixed $lastName
     * @param mixed $email
     * @param mixed $phone
     * @param mixed $arguments
     * @access public
     * @return MixpanelMessage
     */
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

    /**
     * Sets an identity alias
     *
     * @param mixed $identity
     * @access public
     * @return MixpanelMessage
     */
    public function alias($identity)
    {
        $this->alias = $identity;        
        return $this;
    }

    /**
     * Sets a property increment
     *
     * @param mixed $property
     * @param int $count
     * @access public
     * @return MixpanelMessage
     */
    public function increment($property, $count = 1)
    {
        if(empty($this->increments[$property])) {
            $this->increments[$property] = 0;
        }
        
        $this->increments[$property] += (int)$count;

        return $this;
    }

    /**
     * Appends a value in a property collection
     *
     * @param mixed $property
     * @param mixed $value
     * @access public
     * @return MixpanelMessage
     */
    public function append($property, $value)
    {
        if(empty($this->appends[$property])) {
            $this->appends[$property] = [];
        }

        $this->appends[$property][] = $value;

        return $this;
    }

    /**
     * Sets a charge amount to some profile
     *
     * @param mixed $amount
     * @param Carbon $date
     * @access public
     * @return MixpanelMessage
     */
    public function charge($amount, Carbon $date = null)
    {
        if(empty($data)) {
            $this->charges []= $amount; 
        } else {
            $this->charges []= [ $amount, $date ];
        }        

        return $this;
    }

    /**
     * Sets a property value
     *
     * @param mixed $property
     * @param mixed $value
     * @access public
     * @return MixpanelMessage
     */
    public function property($property, $value)
    {
        $this->properties[$property] = $value;

        return $this;
    }
}
