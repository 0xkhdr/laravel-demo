<?php

it('renders the career portfolio', function () {
    $this->get('/')->assertOk()
        ->assertSee('Mohamed Khedr')
        ->assertSee('Kafka + Debezium CDC')
        ->assertSee('Frontier')
        ->assertSee('PHP / Laravel')
        ->assertSee('0xkhdr@gmail.com')
        ->assertDontSee('not available yet');
});
