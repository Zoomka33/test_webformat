<?php

use App\V1\Handler\Event\Statistics;

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
    'iblock',
    'OnStartIBlockElementAdd',
    [
        Statistics::class,
        'generateName'
    ]
);

$eventManager->addEventHandler(
    'iblock',
    'OnStartIBlockElementUpdate',
    [
        Statistics::class,
        'generateName'
    ]
);