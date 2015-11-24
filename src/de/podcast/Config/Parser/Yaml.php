<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 21.11.15
 * Time: 12:48
 */

namespace de\podcast\config\parser;

use de\podcast\Config\Parser;

class Yaml extends Parser
{

    public function load($configFile)
    {
        $yaml = new \Symfony\Component\Yaml\Parser();

        foreach ($yaml->parse(file_get_contents($configFile)) as $key => $value) {
            $this->oConfig->$key = $value;
        }
    }
}