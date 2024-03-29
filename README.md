# DebugOut
DebugOut for PHP, for tracing code execution the old-fashioned way: with printlines.

## History
I initially created this pair of classes, DebugOut and DynamicDebug, in the mid-nineties for C++. It was later ported to Ada 95 and now PHP; I did _not_ port it to Java because the DebugOut class relies on its destructor being called immediately upon its instantiations go out of scope and that doesn't happen with Java's garbage collection. (The C++ and Ada versions were both thread-aware; as I've not had occasion to use threads in PHP, this version does not include that capability.)

## Purpose
What they do is allow you to instrument code so that you can trace the execution path to the level of detail you would like by configuring what paths you're interested in for any given run through. DebugOut handles the outputting and DynamicDebug controls which scopes are traced based on a configuration file which is read in at the beginning of every, e.g., page load.

## Installation

Use [Composer] to install the package:

```bash
composer require nklatt/debugout
```

## Usage

There are two steps to using this package.

First, you need to instrument your code with DebugOut instantiations in the functions/methods you wish to trace/debug. At the top of such functions, add `$debugOut = new DebugOut(__FUNCTION__, '<flag>');` then, in the body, add calls to `$debugOut->putLine` passing it a string to be output.

Second, you need to enable logging for the flags you wish to see for any given run. This is done by calling `DynamicDebug::setEnabledFlags(array(<list of flags to enable>));`.

See tests/DebugOutTest.php for sample code.

## Sample Output

### Default
```
--> outputPage
    --> outputHeader
        --> outputNav(header)
            Adding to nav: Home
            Adding to nav: About
            Excluding from nav: History
            Excluding from nav: Executives
            Excluding from nav: Careers
            Adding to nav: Contact
            Adding to nav: Help
        <-- outputNav(header)
    <-- outputHeader
    --> outputBody
        --> outputSidebar
            --> outputNav(sidebar)
                Excluding from nav: Home
                Adding to nav: About
                Adding to nav: History
                Adding to nav: Executives
                Adding to nav: Careers
                Excluding from nav: Contact
                Adding to nav: Help
            <-- outputNav(sidebar)
        <-- outputSidebar
    <-- outputBody
    --> outputFooter
    <-- outputFooter
<-- outputPage
```

### Piped
```
--> outputPage
 |  --> outputHeader
 |   |  --> outputNav(header)
 |   |   |  Adding to nav: Home
 |   |   |  Adding to nav: About
 |   |   |  Excluding from nav: History
 |   |   |  Excluding from nav: Executives
 |   |   |  Excluding from nav: Careers
 |   |   |  Adding to nav: Contact
 |   |   |  Adding to nav: Help
 |   |  <-- outputNav(header)
 |  <-- outputHeader
 |  --> outputBody
 |   |  --> outputSidebar
 |   |   |  --> outputNav(sidebar)
 |   |   |   |  Excluding from nav: Home
 |   |   |   |  Adding to nav: About
 |   |   |   |  Adding to nav: History
 |   |   |   |  Adding to nav: Executives
 |   |   |   |  Adding to nav: Careers
 |   |   |   |  Excluding from nav: Contact
 |   |   |   |  Adding to nav: Help
 |   |   |  <-- outputNav(sidebar)
 |   |  <-- outputSidebar
 |  <-- outputBody
 |  --> outputFooter
 |  <-- outputFooter
<-- outputPage
```

### Brief
```
->outputPage
  ->outputHeader
    ->outputNav(header)
      Adding to nav: Home
      Adding to nav: About
      Excluding from nav: History
      Excluding from nav: Executives
      Excluding from nav: Careers
      Adding to nav: Contact
      Adding to nav: Help
    <-outputNav(header)
  <-outputHeader
  ->outputBody
    ->outputSidebar
      ->outputNav(sidebar)
        Excluding from nav: Home
        Adding to nav: About
        Adding to nav: History
        Adding to nav: Executives
        Adding to nav: Careers
        Excluding from nav: Contact
        Adding to nav: Help
      <-outputNav(sidebar)
    <-outputSidebar
  <-outputBody
  ->outputFooter
  <-outputFooter
<-outputPage
```

## Standards Followed
This project follows [PSRs](http://www.php-fig.org/psr/) 1, 2, and 4. It is also set up to be used with Composer via Packagist. It has some basic automated testing utilizing PHPUnit.

## Shortcomings / Future Plans
This does not follow [PSR-3](http://www.php-fig.org/psr/psr-3/), though I expect it should, or at least could. It's also possible it could be a [Monolog extension](https://github.com/Seldaek/monolog/blob/master/doc/04-extending.md).

Perhaps most egregiously, it currently logs output using error_log calls and that seems just wrong. Not sure what the best solution to this is - perhaps refactoring to be a Monolog extension would take care of that, too.
