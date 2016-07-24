# Reading SSL Certificates

[![Build Status](https://travis-ci.org/punkstar/ssl.svg?branch=master)](https://travis-ci.org/punkstar/ssl) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/punkstar/ssl/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/punkstar/ssl/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/punkstar/ssl/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/punkstar/ssl/?branch=master)

This is a library for easily reading and understanding SSL certificates using PHP.

## Installation

    composer require punkstar/ssl

## Usage

    $reader = new Reader();
    $certificate = $reader->readFromUrl("https://github.com");

    printf("Name: %s\n", $certificate->getCertName());
    printf("Valid To: %s\n", $certificate->getValidTo()->format('r');
    printf("Valid From: %s\n", $certificate->getValidFrom()->format('r');
