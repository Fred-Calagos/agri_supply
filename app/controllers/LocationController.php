<?php

namespace App\controllers;

use App\models\refProvince;
use App\Core\LoginController;
use App\models\refBrgy;
use App\models\refCityMun;

class LocationController extends LoginController
{
    public function getProvinces() {
        if (isset($_POST['region_id'])) {
            $regionId = $_POST['region_id'];

            $provinces = refProvince::getProvincesByRegion($regionId);

            echo json_encode($provinces);
        }
    }
    public function getCityMun(){
        if (isset($_POST['prov_id'])) {
            $provId = $_POST['prov_id'];

            $provinces = refCityMun::getCitymunByProvince($provId);

            echo json_encode($provinces);
        }
    }
    public function getBrgy(){
        if (isset($_POST['citymun_Id'])) {
            $citymunId = $_POST['citymun_Id'];

            $citymun = refBrgy::getBrgyByCityMun($citymunId);

            echo json_encode($citymun);
        }
    }
}