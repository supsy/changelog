<?php

namespace Supsy\Changelog;

use Supsy\Changelog\ChangelogOptionParser;
use Supsy\Changelog\ChangelogEntry;

class Application
{
    public function run() {
        $changelogOptionParser = new ChangelogOptionParser();
        $options = $changelogOptionParser->parse($GLOBALS['argv']);

        $changeLogEntry = new ChangelogEntry($options);
        $changeLogEntry->create();
    }
}
