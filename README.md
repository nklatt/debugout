# DebugOut
DebugOut for PHP, for tracing code execution the old-fashioned way: with printlines.

## History
I initially created this pair of classes, DebugOut and DynamicDebug, in the mid-nineties for C++. It was later ported to Ada 95 and now PHP. (The C++ and Ada versions were both thread-aware; as I've not had occasion to use threads in PHP, this version does not include that capability.)

## Purpose
What they do is allow you to instrument code so that you can trace the execution path to the level of detail you would like by configuring what paths you're interested in for any given run through. DebugOut handles the outputting and DynamicDebug controls which scopes are traced based on a configuration file which is read in at the beginning of every, e.g., page load.

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
This project follows [PSRs](http://www.php-fig.org/psr/) 1, 2, and 4. It is also set up to be used with Composer via Packagist.

## Shortcomings / Future Plans
This does not follow [PSR-3](http://www.php-fig.org/psr/psr-3/), though I expect it should, or at least could. It's also possible it could be a [Monolog extension](https://github.com/Seldaek/monolog/blob/master/doc/04-extending.md).

Perhaps most egregiously, it currently logs output using error_log calls and that seems just wrong. Not sure what the best solution to this is - perhaps refactoring to be a Monolog extension would take care of that, too.
