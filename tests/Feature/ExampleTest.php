<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_has_expected_name(): void
    {
        $this->assertEquals('Laravel', config('app.name'));
    }
}
