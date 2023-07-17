<?php
namespace App\Service;

class OpenWeather {
    // OpenWeather Api Key https://home.openweathermap.org/api_keys
    private string $apiKey = '64feb386976fd3a292958e63341ce232';
    // Moscow latitude
    private float $lat = 55.580257;
    // Moscow longitude
    private float $long = 36.7261916;

    public function getDailyWeather() {
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, 'https://api.openweathermap.org/data/3.0/onecall?lat=' . $this->lat . '&lon=' . $this->long . '&appid=' . $this->apiKey . '&units=metric&exclude=hourly,minutely,current');
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connection, CURLOPT_HEADER, false);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($connection);
        curl_close($connection);
        return $result ? json_decode($result) : null;
    }

    public function getLatitude() : ?float {
        return $this->lat;
    }

    public function getLongitude() : ?float {
        return $this->long;
    }
}