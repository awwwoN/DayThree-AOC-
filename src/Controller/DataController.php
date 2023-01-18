<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    #[Route('/', name: 'SHOW_VALUE')]
    public function showValue(): Response
    {
        $value = $this->count();

        return $this->render('data.html.twig', [
            'value' => $value,
        ]);
    }

    public function getDataFromFile(): array
    {
        $file = file_get_contents('/home/noa/PhpstormProjects/AdventsOfCode/Day3/src/data.txt');

        return explode("\n", $file);
    }

    public function splitData()
    {
        $file = $this->getDataFromFile();

        $splitData = [];

        foreach ($file as $key => $line) {
            $splitData[$key] = str_split($line, strlen($line)/2);
        }

        return $splitData;
    }

    public function findSameLetter(): array
    {
        $splitData = $this->splitData();

        $sameLetter = [];

        foreach ($splitData as $key => $line) {
            $compartment1 = str_split($line[0]);
            $compartment2 = str_split($line[1]);
            $sameLetter[$key] = implode(array_unique(array_intersect($compartment1, $compartment2)));
        }

        return $sameLetter;
    }

    public function count(): int
    {
        $sameLetter = $this->findSameLetter();
        $lowercaseArray = range('a', 'z');
        $uppercaseArray = range('A', 'Z');
        $rucksacks = array_merge($lowercaseArray, $uppercaseArray);
        $sum = [];

        foreach ($sameLetter as $key => $value){
            $sum[$key] = array_search($value, $rucksacks)+1;
        }

        return array_sum($sum);
    }
}