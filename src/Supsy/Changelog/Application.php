<?php

namespace Supsy\ChangeLog;

use Supsy\Changelog\ChangelogOptionParser;
use Supsy\Changelog\ChangeLogEntry;

class Application
{
    public function run() {
        $changelogOptionParser = new ChangelogOptionParser();
        $options = $changelogOptionParser->parse($GLOBALS['argv']);
        
        $changeLogEntry = new ChangeLogEntry($options);
        $changeLogEntry->run();
    }
}
