<?php
use Laravel\Lumen\Testing\DatabaseMigrations;

class BalanceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function testNotFound()
    {
        $this->get('/balance?account_id=1234');

        $this->assertEquals(
            '0',
            $this->response->getContent()
        );

        $this->assertEquals(
            404,
            $this->response->status()
        );
    }


    public function testGet()
    {
        $this->get('/balance?account_id=100');

        $this->assertEquals(
            '20',
            $this->response->getContent()
        );

        $this->assertEquals(
            200,
            $this->response->status()
        );
    }
}
