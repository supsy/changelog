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
        
        $specs->add('t|type:', 'The category of the change' )
            ->isa('String');

        $specs->add('n|dry-run', 'Don`t actually write anything, just print' );

        $specs->add('u|git-username', 'Use Git user.name configuration as the author' );

        $specs->add('h|help', 'Print help message' );

        $parser = new OptionParser($specs);

        try {
            $result = $parser->parse( $argv );

            if (isset($result['help'])) {
                $printer = new ConsoleOptionPrinter();
                $message = $printer->render($specs);
                $this->usage($message);
            }

            return $result;
        } catch( \Exception $e ) {
            echo $e->getMessage()."\n";
            exit(2);
        }
    }

    public function usage($message) {
        echo "Changelog Tool\n\n";
        echo "Available options:\n";
        echo $message;
        exit();
    }
}
