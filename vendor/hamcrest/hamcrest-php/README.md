This is the PHP port of Hamcrest Matchers
=========================================

[![Build Status](https://travis-ci.org/hamcrest/hamcrest-php.png?branch=master)](https://travis-ci.org/hamcrest/hamcrest-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hamcrest/hamcrest-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hamcrest/hamcrest-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/hamcrest/hamcrest-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/hamcrest/hamcrest-php/?branch=master)

Hamcrest is a matching library originally written for Java, but
subsequently ported to many other languages.  hamcrest-php is the
official PHP port of Hamcrest and essentially follows a literal
translation of the original Java API for Hamcrest, with a few
Exceptions, mostly down to PHP language barriers:

  1. `instanceOf($theClass)` is actually `anInstanceOf($theClass)`

  2. `both(containsString('a'))->and(containsString('b'))`
     is actually `both(containsString('a'))->andAlso(containsString('b'))`

  3. `either(containsString('a'))->or(containsString('b'))`
     is actually `either(containsString('a'))->orElse(containsString('b'))`

  4. Unless it would be non-semantic for a matcher to do so, hamcrest-php
     allows dynamic typing for it's input, in "the PHP way". Exception are
     where semantics surrounding the type itself would suggest otherwise,
     such as stringContains() and greaterThan().

  5. Several official matchers have not been ported because they don't
     make sense or don't apply in PHP:

       - `typeCompatibleWith($theClass)`
       - `eventFrom($source)`
       - `hasProperty($name)` **
       - `samePropertyValuesAs($obj)` **

  6. When most of the collections matchers are finally ported, PHP-specific
     aliases will probably be created due to a difference in naming
     conventions between Java's Arrays, Collections, Sets and Maps compared
     with PHP's Arrays.

---
** [Unless we consider POPO's (Plain Old PHP Objects) akin to JavaBeans]
     - The POPO thing is a joke.  Java devs coin the term POJO's (Plain Old
       Java Objects).


Usage
-----

Hamcrest matchers are easy to use as:

```php
Hamcrest_MatcherAssert::assertThat('a', Hamcrest_Matchers::equalToIgnoringCase('A'));
```
