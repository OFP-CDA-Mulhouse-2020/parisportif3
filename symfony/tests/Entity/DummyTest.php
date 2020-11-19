<?php


use App\Entity\Dummy;
use PHPUnit\Framework\TestCase;

class DummyTest extends TestCase
{

    public function testCanCreateNewDummy()
    {
        $testDate = new DateTime('now');
        $this->assertInstanceOf(
            Dummy::class,
            Dummy::setFromString('Jean-paul', '123456', $testDate)
        );
    }
}
