<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

try {

    $GeoCoordinatesJsonLD = new \JDZ\JsonLd\GeoCoordinatesEntity(true);
    $GeoCoordinatesJsonLD->make('43.92370387039706', '1.781505605753222');
    $GeoCoordinatesJsonLD->validate();

    echo 'GeoCoordinatesJsonLD' . "\n";
    echo $GeoCoordinatesJsonLD->export(true);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
