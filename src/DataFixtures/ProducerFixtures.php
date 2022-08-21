<?php

namespace App\DataFixtures;

use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProducerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $titles = ["Apple", "realme", "Samsung", "Xiaomi", "Vivo", "Oppo"];
        $images = ["https://i.pinimg.com/originals/03/32/88/033288573e174c88f2f3b3c789b75212.jpg",
                    "https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/032019/untitled-1_34.png?FxpwbzeZy8_zj4.SAzBmPJ8.ADlXNaYi&itok=G904y1dh",
                    "https://d3m9l0v76dty0.cloudfront.net/system/photos/705341/original/4cd06e3a46a1feadfc4f54b8c64bba66.jpg",
                    "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Xiaomi_logo_%282021-%29.svg/1024px-Xiaomi_logo_%282021-%29.svg.png",
                    "https://seeklogo.com/images/V/vivo-mobile-phones-logo-6C28635F1B-seeklogo.com.png",
                    "https://i0.wp.com/www.itvoice.in/wp-content/uploads/2022/04/Oppo.jpg?fit=1024%2C1024&ssl=1"];
        $length = count($titles);
        for ($i=0; $i<$length; $i++) {
            $producer = new Producer;
            $producer->setName($titles [$i])
                   ->setAddress("Viet Nam")
                   ->setImage($images [$i])
                   ->setAge(rand(1,10));
            $manager->persist($producer);
        }

        $manager->flush();
    }
}
