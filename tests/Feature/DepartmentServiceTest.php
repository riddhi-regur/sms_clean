<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('it validates via the route', function () {
    $this->withoutMiddleware();

    $response = $this->postJson('/department', [
        'name' => '',
        'code' => ''
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'code']);
});
