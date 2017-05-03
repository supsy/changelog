<?php

namespace Supsy\ChangeLog

use GetOptionKit\OptionCollection;
use GetOptionKit\OptionParser;

$options = new OptionCollection;
$options->add( 'f|foo:' , 'option require value' );  # returns spec object.

$options->add( 'b|bar+' , 'option with multiple value' );
$options->add( 'z|zoo?' , 'option with optional value' );

$options->add( 'f|foo:=i' , 'option require value, with integer type' );
$options->add( 'f|foo:=s' , 'option require value, with string type' );

$options->add( 'v|verbose' , 'verbose flag' );
$options->add( 'd|debug'   , 'debug flag' );


$parser = new OptionParser($options);
$result = $parser->parse( array( 'program' , '-f' , 'foo value' , '-v' , '-d' ) );

$spec = $result->verbose;
$spec = $result->debug;
$spec->value;
