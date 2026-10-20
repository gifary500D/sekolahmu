<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('the application returns a successful response', function () {
    $response = $this->withoutVite()->get('/');

    $response->assertStatus(200);
});
