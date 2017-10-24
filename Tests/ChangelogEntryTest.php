<?php

namespace Supsy\Changelog\Tests;

use PHPUnit\Framework\TestCase;
use Supsy\Changelog\ChangelogEntry;

class ChangelogEntryTest extends TestCase
{
    protected function setUp()
    {
        
    }
    
    protected function tearDown()
    {
        
    }
    
    public function testCreate()
    {
        $changelogEntry = $this->getChangelogEntry();
        
        $this->setExpectedException("Exception");
        $changelogEntry->create();
    }
    
    protected function getChangelogEntry() {
        $changelogEntry = new ChangelogEntry($this->getOptionResult());
        
        return $changelogEntry;
    }
    
    protected function getOptionResult() {
        $options = $this->getMockBuilder('GetOptionKit\OptionResult')
                     ->disableOriginalConstructor()
                     ->getMock();
        
        return $options;
    }

}