<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 22.11.15
 * Time: 21:03
 */

namespace de\podcast\Source\Parser;

use de\podcast\Source\Source;

class Seagull_php extends Source
{
    private $aDefaultWords = array();
    private $aWords = array();

    public function retrieve()
    {
        $this->retrieveIdentifiers();

        return $this->aStrings;
    }

    private function retrieveIdentifiers()
    {
        foreach ($this->aFiles as $key => &$file) {
            $this->extractStrings($file);
            unset($this->aFiles[$key]);
        }

        $aAllWords = array_merge($this->aWords, $this->aDefaultWords);

        foreach ($aAllWords as $key => $value) {
            $this->addString($key, $value);
        }
    }

    private function extractStrings($file)
    {
        if (file_exists($file)) {
            include_once $file;

            if (isset($defaultWords)) {
                foreach ($defaultWords as $key => $value) {
                    $this->aDefaultWords[$key] = $value;
                }
            }

            if (isset($words)) {
                foreach ($words as $key => $value) {
                    $this->aWords[$key] = $value;
                }
            }
        }
    }
}