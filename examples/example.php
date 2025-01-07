<?php

/**
 * Example 1
 */

require_once realpath(__DIR__ . '/../vendor/autoload.php');

try {
    $pretty = true;

    $BlogPostingJsonLD = (new \JDZ\JsonLd\BlogPostingEntity(true))
        ->make(
            'https://localhost/blog/article/',
            'My Article',
            'My article short description',
            (new \DateTimeImmutable('2024-06-10 22:11:45'))->format(\DateTime::RFC3339),
            'https://localhost/image;jpg',
            'The Author',
            (new \DateTimeImmutable('2024-09-14 14:14:14'))->format(\DateTime::RFC3339),
            'The publisher'
        );

    echo 'BlogPostingJsonLD' . "\n";
    echo $BlogPostingJsonLD->export($pretty);

    $GeoCoordinatesJsonLD = (new \JDZ\JsonLd\GeoCoordinatesEntity(true))
        ->make('43.92370387039706', '1.781505605753222');

    echo 'GeoCoordinatesJsonLD' . "\n";
    echo $GeoCoordinatesJsonLD->export($pretty);

    //$jsonLd = (new \JDZ\JsonLd\ItemListEntity(true))
    //    ->make($this->router->getCurrentUrl(), $total);

} catch (\Throwable $e) {
    echo $e->getMessage();
}
exit();
