<?php

it('returns the pathframe demo status', function () {
    $this->getJson('/pathframe-demo')
        ->assertOk()
        ->assertExactJson(['status' => 'ok']);
});
