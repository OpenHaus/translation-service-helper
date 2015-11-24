<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 22.11.15
 * Time: 21:03
 */

namespace de\podcast\Source\Parser;

use de\podcast\Source\Source;
use de\podcast\Source\SourceException;

class Android extends Source
{
    /*    public function findFiles($path, $file)
        {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($iterator as $dir) {
                if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                    $globIterator = new \GlobIterator($dir . DIRECTORY_SEPARATOR . $file,
                        \FilesystemIterator::KEY_AS_PATHNAME);
                    foreach ($globIterator as $key => $fileinfo) {
                        $this->_addFiles($key, $file);
                    }
                } else {
                    foreach (glob($dir . DIRECTORY_SEPARATOR . $file) as $key) {
                        $this->_addFiles($key, $file);
                    }
                }
            }
        }

        private function _addFiles($path, $file)
        {
            if (substr(substr($path, 0, strlen($path) - strlen($file)), -2) != './') {
                $this->addFiles($path);
            }
        }*/

    public function retrieve()
    {
        $this->retrieveIdentifiers();

        return $this->aStrings;
    }

    private function retrieveIdentifiers()
    {
        // Start with
        foreach ($this->aFiles as $key => &$file) {
            $pattern = '~/values-[\w]{2,}/~';

            if (preg_match($pattern, $file)) {
                $this->extractStrings($file);
                unset($this->aFiles[$key]);
            }
        }

        foreach ($this->aFiles as $key => &$file) {
            $this->extractStrings($file);
            unset($this->aFiles[$key]);
        }
    }

    private function extractStrings($file)
    {
        if (file_exists($file)) {
            $xml = simplexml_load_file($file, "\\de\\podcast\\Source\\Parser\\AndroidXML");
            if (!($xml instanceof \de\podcast\Source\Parser\AndroidXML)) {
                throw new SourceException("Could not parse $file");
            }

            foreach ($xml as $key => $value) {
                $translationKey = $value->attributes()->{'name'} . "";

                if (!in_array($translationKey, $this->aExcludedIdentifiers)) {
                    if ($key == 'string') {
                        $val = $value . "";
                        if (strpos($val, '@string/') === false) {
                            $this->addString($translationKey, $val);
                        }
                    } else if ($key == 'string-array') {
                        $this->addString($translationKey, (array)$value->item);
                    } else {
                        throw new SourceException("Unknown translation key '{$key}");
                    }
                }
            }
        }
    }
}

class AndroidXML extends \SimpleXMLElement
{

}