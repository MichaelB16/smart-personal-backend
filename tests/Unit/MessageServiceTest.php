<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class MessageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $messageMock;
    protected $messageService;

    public function setUp(): void
    {
        parent::setUp();
        $this->messageMock = Mockery::mock(Message::class);
        $this->messageService = new MessageService($this->messageMock);
    }

    public function testAll()
    {
        $expectedMessage = new Message(['message_pre_class' => 'class1', 'message_pre_expiry' => '2023-12-31']);

        $this->messageMock->shouldReceive('select')
            ->once()
            ->with(['message_pre_class', 'message_pre_expiry'])
            ->andReturnSelf();

        $this->messageMock->shouldReceive('first')
            ->once()
            ->andReturn($expectedMessage);

        $result = $this->messageService->all();

        $this->assertEquals($expectedMessage, $result);
    }

    public function testCreateOrUpdateMessage()
    {
        $data = ['message_pre_class' => 'class1', 'message_pre_expiry' => '2023-12-31'];
        $expectedMessage = new Message($data + ['user_id' => 1]);

        // Use Laravel's facade mocking
        Auth::shouldReceive('guard')->with('sanctum')->andReturnSelf();
        Auth::shouldReceive('user')->andReturn((object)['id' => 1]);

        $this->messageMock->shouldReceive('updateOrCreate')
            ->once()
            ->with(
                ['user_id' => 1],
                $data
            )
            ->andReturn($expectedMessage);

        $result = $this->messageService->createOrUpdateMessage($data);

        $this->assertEquals($expectedMessage, $result);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}