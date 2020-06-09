<?php
require_once('../models/ShopManager.php');
require_once('../models/Shop.php');
$shopManager = new \Nicolas\FermeHaffner\Models\ShopManager();

$shops = $shopManager->getShops();
foreach ($shops as $shop) {
    $tab = [
        "id" => $shop->id(),
        "name" => $shop->name(),
        "adress" => $shop->adress(),
        "city" => $shop->city(),
        "postal_code" => $shop->postalCode(),
        "latitude" => $shop->latitude(),
        "longitude" => $shop->longitude(),
    ];
    $shopsTable['shops'][] = $tab;
}

echo json_encode($shopsTable);