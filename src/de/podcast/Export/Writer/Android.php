<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 23.11.15
 * Time: 15:45
 */

namespace de\podcast\Export\Writer;

use de\podcast\Export\Writer;

class Android extends Writer
{

    public function save(array $aStrings)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><resources/>');

        foreach ($aStrings as $attr => $val) {
            if (is_string($val)) {
                $xml->addChild("string", $val)->addAttribute("name", $attr);
            } else if (is_array($val)) {
                $cxml = new \SimpleXMLElement('<string-array/>');
                $cxml->addAttribute("name", $attr);
                foreach($val as $value) {
                    $cxml->addChild("item", $value);
                }
                $this->append($xml, $cxml);
                unset($cxml);
            }
        }

        return $xml->asXML($this->getDir() . DIRECTORY_SEPARATOR . 'android_strings.all.xml');
    }

    private function append(\SimpleXMLElement $to, \SimpleXMLElement $from) {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }
}