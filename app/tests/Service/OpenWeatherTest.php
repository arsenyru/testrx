<?php

namespace App\Tests\Service;

use App\Service\OpenWeather;
use PHPUnit\Framework\TestCase;

class OpenWeatherTest extends TestCase {
    public function testMoscow(): void {
        $openWeather = new OpenWeather();
        $this->assertSame($openWeather->getLatitude(), 55.580257);
        $this->assertSame($openWeather->getLongitude(), 36.7261916);
    }
}
