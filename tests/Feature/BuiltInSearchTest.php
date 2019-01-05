<?php

namespace BinaryTorch\LaRecipe\Tests\Feature;

use Illuminate\Support\Facades\Config;
use BinaryTorch\LaRecipe\Tests\TestCase;
use BinaryTorch\LaRecipe\Models\Documentation;

class BuiltInSearchTest extends TestCase
{
    protected $documentation;

    public function setUp()
    {
        parent::setUp();

        $this->documentation = $this->app->make(Documentation::class);
    }

    /** @test */
    public function it_can_search_within_givin_version_for_h1_h2_h3()
    {
        Config::set('larecipe.docs.path', 'tests/views/docs');

        // activate built-in search..
        Config::set('larecipe.search.enabled', true);
        Config::set('larecipe.search.default', 'internal');

        $this->get('/docs/search-index/1.0')
            ->assertStatus(200)
            ->assertJsonStructure([
                '/foo' => [
                    'h1',
                    'h2',
                    'h3',
                ],
                '/blade' => [
                    'h1',
                ],
                '/subfolder/section' => [
                    'h1',
                    'h2',
                ],
            ]);

        $this->assertTrue(true);
    }
}
