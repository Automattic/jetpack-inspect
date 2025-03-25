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
- Adds Account Protection initialization
- Connection: Disconnecting a connection owner account will disconnect all other users first.
- Enable test coverage.
- jetpack-components: Export the getRedirectUrl function with subpath
- Update baseline

### Changed
- Connection: Allow pre-selected login providers
- Connection: Display connection status on Users page independent of the SSO module.
- General: indicate compatibility with the upcoming version of WordPress, 6.5.
- General: indicate compatibility with the upcoming version of WordPress - 6.6.
- General: indicate compatibility with the upcoming version of WordPress - 6.7.
- General: indicate full compatibility with the latest version of WordPress, 6.4.
- General: updated PHP requirement to PHP 7.0+
- General: update WordPress version requirements to WordPress 6.2.
- General: update WordPress version requirements to WordPress 6.3.
- General: update WordPress version requirements to WordPress 6.4.
- Updated dependencies.
- Updated package dependencies.
- Update package dependencies.

### Removed
- Connection: Removed deprecated method features_available
- Connection: Removed features_enabled deprecated method
- General: Update minimum PHP version to 7.2.
- General: Update minimum WordPress version to 6.6.
- General: update WordPress version requirements to WordPress 6.5.
- Remove obsolete `skip-test-php` composer script. No change to the plugin itself.

### Fixed
- Code: Remove extra params on function calls.
- Remove unnecessary boolean check that was confusing Phan.
