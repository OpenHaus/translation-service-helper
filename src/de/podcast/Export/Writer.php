<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 23.11.15
 * Time: 15:25
 */

namespace de\podcast\Export;


abstract class Writer implements ExportInterface
{

    private $dir;

    /**
     * @return mixed
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param mixed $dir
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }
}