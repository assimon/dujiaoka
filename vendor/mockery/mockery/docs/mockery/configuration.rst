.. index::
    single: Mockery; Configuration

Mockery Global Configuration
============================

To allow for a degree of fine-tuning, Mockery utilises a singleton
configuration object to store a small subset of core behaviours. The two
currently present include:

* Option to allow/disallow the mocking of methods which do not actually exist
  fulfilled (i.e. unused)
* Setter/Getter for added a parameter map for internal PHP class methods
  (``Reflection`` cannot detect these automatically)

By default, the first behaviour is enabled. Of course, there are
situations where this can lead to unintended consequences. The mocking of
non-existent methods may allow mocks based on real classes/objects to fall out
of sync with the actual implementations, especially when some degree of
integration testing (testing of object wiring) is not being performed.

You may allow or disallow this behaviour (whether for whole test suites or
just select tests) by using the following call:

.. code-block:: php

    \Mockery::getConfiguration()->allowMockingNonExistentMethods(bool);

Passing a true allows the behaviour, false disallows it. It takes effect
immediately until switched back. If the behaviour is detected when not allowed,
it will result in an Exception being thrown at that point. Note that disallowing
this behaviour should be carefully considered since it necessarily removes at
least some of Mockery's flexibility.

The other two methods are:

.. code-block:: php

    \Mockery::getConfiguration()->setInternalClassMethodParamMap($class, $method, array $paramMap)
    \Mockery::getConfiguration()->getInternalClassMethodParamMap($class, $method)

These are used to define parameters (i.e. the signature string of each) for the
methods of internal PHP classes (e.g. SPL, or PECL extension classes like
ext/mongo's MongoCollection. Reflection cannot analyse the parameters of internal
classes. Most of the time, you never need to do this. It's mainly needed where an
internal class method uses pass-by-reference for a parameter - you MUST in such
cases ensure the parameter signature includes the ``&`` symbol correctly as Mockery
won't correctly add it automatically for internal classes.

Disabling reflection caching
----------------------------

Mockery heavily uses `"reflection" <https://secure.php.net/manual/en/book.reflection.php>`_
to do it's job. To speed up things, Mockery caches internally the information it
gathers via reflection. In some cases, this caching can cause problems.

The **only** known situation when this occurs is when PHPUnit's ``--static-backup`` option
is used. If you use ``--static-backup`` and you get an error that looks like the
following:

.. code-block:: php

    Error: Internal error: Failed to retrieve the reflection object

We suggest turning off the reflection cache as so:

.. code-block:: php

    \Mockery::getConfiguration()->disableReflectionCache();

Turning it back on can be done like so:

.. code-block:: php

    \Mockery::getConfiguration()->enableReflectionCache();

In no other situation should you be required turn this reflection cache off.
