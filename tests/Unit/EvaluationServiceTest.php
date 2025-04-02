<?php

namespace Tests\Unit;

use App\Contracts\Repositories\EvaluationRepositoryInterface;
use App\Models\Evaluation;
use App\Services\EvaluationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Tests\Traits\CreateStudentTestHelper;
use Tests\Traits\CreateUserTestHelper;

class EvaluationServiceTest extends TestCase
{
    use CreateUserTestHelper;
    use CreateStudentTestHelper;

    use RefreshDatabase;

    protected $service;
    protected $repository;
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
        $this->repository = Mockery::mock(EvaluationRepositoryInterface::class);
        $this->service = new EvaluationService($this->repository);
    }

    public function teste_create_evaluation()
    {
        $user = $this->executeCreateUser();
        $student = $this->executeCreateStudent((int) $user->id);

        $data = [
            'user_id' => $user->id,
            'student_id' => $student->id,
            'height' => 1.75,
            'weight' => 80,
            'percent_weight' => 20,
            'arm' => 20,
            'leg' => 25,
            'waist' => 20,
            'breastplate' => 20,
            'observation' => 'test',
        ];

        $this->repository->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($evaluation) use ($data) {
                return $evaluation['user_id'] === $data['user_id'] &&
                    $evaluation['student_id'] === $data['student_id'] &&
                    $evaluation['height'] === $data['height'] &&
                    $evaluation['weight'] === $data['weight'] &&
                    $evaluation['percent_weight'] === $data['percent_weight'] &&
                    $evaluation['arm'] === $data['arm'] &&
                    $evaluation['leg'] === $data['leg'] &&
                    $evaluation['waist'] === $data['waist'] &&
                    $evaluation['breastplate'] === $data['breastplate'] &&
                    $evaluation['observation'] === $data['observation'];
            }))
            ->andReturn(new Evaluation($data));

        $result = $this->service->create($data);

        $this->assertEquals($data['user_id'], $result->user_id);
        $this->assertEquals($data['student_id'], $result->student_id);
        $this->assertEquals($data['height'], $result->height);
        $this->assertEquals($data['weight'], $result->weight);
        $this->assertEquals($data['percent_weight'], $result->percent_weight);
        $this->assertEquals($data['arm'], $result->arm);
        $this->assertEquals($data['leg'], $result->leg);
        $this->assertEquals($data['waist'], $result->waist);
        $this->assertEquals($data['breastplate'], $result->breastplate);
        $this->assertEquals($data['observation'], $result->observation);
    }

    public function test_update_evaluation()
    {
        $user = $this->executeCreateUser();
        $student = $this->executeCreateStudent((int) $user->id);

        $data = [
            'user_id' => $user->id,
            'student_id' => $student->id,
            'height' => 1.75,
            'weight' => 80,
            'percent_weight' => 20,
            'arm' => 20,
            'leg' => 25,
            'waist' => 20,
            'breastplate' => 20,
            'observation' => 'test',
        ];

        $this->repository->shouldReceive('update')
            ->once()
            ->with(1, Mockery::on(function ($evaluation) use ($data) {
                return $evaluation['user_id'] === $data['user_id'] &&
                    $evaluation['student_id'] === $data['student_id'] &&
                    $evaluation['height'] === $data['height'] &&
                    $evaluation['weight'] === $data['weight'] &&
                    $evaluation['percent_weight'] === $data['percent_weight'] &&
                    $evaluation['arm'] === $data['arm'] &&
                    $evaluation['leg'] === $data['leg'] &&
                    $evaluation['waist'] === $data['waist'] &&
                    $evaluation['breastplate'] === $data['breastplate'] &&
                    $evaluation['observation'] === $data['observation'];
            }))->andReturn(new Evaluation($data));

        $result = $this->service->update(1, $data);

        $this->assertEquals($data['user_id'], $result->user_id);
        $this->assertEquals($data['student_id'], $result->student_id);
        $this->assertEquals($data['height'], $result->height);
        $this->assertEquals($data['weight'], $result->weight);
        $this->assertEquals($data['percent_weight'], $result->percent_weight);
        $this->assertEquals($data['arm'], $result->arm);
        $this->assertEquals($data['leg'], $result->leg);
        $this->assertEquals($data['waist'], $result->waist);
        $this->assertEquals($data['breastplate'], $result->breastplate);
        $this->assertEquals($data['observation'], $result->observation);
    }
}
