# Changes in PHP_CodeCoverage 5.0

All notable changes of the PHP_CodeCoverage 5.0 release series are documented in this file using the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [5.0.4] - 2017-04-02

### Added

* Added `SebastianBergmann\CodeCoverage\Version::id()` method

### Fixed

* Fixed [#515](https://github.com/sebastianbergmann/php-code-coverage/pull/515): Wrong use of recursive iterator causing duplicate entries in XML coverage report

## [5.0.3] - 2017-03-06

### Fixed

* Fixed [#451](https://github.com/sebastianbergmann/php-code-coverage/pull/451): Conflict between HTML report assets and directories named `css`, `fonts`, or `js`
* Fixed [#485](https://github.com/sebastianbergmann/php-code-coverage/issues/485): Large popover contents cannot be viewed

## [5.0.2] - 2017-03-01

### Changed

* Cleaned up requirements in `composer.json`

## [5.0.1] - 2017-02-23

### Added

* Implemented [#508](https://github.com/sebastianbergmann/php-code-coverage/pull/508): Support for HackLang's `ENUM` declaration

## [5.0.0] - 2017-02-03

### Removed

* This component is no longer supported on PHP 5

[5.0.4]: https://github.com/sebastianbergmann/php-code-coverage/compare/5.0.3...5.0.4
[5.0.3]: https://github.com/sebastianbergmann/php-code-coverage/compare/5.0.2...5.0.3
[5.0.2]: https://github.com/sebastianbergmann/php-code-coverage/compare/5.0.1...5.0.2
[5.0.1]: https://github.com/sebastianbergmann/php-code-coverage/compare/5.0.0...5.0.1
[5.0.0]: https://github.com/sebastianbergmann/php-code-coverage/compare/4.0...5.0.0

