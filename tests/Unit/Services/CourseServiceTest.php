<?php

use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{
    protected $courseMock;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->courseMock = Mockery::mock(Course::class);
        $this->service = new CourseService($this->courseMock);
    }

    public function test_get_all_courses()
    {
        $courses = collect([
            new Course(['id' => 1, 'name' => 'Mathematics', 'code' => 'MATH101', 'department_id' => 1, 'fees' => 1000, 'duration' => 1, 'description' => 'Basic Mathematics']),
            new Course(['id' => 2, 'name' => 'Physics', 'code' => 'PHYS101', 'department_id' => 2, 'fees' => 1200, 'duration' => 1, 'description' => 'Introductory Physics']),
        ]);

        $this->courseMock->shouldReceive('select')->with(['id', 'name', 'code', 'department_id', 'fees', 'duration', 'description'])->andReturnSelf();
        $this->courseMock->shouldReceive('with')->once()->with('department:id,name')->andReturnSelf();
        $this->courseMock->shouldReceive('get')->andReturn($courses);

        $result = $this->service->getAllCourses();
        $this->assertCount(2, $result);
        $this->assertEquals('Mathematics', $result[0]->name);
        $this->assertEquals('Physics', $result[1]->name);
    }

    public function test_get_all_courses_empty()
    {
        $this->courseMock->shouldReceive('select')->with(['id', 'name', 'code', 'department_id', 'fees', 'duration', 'description'])->andReturnSelf();
        $this->courseMock->shouldReceive('with')->once()->with('department:id,name')->andReturnSelf();
        $this->courseMock->shouldReceive('get')->andReturn(collect());

        $result = $this->service->getAllCourses();

        $this->assertCount(0, $result);
    }

    public function test_create_course_success()
    {
        $data = [
            'name' => 'Finance',
            'code' => 'FIN01',
            'duration' => 1,
            'department_id' => 1,
            'fees' => 1000,
            'description' => 'Finance Course',
        ];

        $this->courseMock->shouldReceive('newInstance')->andReturn($this->courseMock);
        $this->courseMock->shouldReceive('setAttribute')->atLeast()->once();
        $this->courseMock->shouldReceive('save')->once()->andReturn(true);

        $this->courseMock->shouldReceive('getAttribute')->with('code')->andReturn($data['code']);
        $this->courseMock->shouldReceive('getAttribute')->with('name')->andReturn($data['name']);

        $result = $this->service->createCourse($data);
        $this->assertEquals('FIN01', $result->code);
        $this->assertEquals('Finance', $result->name);
    }

    public function test_create_course_duplicate_code()
    {
        $data = [
            'name' => 'Finance',
            'code' => 'FIN01',
            'duration' => 1,
            'department_id' => 1,
            'fees' => 1000,
            'description' => 'Finance Course',
        ];

        $this->courseMock->shouldReceive('newInstance')->andReturn($this->courseMock);
        $this->courseMock->shouldReceive('setAttribute')->atLeast()->once();
        $this->courseMock->shouldReceive('save')->once()->andThrow(new QueryException('pgsql', '', [], new \Exception('Duplicate entry')));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Course code already exists.');

        $this->service->createCourse($data);
    }

    public function test_update_course_not_found()
    {
        $this->courseMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andThrow(new ModelNotFoundException());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Course not found.');

        $this->service->updateCourse(1, []);
    }

    public function test_update_course_with_partial_data()
    {
        $course = new Course([
            'name' => 'Finance',
            'code' => 'FIN01',
            'duration' => 1,
            'department_id' => 1,
            'fees' => 1000,
            'description' => 'Finance Course',
        ]);

        $course = Mockery::mock($course)->makePartial();

        $this->courseMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(12)
            ->andReturn($course);

        $course
            ->shouldReceive('update')
            ->once()
            ->with([
                'name' => 'Updated Finance',
            ])
            ->andReturnUsing(function ($data) use ($course) {
                $course->fill($data); // simulate Eloquent update
                return true;
            });

        $result = $this->service->updateCourse(12, [
            'name' => 'Updated Finance',
        ]);

        $this->assertEquals('Updated Finance', $result->name);
        $this->assertEquals('FIN01', $result->code);
        $this->assertEquals('Finance Course', $result->description);
    }
    public function test_delete_course_successfully()
    {
        $course = Mockery::mock(Course::class);

        $this->courseMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andReturn($course);

        $course
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $this->service->deleteCourse(1);

        $this->assertTrue(true); // no exception means success
    }
    public function test_delete_course_not_found()
    {
        $this->courseMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andThrow(new ModelNotFoundException());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Course not found.');

        $this->service->deleteCourse(1);
    }
    public function test_delete_course_with_assigned_records()
    {
        $course = Mockery::mock(Course::class);

        $this->courseMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andReturn($course);

        $queryException = new QueryException(
            'pgsql',
            'Foreign key violation',
            ['23503'],
            new \Exception('Foreign key violation')
        );

        $course
            ->shouldReceive('delete')
            ->once()
            ->andThrow($queryException);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            'Cannot delete this course because it has assigned records.'
        );

        $this->service->deleteCourse(1);
    }
}
