# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 0.1.0-alpha - unreleased

This is an alpha version! The changes listed here are not final.

### Security
- Security: Fix XSS vulnerability.

### Added
- Added an initial version of Jetpack Inspect to the Jetpack Monorepo.
- Update baseline

### Changed
- General: indicate compatibility with the upcoming version of WordPress, 6.5.
- General: indicate compatibility with the upcoming version of WordPress - 6.6.
- General: indicate full compatibility with the latest version of WordPress, 6.4.
- General: updated PHP requirement to PHP 7.0+
- General: update WordPress version requirements to WordPress 6.2.
- General: update WordPress version requirements to WordPress 6.3.
- General: update WordPress version requirements to WordPress 6.4.
- Updated package dependencies.

### Removed
- Connection: Removed deprecated method features_available
- Connection: Removed features_enabled deprecated method
- General: update WordPress version requirements to WordPress 6.5.
- Remove obsolete `skip-test-php` composer script. No change to the plugin itself.

### Fixed
- Remove unnecessary boolean check that was confusing Phan.
