<?php

namespace App\DataFixtures;

use App\Entity\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use app\Entity\Color;

class PhoneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $titles = ["Iphone 13 pro max", "Realme Q3 pro", "Samsung S22 Ultra", "Xiaomi Redmi Note 11", "Vivo Y20", "Oppo A16"];
        $images = ["https://cdn1.viettelstore.vn/images/Product/ProductImage/medium/1051159192.jpeg", 
        "https://cdn.tgdd.vn/Products/Images/42/237633/realme-q3-pro-1-600x600.jpg",
        "https://cdn.tgdd.vn/Products/Images/42/271698/Galaxy-S22-Ultra-Black-600x600.jpg",
        "https://cdn.tgdd.vn/Products/Images/42/269831/Xiaomi-redmi-note-11-black-600x600.jpeg",
        "https://asia-exstatic-vivofs.vivo.com/PSee2l50xoirPK7y/1598325325969/7a35057627dba1b8c21720124a0d4982.png",
        "https://cdn.tgdd.vn/Products/Images/42/240631/oppo-a16-silver-8-600x600.jpg"];
        $length = count($titles);
        for ($i=0; $i<$length; $i++) {
            $phone = new Phone;
            $phone->setTitle($titles[$i])
                 ->setQuantity(rand(10,100)) 
                 ->setPrice((float)(rand(100,1000)))
                 ->setImage($images[$i])
                 ->setDate(\DateTime::createFromFormat('Y/m/d','2022/07/30'));
            $manager->persist($phone);     
        }

        $manager->flush();
    }
}
