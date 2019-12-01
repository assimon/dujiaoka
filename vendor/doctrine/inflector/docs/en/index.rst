Introduction
============

The Doctrine Inflector has static methods for inflecting text.
The features include pluralization, singularization,
converting between camelCase and under_score and capitalizing
words.

All you need to use the Inflector is the ``Doctrine\Common\Inflector\Inflector``
class.

Installation
============

You can install the Inflector with composer:

.. code-block::

    $ composer require doctrine/inflector

Here are the available methods that you can use:

Tableize
========

Converts ``ModelName`` to ``model_name``:

.. code-block:: php

    echo Inflector::tableize('ModelName'); // model_name

Classify
========

Converts ``model_name`` to ``ModelName``:

.. code-block:: php

    echo Inflector::classify('model_name'); // ModelName

Camelize
========

This method uses `Classify`_ and then converts the first character to lowercase:

.. code-block:: php

    echo Inflector::camelize('model_name'); // modelName

ucwords
=======

Takes a string and capitalizes all of the words, like PHP's built-in
ucwords function. This extends that behavior, however, by allowing the
word delimiters to be configured, rather than only separating on
whitespace.

Here is an example:

.. code-block:: php

    $string = 'top-o-the-morning to all_of_you!';

    echo Inflector::ucwords($string); // Top-O-The-Morning To All_of_you!

    echo Inflector::ucwords($string, '-_ '); // Top-O-The-Morning To All_Of_You!

Pluralize
=========

Returns a word in plural form.

.. code-block:: php

    echo Inflector::pluralize('browser'); // browsers

Singularize
===========

.. code-block:: php

    echo Inflector::singularize('browsers'); // browser

Rules
=====

Customize the rules for pluralization and singularization:

.. code-block:: php

    Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
    Inflector::rules('plural', [
        'rules' => ['/^(inflect)ors$/i' => '\1ables'],
        'uninflected' => ['dontinflectme'],
        'irregular' => ['red' => 'redlings']
    ]);

The arguments for the ``rules`` method are:

- ``$type`` - The type of inflection, either ``plural`` or ``singular``
- ``$rules`` - An array of rules to be added.
- ``$reset`` - If true, will unset default inflections for all new rules that are being defined in $rules.

Reset
=====

Clears Inflectors inflected value caches, and resets the inflection
rules to the initial values.

.. code-block:: php

    Inflector::reset();

Slugify
=======

You can easily use the Inflector to create a slug from a string of text
by using the `tableize`_ method and replacing underscores with hyphens:

.. code-block:: php

    public static function slugify(string $text) : string
    {
        return str_replace('_', '-', Inflector::tableize($text));
    }
