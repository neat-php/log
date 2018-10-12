Neat Log components
===================
[![Stable Version](https://poser.pugx.org/neat/log/version)](https://packagist.org/packages/neat/log)
[![Build Status](https://travis-ci.org/neat-php/log.svg?branch=master)](https://travis-ci.org/neat-php/log)

Neat log components provide a clean and expressive API to build a
[PSR-3](https://www.php-fig.org/psr/psr-3/) compliant logger to suit your
needs.

Getting started
---------------
To install this package, simply issue [composer](https://getcomposer.org) on the
command line:
```
composer require neat/log
```

Logging
-------
Creating a logger is as simple as creating an instance and invoking any of the
log methods on it:
```php
<?php

$log = new Neat\Log\File('logs/app.log');

// Use a predefined log level
$log->debug('Just saying hi');
$log->info('Business as usual');
$log->notice('Now you might want to read this');
$log->warning('Getting a little uncomfortable here');
$log->error('Something has gone wrong');
$log->critical('Seriously!');
$log->alert('Get the defibrillators!');
$log->emergency('System passed away');

// Or any custom level
$log->log('meltdown', 'Clear the region ASAP!');
```

Syslog
------
To send messages to the syslog, just create a Syslog instance.
```php
// The first parameter is an identifier that gets prepended to each message.
$log = new Neat\Log\Syslog('AppIdentifier');

// Any of the default log levels are used to determine the syslog message priority
$log->info(...); // logs a syslog entry with LOG_INFO priority
```

Context
-------
To provide context with your log messages, pass any data describing the context
as an associative array to the log after your message:
```php
// Works with all predefined log level methods
$log->info('Record deleted', ['by' => 'John']);

// The custom log method supports context too
$log->log('query', 'SELECT * FROM posts', ['duration' => '0.0001s']);
```

Filters
-------
To manage log verbosity and omit unwanted messages you can stack the Filter
logger on top of your existing logger:
```php
// Create a destination log first
$log = new File(...);

// Then attach the Filter to log warnings and more severe entries only
$log = new Filter($log, new Filter\Serverity('warning'));

// If you want to log messages matching a pattern, there's filter for that too:
$log = new Filter($log, new Filter\Pattern('/mail/'));

// Filters are just callables that return a boolean. Roll your own if you like:
$log = new Filter($log, function(Record $record): bool {
    return strtoupper($record->message()) != $record->message(); // prevents ALL CAPS logs
});

// The filter logger even accepts multiple filters at once
$log = new Filter($log, new Filter\Severity('warning'), new Filter\Pattern('/keyword/'));
```

Stamps
------
When logging to a file, you may want to include essential information such a the
time or level of the log entry on each line. The Stamp logger does just that:
```php
// Create a log file first
$log = new File(...);

// Then stack the Stamp logger on top with a stamp implementation
$log = new Stamp($log, new Stamp\Time);

// The Time stamp allows for setting a custom format and timezone
$log = new Stamp($log, new Stamp\Time('Y-m-d H:i:s.uO', 'europe/amsterdam'));

// Stamps are just callables returning a string that will precede each message:
$log = new Stamp($log, function (Record $record) {
    return strlen($record->message()) . ' bytes';
});

// Just like the Filter logger, you can use multiple stamps
$log = new Stamp($log, new Stamp\Time, new Stamp\Level);
```

The resulting log file will look like this:
```
[2018-09-23T14:34:20+0200] [debug] Just saying hi
[2018-09-23T14:53:08+0200] [error] Something has gone wrong
```

Formats
-------
Greater transformations to the log message can be made using the Format logger.
This logger allows you to completely modify and rewrite the log message:
```php
// Like the other addon loggers, you'll need a log destination first
$log = new File(...);

// Then you add placeholder substition using the placeholder format
$log = new Format($log, Format\Placeholder);
$log->info('User {user} wrote a new post titled "{title}"', ['user' => 'John', 'my post title']);

// Or have your messages truncated above a specified message length
$log = new Format($log, Format\Truncate(80));

// Or have all context appended to each log entry
$log = new Format($log, Format\Context);
```

Putting it all together
-----------------------
When you combine these loggers you can create really neat log assemblies like this:
```php
$log = new File('logs/app.log');
$log = new Filter($log, new Filter\Severity('warning'));
$log = new Stamp($log, new Stamp\Time, new Stamp\Level);
$log = new Format($log, new Format\Truncate(80));
$log->info(...);
```

Resilience
----------
Neat Log components are happy to handle any type of log entry you throw at
them. This means you can use custom log levels, objects instead of strings
and even arrays without risking endless loops between your log and error
handler. It. Just. Works.
