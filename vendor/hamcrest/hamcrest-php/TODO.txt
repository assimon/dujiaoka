Still TODO Before Complete for PHP
----------------------------------

Port:

  - Hamcrest_Collection_*
    - IsCollectionWithSize
    - IsEmptyCollection
    - IsIn
    - IsTraversableContainingInAnyOrder
    - IsTraversableContainingInOrder
    - IsMapContaining (aliases)

Aliasing/Deprecation (questionable):

  - Find and fix any factory methods that start with "is".

Namespaces:

  - Investigate adding PHP 5.3+ namespace support in a way that still permits
    use in PHP 5.2.
  - Other than a parallel codebase, I don't see how this could be possible.
