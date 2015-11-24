<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 20.11.15
 * Time: 23:49
 */
require_once __DIR__.'/../vendor/autoload.php';

$oTranslationServiceHelper = new \de\podcast\TranslationServiceHelper();
$oTranslationServiceHelper->runFromCli($argv);