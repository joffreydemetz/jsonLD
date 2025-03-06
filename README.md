# JDZ JSON-LD

Utilities to manage JSON-LD display.

## Installation

To install the library, use Composer:

```sh
composer require jdz/jsonld
``` 

## Usage

I'll add more examples soon .. including for nested elements

### Blog Posting

```php
<?php
try {
    $BlogPostingJsonLD = new \JDZ\JsonLd\BlogPostingEntity(true);
    $BlogPostingJsonLD->make(
        'https://localhost/blog/article/',
        'My Article',
        'My article short description',
        (new \DateTimeImmutable('2024-06-10 22:11:45'))->format(\DateTime::RFC3339),
        'https://localhost/image.jpg',
        'The Author',
        (new \DateTimeImmutable('2024-09-14 14:14:14'))->format(\DateTime::RFC3339),
        'The publisher'
    );
    $BlogPostingJsonLD->validate();

    echo 'BlogPostingJsonLD' . "\n";
    echo $BlogPostingJsonLD->export(true) . "\n\n";
} catch (\Throwable $e) {
    echo $e->getMessage();
}
```

### Geo Coordinates

```php
<?php
try {
    $GeoCoordinatesJsonLD = new \JDZ\JsonLd\GeoCoordinatesEntity(true);
    $GeoCoordinatesJsonLD->make('43.92370387039706', '1.781505605753222');
    $GeoCoordinatesJsonLD->validate();

    echo 'GeoCoordinatesJsonLD' . "\n";
    echo $GeoCoordinatesJsonLD->export(true) . "\n\n";
} catch (\Throwable $e) {
    echo $e->getMessage();
}
```

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Author

- Joffrey Demetz - [joffreydemetz.com](https://joffreydemetz.com)

For more examples, see the examples directory.
