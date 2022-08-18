<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ColorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++) {
            $color = new Color;
            $color->setName("Color $i")
                ->setImage("https://img.freepik.com/premium-vector/retro-science-education-background_23-2148476365.jpg?w=2000");
            $manager->persist($color);
        }

        $manager->flush();
    }
}
