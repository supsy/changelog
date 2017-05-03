<?php

namespace Supsy\Changelog\Tests;

use PHPUnit\Framework\TestCase;
use Supsy\Changelog\Application;

class ApplicationTest extends TestCase
{
    protected function setUp()
    {
        
    }
    
    protected function tearDown()
    {
        
    }
    
    public function testRun()
    {
        $application = $this->getApplication();
        
        $this->expectException('Exception');
        $application->run();
    }
    
    protected function getApplication() {
        return new Application();
    }

}