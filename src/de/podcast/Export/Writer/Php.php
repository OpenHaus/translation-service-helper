<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 23.11.15
 * Time: 15:25
 */

namespace de\podcast\Export\Writer;

use de\podcast\Export\Writer;

class Php extends Writer
{

    public function save(array $aStrings)
    {
        return file_put_contents($this->getDir() . DIRECTORY_SEPARATOR . 'php_strings.all.php', serialize($aStrings));
    }
}