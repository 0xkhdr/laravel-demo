<?php

it('renders the career portfolio', function () {
    $this->get('/')->assertOk()
        ->assertSee('Mohamed Khedr')
        ->assertSee('Kafka + Debezium CDC')
        ->assertSee('Frontier')
        ->assertSee('PHP / Laravel')
        ->assertSee('Strong professional')
        ->assertSee('Primary backend foundation')
        ->assertSee('0xkhdr@gmail.com')
        ->assertSee('aria-controls="primary-nav"', false)
        ->assertSee('aria-label="Primary navigation"', false)
        ->assertSee('x-data="portfolioUi"', false)
        ->assertDontSee('not available yet');
});
