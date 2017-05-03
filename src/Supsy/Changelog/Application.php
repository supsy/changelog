<?php

namespace Supsy\ChangeLog;

use Supsy\Changelog\ChangelogOptionParser;
use Supsy\Changelog\ChangelogEntry;

class Application
{
    public function run() {
        try {
            $changelogOptionParser = new ChangelogOptionParser();
            $options = $changelogOptionParser->parse($GLOBALS['argv']);

            $changeLogEntry = new ChangelogEntry($options);
            $changeLogEntry->create();
        } catch( \Exception $e ) {
            echo "\e[31merror\e[0m ".$e->getMessage()."\n";
            exit(1);
        }
        
    }
}
