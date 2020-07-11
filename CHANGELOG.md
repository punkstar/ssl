# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Added `trusted()` and `signedBy()` methods to `Certificate` to allow for the validation of certificate chains.

### Changed
- BREAKING: Constructor signature for `Certificate` changed.
- PHP 7.4 is now the minimum required verison due to needing [openssl_x509_verify](https://php.net/openssl_x509_verify).


## [0.5.1] - 2017-10-17
### Fixed
- Allow validating common names for domains with ports.

## [0.5.0] - 2017-10-17
### Added
- Add common name validation.

## [0.4.0] - 2017-07-24
### Added
- Allow for non standard https ports when using `Reader::readFromUrl`.

## [0.3.2] - 2017-03-18
### Added
- Allow for specifying a connection timeout.

## [0.3.1] - 2016-09-16
### Changed
- Use a specific error code for connection refused exception.

## [0.3.0] - 2016-09-16
### Added
- Report connection problems with exceptions.

## [0.2.0] - 2016-09-13
### Added
- Don't verify the SSL certificate when fetching, allowing for reading invalid certificates.

## [0.1.0] - 2016-09-13
### Added
- Initial release.
- Allow for reading SSL certificates from a file or URL.

[Unreleased]: https://github.com/punkstar/ssl/compare/0.5.1...HEAD
[0.5.1]: https://github.com/punkstar/ssl/compare/0.5.0...0.5.1
[0.5.0]: https://github.com/punkstar/ssl/compare/0.4.0...0.5.0
[0.4.0]: https://github.com/punkstar/ssl/compare/0.3.2...0.4.0
[0.3.2]: https://github.com/punkstar/ssl/compare/0.3.1...0.3.2
[0.3.1]: https://github.com/punkstar/ssl/compare/0.3.0...0.3.1
[0.3.0]: https://github.com/punkstar/ssl/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/punkstar/ssl/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/punkstar/ssl/tree/0.1.0
