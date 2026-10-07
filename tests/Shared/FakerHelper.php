<?php

namespace Bimer\Test\Shared;

use Faker\Factory;
use Faker\Generator;

class FakerHelper
{
    protected static ?Generator $faker = null;

    /**
     * The Faker default locale
     */
    protected static string $fakerLocale = 'pt_BR';

    public static function get(): Generator
    {
        if (is_null(self::$faker)) {
            self::$faker = Factory::create(self::$fakerLocale);
        }

        return self::$faker;
    }
}
