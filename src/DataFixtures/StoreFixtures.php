<?php

namespace App\DataFixtures;

use App\Entity\Store;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StoreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $titles = ["FPT", "CellphoneS", "MediaMart", "Shop Dunk", "EDIGI", "Mobile World"];
        $images = ["http://cdn2.tieudungplus.vn/upload/qeXw6Srue12aQG46um9kw/files/fpt-shop.png",
                    "https://thumb.danhsachcuahang.com/image/2020/03/20200313_4de5f96d974976b57261100ec8b72b05_1584067999.png",
                    "https://cafef1.mediacdn.vn/LOGO/MEDIAMART.jpg",
                    "https://static.topcv.vn/company_logos/yuYZUFNdRmUmy1sNjKzQYwg4IfIVA9S4_1649822542____1875c9736337d919776d693eb13a70a3.png",
                    "https://ippgroup.vn/joboffers/eDiGi.png",
                    "https://cdn.haitrieu.com/wp-content/uploads/2021/11/Logo-The-Gioi-Di-Dong-MWG.png"];
        $length = count($titles);
        for ($i=0; $i<$length; $i++) {
            $store = new Store;
            $store->setName($titles [$i])
                  ->setImage($images[$i]);
            $manager->persist($store);
        }

        $manager->flush();
    }
}