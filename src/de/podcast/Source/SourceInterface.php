<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 22.11.15
 * Time: 21:04
 */

namespace de\podcast\Source;


interface SourceInterface
{

    public function addFiles($file);

    public function findFiles($path, $file);

    public function retrieve();
}