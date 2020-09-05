<?php
use Laravel\Lumen\Testing\DatabaseMigrations;

class EventTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreate()
    {
        $this->post('/event', ['type' => 'deposit', 'destination' => "100", 'amount' => 10])
             ->seeJsonEquals([
                'destination' => ['id' => '100', 'balance' => 10],
             ]);

        $this->assertEquals(
            201,
            $this->response->status()
        );
    }

    public function testDeposit()
    {
        $this->testCreate();
        $this->post('/event', ['type' => 'deposit', 'destination' => "100", 'amount' => 10])
             ->seeJsonEquals([
                'destination' => ['id' => '100', 'balance' => 20],
             ]);

        $this->assertEquals(
            201,
            $this->response->status()
        );
    }

    public function testWithdrawNotFound()
    {
        $this->post('/event', ['type' => 'withdraw', 'origin' => "200", 'amount' => 10]);

        $this->assertEquals(
            '0',
            $this->response->getContent()
        );

        $this->assertEquals(
            404,
            $this->response->status()
        );
    }

    public function testWithdraw()
    {
        $this->testDeposit();
        $this->post('/event', ['type' => 'withdraw', 'origin' => "100", 'amount' => 5])
             ->seeJsonEquals([
                'origin' => ['id' => '100', 'balance' => 15],
             ]);

        $this->assertEquals(
            201,
            $this->response->status()
        );
    }

    public function testTransfer()
    {
        $this->testWithdraw();
        $this->post('/event', ['type' => 'transfer', 'origin' => "100", 'amount' => 15, "destination" => "300"])
             ->seeJsonEquals([
                'origin' => ['id' => '100', 'balance' => 0],
                'destination' => ['id' => '300', 'balance' => 15],
             ]);

        $this->assertEquals(
            201,
            $this->response->status()
        );
    }

    public function testTransferNotFound()
    {
        $this->post('/event', ['type' => 'transfer', 'origin' => "200", 'amount' => 15, "destination" => "300"]);

        $this->assertEquals(
            '0',
            $this->response->getContent()
        );

        $this->assertEquals(
            404,
            $this->response->status()
        );
    }
}
