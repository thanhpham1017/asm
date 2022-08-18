<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ColorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $titles = ["Forest Green", "Yellow", "Black", "Space Grey", "Ocean Blue", "Whiteline"];
        $images = ["https://m.media-amazon.com/images/I/31er9QrwtHL._AC_SX425_.jpg",
                    "https://media.loveitopcdn.com/29263/so-201.jpg",
                    "https://storage.needpix.com/rsynced_images/black-square-with-fleck-pattern.jpg",
                    "https://www.solidbackgrounds.com/images/3600x3600/3600x3600-outer-space-solid-color-background.jpg",
                    "https://www.upholsteryshop.co.uk/wp-content/uploads/2016/02/OceanBlue.jpg",
                    "https://www.porcelaingres.com/media/a3/46/db/1651069136/pg-just_grey-light_grey-_-nat-6060-f1-x600113x8.jpg"];
        $length = count($titles);
        for ($i=1; $i<=$length; $i++) {
            $color = new Color;
            $color->setName($titles [$i])
                  ->setImage($images [$i]);
            $manager->persist($color);
        }

        $manager->flush();
    }
}
