<?php

it('returns the API status', function () {
    $this->getJson('/api/ping')
        ->assertOk()
        ->assertExactJson(['data' => ['status' => 'ok']]);
});
