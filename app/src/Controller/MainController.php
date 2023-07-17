<?php
namespace App\Controller;

use App\Entity\Weather;
use App\Service\OpenWeather;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    #[Route('/', name: 'main')]
    public function main(ManagerRegistry $doctrine) {
        $em = $doctrine->getManager();
        $weatherData = $em->getRepository(Weather::class)->getWeatherForNext3Days();
        return $this->render('main.html.twig', [
            'weatherData' => $weatherData
        ]);
    }

    #[Route('/update', name: 'update')]
    public function update(ManagerRegistry $doctrine, OpenWeather $openWeather) {
        $em = $doctrine->getManager();
        $weatherRepository = $em->getRepository(Weather::class);
        $weatherData = $openWeather->getDailyWeather();
        if ($weatherData && isset($weatherData->daily)) {
            foreach ($weatherData->daily as $dayWeatherData) {
                $currentDay = new \DateTime();
                $currentDay->setTimestamp($dayWeatherData->dt);
                $currentDayWeather = $weatherRepository->findOneBy(['date' => $currentDay]);
                if (!$currentDayWeather) {
                    $currentDayWeather = new Weather();
                    $currentDayWeather->setDate($currentDay);
                }
                $currentDayWeather->setTemp($dayWeatherData->temp->day);
                $currentDayWeather->setCloudinessPercent($dayWeatherData->clouds);
                $em->persist($currentDayWeather);
            }
        }
        $em->flush();
        $weatherData = $em->getRepository(Weather::class)->getWeatherForNext3Days();
        $result = [];
        foreach ($weatherData as $weatherDay) {
            $result[] = [
                'date' => $weatherDay->getDate()->format('d.m.Y'),
                'temp' => $weatherDay->getTemp(),
                'cloudinessPercent' => $weatherDay->getCloudinessPercent()
            ];
        }
        return new Response(json_encode(['weather' => $result]), 200, ['Content-Type' =>  'application/json']);
    }
}