<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

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
    echo $BlogPostingJsonLD->export(true);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
