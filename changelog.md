# Changelog
All notable changes to Neat Log components will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Exclude filter.

### Removed
- $exclude parameter from Pattern filter.

## [0.1.1] - 2019-01-15
### Added
- Stream logger.

## [0.1.0] - 2018-10-12
### Added
- File logger.
- Syslog logger.
- Manifold logger.
- Log processor for logging context, placeholder substitution and truncating messages.
- Log filter for including messages based on pattern or severity.
- Log stamper for adding the used level and current time to messages.
