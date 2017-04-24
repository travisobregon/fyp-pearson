<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuggestionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_suggestion_belongs_to_a_user()
    {
        $suggestion = factory('App\Suggestion')->create();

        $this->assertInstanceOf('App\User', $suggestion->user);
    }
}
