<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Disable Vite asset resolution during feature tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}
