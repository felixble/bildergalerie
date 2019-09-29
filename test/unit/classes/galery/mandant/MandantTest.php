<?php

use PHPUnit\Framework\TestCase;

class MandantTest extends TestCase {
    public function testGetPageTitle() {
        $mandant = new Mandant(4711, "TestTitle", "TestGalery");
        $this->assertEquals("TestTitle", $mandant->getPageTitle());
    }
}