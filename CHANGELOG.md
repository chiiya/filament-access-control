# Changelog

All notable changes to `filament-access-control` will be documented in this file.

## v1.7.1 - 2023-05-16

### What's Changed

- Fix role select not working correctly when creating a new user

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.7.0...1.7.1

## v1.7.0 - 2023-02-17

### What's Changed

- Laravel 10 Support by @bashgeek in https://github.com/chiiya/filament-access-control/pull/29
- Add japanese translations

### New Contributors

- @bashgeek made their first contribution in https://github.com/chiiya/filament-access-control/pull/29

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.6.0...1.7.0

## v1.6.0 - 2022-12-22

### What's Changed

- Upgraded package to use the [new filament notifications](https://filamentphp.com/docs/2.x/notifications/installation)

### What's Changed

- Fix table 'roles' doesn't exist -> Add spatie-permission vendor:publish by @magarrent in https://github.com/chiiya/filament-access-control/pull/23
- Add Arabic Translations by @vzool in https://github.com/chiiya/filament-access-control/pull/20
- Upgraded auth views to resemble the new default Filament auth views
- Fix roles and permissions not being restricted to filament guard
- Add compatibility with filament-logger

### New Contributors

- @magarrent made their first contribution in https://github.com/chiiya/filament-access-control/pull/23
- @vzool made their first contribution in https://github.com/chiiya/filament-access-control/pull/20

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.5.0...1.6.0

## v1.5.0 - 2022-08-02

### What's Changed

- Upgraded package to use the [new filament notifications](https://filamentphp.com/docs/2.x/notifications/installation)

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.4.0...1.5.0

## 1.4.0 - 2022-07-06

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.1 to 1.3.3 by @dependabot in https://github.com/chiiya/filament-access-control/pull/9
- Add support for Laravel 8 and PHP 8.0 by @stephenjude in https://github.com/chiiya/filament-access-control/pull/7
- Fixed validation for role resource by @stephenjude in https://github.com/chiiya/filament-access-control/pull/7

### New Contributors

- @stephenjude made their first contribution in https://github.com/chiiya/filament-access-control/pull/7

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.3.5...1.4.0

## v1.3.5 - 2022-07-01

### What's Changed

- Fixed config serialization
- Added config option `password_hint` for setting a helper text for the password field on the reset-password page

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.3.0...1.3.5

## v1.3.0 - 2022-03-07

## What's Changed

- Added trait for authorizing page access
- Improved documentation

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.2.0...1.3.0

## v1.2.0 - 2022-02-25

## What's Changed

- Added missing translations
- Added new optional two-factor-authentication feature (see README on how to enable)
- Updated and rename `filament:create-user` command to `filament-access-control:user`
- Added `filament-access-control:install` command to create base role and permissions

**Full Changelog**: https://github.com/chiiya/filament-access-control/compare/1.1.0...1.2.0

## 1.1.0 - 2022-02-23

- Account expiry date is now optional

## 1.0.0 - 2022-02-23

- Initial release
