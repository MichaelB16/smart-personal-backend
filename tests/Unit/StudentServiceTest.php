<?php

namespace Tests\Unit;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Student;
use App\Services\Mails\SendEmailStudentCreatedService;
use App\Services\StudentService;
use Mockery;
use Tests\TestCase;
use Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\CreateUserTestHelper;

class StudentServiceTest extends TestCase
{
    use CreateUserTestHelper;
    use RefreshDatabase;

    protected $service;
    protected $faker;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $sendEmail = new SendEmailStudentCreatedService;
        $this->repository = Mockery::mock(StudentRepositoryInterface::class);
        $this->service = new StudentService($this->repository, $sendEmail);
        $this->faker = Faker\Factory::create();
    }

    public function test_create_student(): void
    {
        $user = $this->executeCreateUser();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => '123456',
            'height' => 1.80,
            'weight' => 80,
            'price' => 100,
            'date_of_birth' => $this->faker->date(),
            'access' => 1,
            'user_id' => $user->id,
        ];

        $this->repository
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($student) use ($data) {
                return $student['name'] === $data['name'] &&
                    $student['email'] === $data['email'] &&
                    $student['phone'] === $data['phone'] &&
                    $student['height'] === $data['height'] &&
                    $data['weight'] === $data['weight'] &&
                    $student['price'] === $data['price'] &&
                    $student['date_of_birth'] === $data['date_of_birth'] &&
                    $student['access'] === $data['access'] &&
                    $student['user_id'] === $data['user_id'];
            }))->andReturn(new Student($data));

        $result = $this->service->create($data);

        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['email'], $result->email);
        $this->assertEquals($data['phone'], $result->phone);
        $this->assertEquals($data['height'], $result->height);
        $this->assertEquals($data['weight'], $result->weight);
        $this->assertEquals($data['price'], $result->price);
        $this->assertEquals($data['date_of_birth'], $result->date_of_birth);
        $this->assertEquals($data['access'], $result->access);
        $this->assertEquals($data['user_id'], $result->user_id);
    }

    public function test_update_student(): void
    {
        $this->createStudent();

        $data = [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'weight' => 75,
            'price' => 250,
        ];

        $id = 1;

        $this->repository->shouldReceive('update')->once()->with($id, Mockery::on(function ($student) use ($data) {
            return  $student['name'] === $data['name'] &&
                $student['weight'] === $data['weight'] &&
                $student['price'] === $data['price'] &&
                $student['phone'] === $data['phone'];
        }))->andReturn(new Student(array_merge(['id' => 1], $data)));

        $result = $this->service->update($id, $data);

        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['phone'], $result->phone);
        $this->assertEquals($data['price'], $result->price);
        $this->assertEquals($data['weight'], $result->weight);
    }

    public function test_delete_student(): void
    {
        $this->createStudent();
        $id = 1;
        $this->repository->shouldReceive('delete')->once()->with($id)->andReturn(true);
        $this->service->delete($id);
        $this->assertTrue(true);
    }

    public function test_get_by_email_student(): void
    {
        $student = $this->createStudent();

        $this->repository
            ->shouldReceive('getByEmail')
            ->once()
            ->with($student->email)
            ->andReturn($student);

        $result = $this->service->getByEmail($student->email);

        $this->assertEquals($student->id, $result->id);
        $this->assertEquals($student->name, $result->name);
        $this->assertEquals($student->email, $result->email);
        $this->assertEquals($student->phone, $result->phone);
        $this->assertEquals($student->type, $result->type);
    }

    public function test_get_all_students(): void
    {
        $students = [];
        for ($i = 0; $i < 10; $i++) {
            $students[] = $this->createStudent();
        }
        $this->repository->shouldReceive('getAll')->once()->andReturn($students);
        $result = $this->service->getAll();
        $this->assertCount(count($students), $result);
    }

    public function test_find_student(): void
    {
        $student = $this->createStudent();

        $id = 1;

        $this->repository
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($student);

        $result = $this->service->find($id);

        $this->assertEquals($student->id, $result->id);
        $this->assertEquals($student->name, $result->name);
        $this->assertEquals($student->email, $result->email);
        $this->assertEquals($student->phone, $result->phone);
        $this->assertEquals($student->type, $result->type);
    }

    public function test_get_summary_student(): void
    {
        $this->repository
            ->shouldReceive('getSummary')
            ->once()
            ->andReturn([
                'total_students' => 1,
                'total_trainings' => 5,
                'total_diets' => 1,
                'total_price' => 100
            ]);

        $result = $this->service->getSummary();
        $this->assertEquals(1, $result['total_students']);
        $this->assertEquals(5, $result['total_trainings']);
        $this->assertEquals(1, $result['total_diets']);
        $this->assertEquals(100, $result['total_price']);
    }

    protected function createStudent()
    {
        $user = $this->executeCreateUser();

        return new Student([
            'id' => 1,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => '123456',
            'type' => 'student',
            'height' => 1.80,
            'weight' => 80,
            'price' => 100,
            'date_of_birth' => $this->faker->date(),
            'access' => 1,
            'user_id' => $user->id,
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
