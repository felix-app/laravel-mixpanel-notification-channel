# Mixpanel Notification Channel for Laravel

> Use Laravel 5.3 notifications to send events to Mixpanel.

## Contents
- [Installation](#installation)
    - [Setting up Mixpanel](#setting-up-mandrill)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation
Install this package with Composer:
``` bash
composer require felix-app/laravel-mixpanel-notification-channel
```

Register the service provider in your `config/app.php`:
``` php
NotificationChannels\Mixpanel\MixpanelServiceProvider::class
```

### Setting up Mixpanel
Add your API key to your configuration at `config/services.php`:
``` php 
    'mixpanel' => [
        'secret' => env('MIXPANEL_API_KEY', '')
    ],
```

## Usage
Send events to Mixpanel in your notification:

``` php
use NotificationChannels\Mixpanel\MixpanelChannel;
use NotificationChannels\Mixpanel\MixpanelMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    protected $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function via($notifiable)
    {
        return [MixpanelChannel::class];
    }

    public function toMixpanel($notifiable)
    {
        $ids = [];
        $totalAmount = 0;
        foreach($this->products as $product)
        {
            $ids []= $product->id;
            $totalAmount += $product->amount;
        }

        return (new MixpanelMessage())
               ->identity($notifiable->identity)
               ->increment('Checkout Count', count($this->products))
               ->charge($totalAmount)
               ->track("Product Checkout", [
                   'products' => $ids
               ]);
    }
}
```

### Available Message methods
- `identity(string $name)`: Sets the identity used in this Mixpanel API session. When tracking events identity is not required.
- `track(string $event, array $parameters`: Set track event data and corresponding parameters to send to Mixpanel
- `person(string $firstName, string $lastName = null, string $email = null, string $phone = null, array $arguments = null)`: Sets a person profile to be store in Mixpanel, with an optional hash of user property data. This profile data will be matched to the identity previously set.
- `alias(string $identity)`: Set an alias to the identity previously set.
- `increment(string $property, int $count)`: Set an increment some user profile property.
- `append(string $property, string $value)`: Set an append to some user profile property collection.
- `charge(mixed $amount, Carbon $date = null)`: Sets a charged amount to some user profile.

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information for what has changed recently.

## Testing
TODO:

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.# laravel-mixpanel-notification-channel
Mixpanel notification channel for Laravel 5.3+
