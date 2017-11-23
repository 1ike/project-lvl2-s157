#!/usr/bin/env php
<?php

/*
|--------------------------------------------------------------------------
| Register Autoloader
|--------------------------------------------------------------------------
|
| Require in the Composer autoloading script so that all the required
| classes for the Resource Watcher are loaded in.
|
*/

require __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Resource Watcher Dependencies
|--------------------------------------------------------------------------
|
| Create a new instance of Illuminate's Filesystem class and of the
| Resource Watcher's Tracker class. These are dependencies of the Resource
| Watcher and will be injected into the constructor.
|
*/

$files = new Illuminate\Filesystem\Filesystem();

$tracker = new JasonLewis\ResourceWatcher\Tracker();

/*
|--------------------------------------------------------------------------
| Instantiate Resource Watcher
|--------------------------------------------------------------------------
|
| Create a new instance of the Resource Watcher so we can watch resources
| for any changes.
|
*/

$watcher = new JasonLewis\ResourceWatcher\Watcher($tracker, $files);

/*
|--------------------------------------------------------------------------
| Watch For Changes
|--------------------------------------------------------------------------
|
| Watch for changes to a resource. The resource given does not need to
| exist to begin watching.
|
*/

$listener = $watcher->watch('src');

/*
|--------------------------------------------------------------------------
| Create Listener
|--------------------------------------------------------------------------
|
| Listen for any create events that are fired.
|
*/

$listener->onCreate(function ($resource, $path) {
    echo "{$path} was created.".PHP_EOL;
});

/*
|--------------------------------------------------------------------------
| Delete Listener
|--------------------------------------------------------------------------
|
| Listen for any delete events that are fired.
|
*/

$listener->onDelete(function ($resource, $path) {
    echo "{$path} was deleted.".PHP_EOL;
});

/*
|--------------------------------------------------------------------------
| Anything Listener
|--------------------------------------------------------------------------
|
| Listen for anything.
|
*/

$listener->onAnything(function ($event, $resource, $path) {
    switch ($event->getCode()) {
        case JasonLewis\ResourceWatcher\Event::RESOURCE_DELETED:
            echo "{$path} was deleted (from anything listener).".PHP_EOL;
            break;
        case JasonLewis\ResourceWatcher\Event::RESOURCE_MODIFIED:
            echo "{$path} was modified (from anything listener).".PHP_EOL;
            break;
        case JasonLewis\ResourceWatcher\Event::RESOURCE_CREATED:
            echo "{$path} was created (from anything listener).".PHP_EOL;
            break;
    }
});

/*
|--------------------------------------------------------------------------
| Modify Listener
|--------------------------------------------------------------------------
|
| Listen for any modify events that are fired.
|
*/

$listener->onModify(function ($resource, $path) {
    // echo "{$path} was modified.".PHP_EOL;
    echo PHP_EOL.PHP_EOL;
    // system("php bin/gendiff tests/fixtures/before.json tests/fixtures/after.json");
    // system("php bin/gendiff tests/fixtures/before.yml tests/fixtures/after.yml");
    // system("php bin/gendiff -f plain tests/fixtures/before.json tests/fixtures/after.json");
    system("php bin/gendiff -f json tests/fixtures/before.json tests/fixtures/after.json");
    echo PHP_EOL.PHP_EOL;
});

/*
|--------------------------------------------------------------------------
| Start Watching
|--------------------------------------------------------------------------
|
| Now that all the listeners are bound we can start watching. By default
| the watcher will poll for changes every second. You can adjust this by
| passing in an optional first parameter. The interval is given in
| microseconds. 1,000,000 microseconds is 1 second.
|
| By default the watch will continue until such time that it's aborted from
| the terminal. To set a timeout pass in the number of microseconds before
| the watch will abort as the second parameter.
|
*/

$watcher->start();
