<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 22.11.15
 * Time: 21:04
 */

namespace de\podcast\Source;

abstract class Source implements SourceInterface
{
    protected $aExcludedIdentifiers = array();
    protected $aFiles = array();
    protected $aStrings = array();
    protected $aStringsByLang = array();
    protected $aStringsByType = array();

    public function findFiles($path, $file)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $dir) {
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                $globIterator = new \GlobIterator($dir . DIRECTORY_SEPARATOR . $file,
                    \FilesystemIterator::KEY_AS_PATHNAME);
                foreach ($globIterator as $path => $fileinfo) {
                    $this->addFiles($path);
                }
            } else {
                foreach (glob($dir . DIRECTORY_SEPARATOR . $file) as $path) {
                    $this->addFiles($path);
                }
            }
        }
    }

    public function addFiles($file)
    {
        $this->aFiles[] = $file;
    }

    public function addString($translationKey, $value)
    {
        $this->aStrings[$translationKey] = $value;
    }

    public function addStringByLang($translationKey, $value, $lang)
    {
        $this->aStringsByLang[$lang][$translationKey] = $value;
    }

    public function addStringByType($translationKey, $value, $type)
    {
        $this->aStringsByType[$type][$translationKey] = $value;
    }

    public function addExcludedIdentifiers($identifier)
    {
        $this->aExcludedIdentifiers[] = $identifier;
    }
}