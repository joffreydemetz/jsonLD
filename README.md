# JDZ JSON-LD

Utilities to manage JSON-LD display.

## Installation

To install the library, use Composer:

```sh
composer require jdz/jsonld
``` 

## Requirements

- PHP >= 8.2 (no other dependency)

## How it works

Every schema.org type is an entity class in `JDZ\JsonLd\` extending `Entity`:

- `new XxxEntity(bool $inContext = false)` — pass `true` for the top-level
  entity: it carries `@context` and is the one that exports. Nested entities
  keep the default `false`.
- `make(...)` sets the type's main properties and returns the entity.
- `validate()` completes derived values (an `AggregateOffer`'s price range and
  offer count, an `ItemList`'s item count) and recurses into nested entities.
- `export(bool $pretty = true)` returns the
  `<script type="application/ld+json">` block — an empty string for an entity
  created without context.
- `get()` / `set()` / `has()` / `clear()` read and write any property; `set()`
  skips empty values.

## Usage

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

### Nested Entities (Product)

```php
<?php
use JDZ\JsonLd\ProductEntity;
use JDZ\JsonLd\BrandEntity;
use JDZ\JsonLd\OfferEntity;

$product = (new ProductEntity(true))
    ->make('Blue mug', 'MUG-001', 'A blue ceramic mug', 'https://example.com/mug.jpg', 'https://example.com/mug/')
    ->setBrand((new BrandEntity())->make('Acme'))
    ->addOffer((new OfferEntity())->make('12.90', 'EUR', OfferEntity::AVAILABLE_IN_STOCK));

echo $product->validate()->export(true);
```

### Breadcrumbs

```php
<?php
use JDZ\JsonLd\BreadcrumbListEntity;

$crumbs = (new BreadcrumbListEntity(true))
    ->make('https://example.com/shop/mug/', 3)
    ->addListItemWithUrl('https://example.com/', 'Home')
    ->addListItemWithUrl('https://example.com/shop/', 'Shop')
    ->addListItemWithUrl('https://example.com/shop/mug/', 'Blue mug');

echo $crumbs->validate()->export(false);
```

## Entities

| Entity | `make()` | Extra methods |
|--------|----------|---------------|
| `ArticleEntity` | `$url, $headline, $abstract, $datePublished` | `setMainEntityOfPage()`, `setAuthor()`, `setPublisher()` |
| `BlogPostingEntity` | `$url, $headline, $abstract, $datePublished, $image, $author = '', $dateModified = '', $publisher = ''` | `setMainEntityOfPage()`, `setAuthor()`, `setPublisher()` |
| `WebPageEntity` | `$url` | |
| `ImageObjectEntity` | `$url` | |
| `PersonEntity` | `$name` | |
| `OrganizationEntity` | `$name, $url, $logo, $email = '', $telephone = ''` | |
| `SellerEntity` | same as `OrganizationEntity` | |
| `BrandEntity` | `$name, $logo = '', $url = ''` | `setLogo()` |
| `ProductEntity` | `$name, $sku, $description, $image, $url` | `setBrand()`, `setLogo()`, `addOffer()`, `addOffers()` (an `AggregateOfferEntity`) |
| `OfferEntity` | `$price, $priceCurrency, $availability = AVAILABLE_IN_STOCK, $condition = CONDITION_NEW` | `setAvailability()`, `setItemCondition()`, `setCategory()`, `setUrl()`, `setSeller()`; `AVAILABLE_*` / `CONDITION_*` constants |
| `AggregateOfferEntity` | `$lowPrice, $highPrice, $priceCurrency, $offerCount` | `init()`, `addOfferItem()` |
| `ItemListEntity` | `$url, int $numberOfItems` | `addListItem()`, `addListItemWithUrl()` |
| `BreadcrumbListEntity` | same as `ItemListEntity` | |
| `ListItemEntity` | `$url, $name = '', int $position = 0` | |
| `PlaceEntity` | `$name, $mapUrl = '', $latitude = '', $longitude = ''` | `setGeo()` |
| `GeoCoordinatesEntity` | `$latitude, $longitude` | |
| `EducationalOccupationalProgramEntity` | `$url` | `setApplicationStartDate()`, `setApplicationDeadline()` |

## Tests

```sh
composer test
```

## Changelog

- **1.0.3** - PHP >= 8.2; unit test suite.
- **1.0.1 / 1.0.2** - License and README updates.
- **1.0.0** - Initial release.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Author

- Joffrey Demetz - [joffreydemetz.com](https://joffreydemetz.com)

For more examples, see the examples directory.
