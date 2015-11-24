<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 21.11.15
 * Time: 23:12
 */

namespace de\podcast\Config;

abstract class Parser implements ConfigInterface
{

    protected $oConfig;

    function __construct()
    {
        $this->oConfig = new Config();
    }

    public function get()
    {
        return $this->oConfig;
    }
}