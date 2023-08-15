# Core

[![PHP](https://img.shields.io/badge/PHP-8.2-blue.svg)](http://php.net)
![GitHub release (with filter)](https://img.shields.io/github/v/release/rdurica/core)
![GitHub](https://img.shields.io/github/license/rdurica/core)
![Packagist Downloads (custom server)](https://img.shields.io/packagist/dm/rdurica/core)

The Core package is a comprehensive utility toolkit designed to enhance your application development process by
providing a range of essential functionalities. With its focus on seamless integration, it includes foundational
components for a versatile base model, dynamic layouts, easy-to-use ACL (Access Control List), and a hassle-free
authentication mechanism. It's aimed at boosting productivity and empowering developers to build feature-rich
applications with greater ease and efficiency.

![image](https://github.com/rdurica/core/assets/16089770/1a959411-b8aa-4f5a-b76e-bdbd8301d383)

## Installation

To install latest version use [Composer](https://getcomposer.org).

```shell
composer require rdurica/core
```

Register extension

```neon
extensions:
	rdurica.core: Rdurica\Core\Extension\CoreExtension
```

## Key Features

#### Base Model and Utility Traits ####

The package comes equipped with a robust base model that streamlines database interactions and enforces standardized
conventions. Additionally, a collection of utility traits enhances various aspects of your application's functionality,
enabling code reusability and maintainability.

#### Dynamic Layout with MDBBootstrap ####

The Core package seamlessly integrates the powerful Material Design for Bootstrap (MDBBootstrap) framework. This enables
the creation of responsive and visually appealing layouts that are extensible and customizable to suit your project's
design requirements.

#### SweetAlert for Flash Messages ####

Elevate the user experience with SweetAlert integration, allowing you to create attractive and user-friendly flash
messages. This enhances the presentation of notifications and messages, ensuring a polished and engaging UI for your
users.

#### Access Control List (ACL) for Easy Authorization ####

The Core package includes a flexible ACL system that simplifies authorization management. It provides a structured way
to define user roles, permissions, and access levels, ensuring that sensitive actions and resources are protected.

## Contributing

If you would like to contribute to this project, please fork the repository and create a pull request. We welcome all
contributions, including bug fixes, new features, and documentation improvements.

## License

This project is licensed under the terms of the MIT license.