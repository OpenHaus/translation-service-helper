<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 21.11.15
 * Time: 23:09
 */

namespace de\podcast\Config;

interface ConfigInterface
{
    public function load($configFile);

    public function get();
}