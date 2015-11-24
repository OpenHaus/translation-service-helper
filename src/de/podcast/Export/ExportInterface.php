<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 23.11.15
 * Time: 15:26
 */

namespace de\podcast\Export;

interface ExportInterface
{

    public function save(array $aStrings);
}