<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_works()
    {
        $response = $this->get('/shorties/test');

        $response->assertStatus(200);
        $response->assertSee('Hello from the Shorties package!');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Badmushroom\Shorties\ShortiesServiceProvider::class,
        ];
    }

    protected function defineRoutes($router)
    {
        require __DIR__ . '/../routes/web.php';
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Run package migrations if needed
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
