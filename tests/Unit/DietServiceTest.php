<?php

namespace Tests\Unit;

use App\Enums\TYPE_FORMAT;
use App\Models\Diet;
use App\Services\DietService;
use App\Services\GeminiAiService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class DietServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $dietMock;
    protected $geminiAiServiceMock;
    protected $dietService;

    public function setUp(): void
    {
        parent::setUp();
        $this->dietMock = Mockery::mock(Diet::class);
        $this->geminiAiServiceMock = Mockery::mock(GeminiAiService::class);
        $this->dietService = new DietService($this->dietMock, $this->geminiAiServiceMock);
    }

    public function testGetDiet()

    {

        $studentId = 1;

        $expectedDiet = new Diet(['id' => 1, 'diet' => 'test diet', 'student_id' => $studentId]);

        $queryBuilder = Mockery::mock(Builder::class);

        $this->dietMock->shouldReceive('join')

            ->once()

            ->with('students', Mockery::type('Closure'))

            ->andReturn($queryBuilder);

        $queryBuilder->shouldReceive('with')

            ->once()

            ->with(['user'])

            ->andReturn($queryBuilder);

        $queryBuilder->shouldReceive('where')

            ->once()

            ->with(['student_id' => $studentId])

            ->andReturn($queryBuilder);

        $queryBuilder->shouldReceive('select')

            ->once()

            ->with('diet.*', 'students.name as student_name')

            ->andReturn($queryBuilder);

        $queryBuilder->shouldReceive('first')

            ->once()

            ->andReturn($expectedDiet);

        $result = $this->dietService->getDiet($studentId);

        $this->assertEquals($expectedDiet, $result);
    }

    public function testGenerate()
    {
        $data = [
            'objective' => 'lose weight',
            'sex' => 'male',
            'price' => '500',
            'restriction' => 'lactose'
        ];

        $expectedResponse = ['day' => 'Monday', 'meals' => ['breakfast', 'lunch']];

        $this->geminiAiServiceMock->shouldReceive('sendMessage')
            ->once()
            ->with(Mockery::any(), TYPE_FORMAT::JSON->value)
            ->andReturn($expectedResponse);

        $result = $this->dietService->generate($data);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGenerateWithoutRestriction()
    {
        $data = [
            'objective' => 'gain muscle',
            'sex' => 'female',
            'price' => '700',
            'restriction' => ''
        ];

        $expectedResponse = ['day' => 'Tuesday', 'meals' => ['breakfast', 'lunch']];

        // Use Mockery::any() for the prompt parameter to avoid string matching issues
        $this->geminiAiServiceMock->shouldReceive('sendMessage')
            ->once()
            ->with(Mockery::any(), TYPE_FORMAT::JSON->value)
            ->andReturn($expectedResponse);

        $result = $this->dietService->generate($data);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testCreateDiet()
    {
        $data = [
            'student_id' => 1,
            'diet' => json_encode(['day' => 'Monday', 'meals' => ['breakfast', 'lunch']])
        ];

        $expectedDiet = new Diet([
            'diet' => $data['diet'],
            'student_id' => $data['student_id'],
            'user_id' => 1
        ]);

        // Use Laravel's facade mocking
        Auth::shouldReceive('guard')->with('sanctum')->andReturnSelf();
        Auth::shouldReceive('user')->andReturn((object)['id' => 1]);

        $this->dietMock->shouldReceive('updateOrCreate')
            ->once()
            ->with(
                ['student_id' => $data['student_id']],
                [
                    'diet' => $data['diet'],
                    'student_id' => $data['student_id'],
                    'user_id' => 1,
                ]
            )
            ->andReturn($expectedDiet);

        $result = $this->dietService->createDiet($data);

        $this->assertEquals($expectedDiet, $result);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
