# Change Log

## [Unreleased]

## [3.3.4] - 2022-03-29
### Added
- Compatibility with Magento 2.4.4
- Support for Php 8.0/8.1
- pt_BR translation thanks to Vitor Martins

## [3.3.3] - 2021-07-29
### Added
- Compatibility with Magento 2.4.3

## [3.3.2] - 2021-04-30
### Added
- Compatibility with Magento 2.3.7

## [3.3.1] - 2021-02-02
### Added
- Compatibility with Magento 2.4.2

## [3.3.0] - 2020-10-07
### Added
- Compatibility with Magento 2.4.1 and 2.3.6
### Changed
- Don't keep temporary files in var folder

## [3.2.0] - 2020-07-28
### Added
- Compatibility with Magento 2.4.0
- Support for Php 7.4

## [3.1.8] - 2020-04-21
### Added
- Support for Magento 2.3.5

## [3.1.7] - 2020-01-23
### Added
- Support for Magento 2.2.11 and 2.3.4

## [3.1.6] - 2019-10-08
### Added
- Support for Magento 2.2.10

## [3.1.5] - 2019-10-03
### Added
- Support for Php 7.3
- Support for Magento 2.3.3

## [3.1.4] - 2019-06-26
### Changed
- Re-release of 3.1.3

## [3.1.3] - 2019-06-26
### Added
- Support for Magento 2.3.2, 2.2.9 and 2.1.18
- PHPStan to development tools

## [3.1.2] - 2019-05-02
### Changed
- Adopt latest Magento Coding Standards

## [3.1.1] - 2019-03-27
### Added
- Support for Magento 2.3.1, 2.2.8 and 2.1.17
- Initial MFTF acceptance test

## [3.1.0] - 2018-11-28
### Added
- Support for Magento 2.3

## [3.0.2] - 2018-11-06
### Fixed
- Adjust integration test for 2.2.5

## [3.0.1] - 2018-05-08
### Added
- Ability to translate more terms (thanks @gediminaskv)
### Fixed
- Minor code style issue

## [3.0.0] - 2018-05-08
### Changed
- Package changed into a Metapackage - Implementation moved into fooman/printorderpdf-implementation-m2 package
- Semantic versioning will only be applied to the implementation package
### Fixed
- Change setTemplate workaround, use area emulation instead
Constructor change in Plugin\PaymentInfoBlockPlugin, removes copied template files

## [2.2.2] - 2017-09-11
### Changed
- Allow for different pdf versions in test

## [2.2.1] - 2017-08-30
### Changed
- Added preprocessing of tests to run across 2.1/2.2

## [2.2.0] - 2017-08-25
### Fixed
- Empty payment details by providing frontend pdf template for known template files
### Added
- Added support for PHP 7.1

## [2.1.0] - 2017-03-01
### Added
- Support for bundled products

## [2.0.3] - 2016-06-29
### Changed
- Compatibility with Magento 2.1, for Magento 2.0 use earlier versions

## [2.0.2] - 2016-03-30
### Changed
- Test improvements

## [2.0.0] - 2015-12-09
### Changed
- Change folder structure to src/ and tests/

## [1.1.0] - 2015-11-29
### Added
- Provide a Pdf Renderer so that Fooman Email Attachments M2 (separate extension) can attach a pdf to outgoing order confirmation emails
- Translations

## [1.0.2] - 2015-11-15
### Changed
- PSR-2
- Use Magento repositories and factory
- Use Magento massaction
- Update code to stay compatible with latest Magento development branch

## [1.0.1] - 2015-09-07
### Changed
- Update code to stay compatible with latest Magento development branch

## [1.0.0] - 2015-08-02
### Added
- Initial release for Magento 2
