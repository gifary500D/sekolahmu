<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Halaman Blade memakai @vite; di pengujian tidak perlu berkas hasil build.
        $this->withoutVite();
    }
}
