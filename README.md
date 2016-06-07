# DebugOut
DebugOut for PHP, for tracing code execution the old-fashioned way: with printlines.

## History
I initially created this pair of classes, DebugOut and DynamicDebug, in the mid-nineties for C++. It was later ported to Ada 95 and now PHP. (The C++ and Ada versions were both thread-aware; as I've not had occasion to use threads in PHP, this version does not include that capability.)

## Purpose
What they do is allow you to instrument code so that you can trace the execution path to the level of detail you would like by configuring what paths you're interested in for any given run through. DebugOut handles the outputting and DynamicDebug controls which scopes are traced based on a configuration file which is read in at the beginning of every, e.g., page load.

## Standards Followed
This project follows [PSRs](http://www.php-fig.org/psr/) 1, 2, and 4.

## Shortcomings / Future Plans
This does not follow [PSR-3](http://www.php-fig.org/psr/psr-3/), though I expect it should, or at least could. It's also possible it could be a [Monolog extension](https://github.com/Seldaek/monolog/blob/master/doc/04-extending.md).
