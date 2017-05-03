<?php

namespace Supsy\Changelog;

use GetOptionKit\OptionCollection;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionPrinter\ConsoleOptionPrinter;

class ChangelogOptionParser
{
    public function parse($argv) {

        $specs = new OptionCollection;
        $specs->add('amend', 'Amend the previous commit' );

        $specs->add('f|force', 'Overwrite an existing entry' );

        $specs->add('m|merge-request:', 'Merge Request ID' )
            ->isa('Number');

        $specs->add('n|dry-run', 'Don`t actually write anything, just print' );

        $specs->add('u|git-username', 'Use Git user.name configuration as the author' );

        $specs->add('h|help', 'Print help message' );

        #$printer = new ConsoleOptionPrinter();
        #echo $printer->render($specs);

        $parser = new OptionParser($specs);

        try {
            $result = $parser->parse( $argv );

            return $result;
        } catch( \Exception $e ) {
            echo $e->getMessage()."\n";
            exit(2);
        }
    }

}
