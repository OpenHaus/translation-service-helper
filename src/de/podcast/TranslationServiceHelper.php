<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 21.11.15
 * Time: 00:10
 */

namespace de\podcast;

use de\podcast\config\Config;
use de\podcast\Config\ConfigException;
use de\podcast\Export\ExportException;
use de\podcast\Source\SourceException;
use mahlstrom\CommandLineArg;

class TranslationServiceHelper
{
    const CONFIGFILE = "config";
    const EXPORTTYPE = "export";
    const PROJECTNAME = "project";
    const QUIET = 'quiet';
    const DEFAULT_EXPORTTYPE = 'php';

    /**
     * @param array $argv
     * @throws ConfigException
     * @usage  php src/cli.php -c projectconfig.yaml
     */
    public function runFromCli(array $argv)
    {
        CommandLineArg::addArgument(self::CONFIGFILE, "c", "Config file to use", true, true);
        CommandLineArg::addArgument(self::EXPORTTYPE, "e", "File format for export", false, true);
        CommandLineArg::addArgument(self::PROJECTNAME, "p", "Name of project", false, true);
        CommandLineArg::addArgument(self::QUIET, "q", "Do not output debug messages", false, false);
        $args = CommandLineArg::parse($argv);

        if (isset($args[self::CONFIGFILE])) {
            $aStrings = $this->extract($this->loadConfig($args[self::CONFIGFILE]));
            $verbose = !isset($args[self::QUIET]);
            $this->debug("Found " . count($aStrings) . " strings.", $verbose);

            if (isset($args[self::PROJECTNAME])) {
                $project = $args[self::PROJECTNAME];
            } else {
                $project = pathinfo($args[self::CONFIGFILE], PATHINFO_FILENAME);
            }

            $exportType = (isset($args[self::EXPORTTYPE]) ? $args[self::EXPORTTYPE] : self::DEFAULT_EXPORTTYPE);

            $dir = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $project . DIRECTORY_SEPARATOR . time();
            $this->debug("Saving strings to '$dir'.", $verbose);
            $this->save($aStrings, $dir, $exportType);
        }
    }

    private function debug($str, $echo = false)
    {
        if ($echo) {
            echo "$str\r\n";
        }
    }

    /**
     * @param array $aStrings
     * @param $dir
     * @param $exportType
     * @return mixed
     * @throws ExportException
     */
    public function save(array $aStrings, $dir, $exportType)
    {
        mkdir($dir, 0777, true);

        $writer = __DIR__ . "/Export/Writer/" . ucfirst(strtolower($exportType)) . ".php";

        if (!file_exists($writer)) {
            throw new ExportException("No writer available for export type '{$exportType}'");
        }

        $class = "de\\podcast\\Export\\Writer\\" . ucfirst(strtolower($exportType));
        $oWriter = new $class();

        if (!($oWriter instanceof \de\podcast\Export\Writer)) {
            throw new ExportException("Writer '{$class}' must be instance of \\de\\podcast\\Export\\Writer");
        }

        $oWriter->setDir($dir);

        return $oWriter->save($aStrings);
    }

    /**
     * @param $configFile
     * @return Config
     * @throws ConfigException
     */
    public function loadConfig($configFile)
    {
        $ext = pathinfo($configFile, PATHINFO_EXTENSION);
        $parser = __DIR__ . "/Config/Parser/" . ucfirst(strtolower($ext)) . ".php";

        if (!file_exists($parser)) {
            throw new ConfigException("No parser available for config file with extension '{$ext}'");
        }

        $class = "de\\podcast\\Config\\Parser\\" . ucfirst($ext);
        $oParser = new $class();

        if (!($oParser instanceof \de\podcast\Config\Parser)) {
            throw new ConfigException("Parser '{$class}' must be instance of \\de\\podcast\\Config\\Parser");
        }

        $oParser->load($configFile);

        return $oParser->get();
    }

    /**
     * @param Config $config
     * @throws SourceException
     */
    public function extract(Config $config)
    {
        $aStrings = array();

        foreach ($config as $aVal) {

            if (!isset($aVal['type'])) {
                throw new SourceException("Type(s) of source is not defined");
            }

            foreach ($aVal['type'] as $type => $aConfig) {

                $type = ucfirst(strtolower($type));
                $parser = __DIR__ . "/Source/Parser/{$type}.php";

                if (!file_exists($parser)) {
                    throw new SourceException("No parser available for source '{$type}'");
                }

                if (!isset($aConfig['path'])) {
                    throw new SourceException("No path(s) defined for source '{$type}'");
                }
                $class = "de\\podcast\\Source\\Parser\\{$type}";
                $oParser = new $class();

                if (!($oParser instanceof \de\podcast\Source\Source)) {
                    throw new SourceException("Parser '{$class}' must be instance of \\de\\podcast\\Source\\Parser");
                }

                foreach ($aConfig['path'] as $path => $aFile) {
                    foreach ($aFile as $file) {
                        $oParser->findFiles($path, $file);
                    }
                }

                foreach ($aConfig['excludedIdentifiers'] as $identifier) {
                    $oParser->addExcludedIdentifiers($identifier);
                }

                $aStrings += $oParser->retrieve();
            }
        }

        return $aStrings;
    }
}