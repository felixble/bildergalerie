<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    public function testGetMandant() {
        $mandant = new Mandant(4711, "TestTitle", "TestGalery");
        $user = new User($mandant, 4712, "mmustermann", "mustermann",
            "max", "mmustermann@example.com");
        $this->assertEquals($mandant, $user->getMandant());
    }
}