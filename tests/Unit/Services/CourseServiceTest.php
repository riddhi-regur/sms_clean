<?php

use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_all_courses_success()
    {
        $mock = Mockery::mock('alias:'.Course::class);

        $mock->shouldReceive('select')->once()->andReturnSelf();
        $mock->shouldReceive('with')->once()->andReturnSelf();
        $mock->shouldReceive('get')->once()->andReturn(collect([]));

        $service = new CourseService;

        $result = $service->getAllCourses();

        $this->assertIsIterable($result);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_create_course_success()
    {
        $data = [
            'name' => 'BCA',
            'code' => 'BCA01',
            'duration' => '3 years',
            'department_id' => 1,
            'description' => 'Tech Dept',
            'fees' => 50000,
        ];

        $mock = Mockery::mock('overload:'.Course::class)->makePartial();
        $mock->shouldReceive('save')->once()->andReturn(true);

        $service = new CourseService;

        $result = $service->createCourse($data);

        $this->assertInstanceOf(Course::class, $result);
    }

    // public function test_create_course_duplicate_code()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Course code already exists.');

    //     $data = [
    //         'name' => 'BCA',
    //         'code' => 'BCA01',
    //         'duration' => '3 years',
    //         'department_id' => 1,
    //     ];

    //     $mock = Mockery::mock('overload:'.Course::class);
    //     $mock->shouldReceive('save')
    //         ->andThrow(new QueryException('pgsql', 'insert into courses...', [], new Exception));

    //     $service = new CourseService;

    //     $service->createCourse($data);
    // }

    // public function test_create_course_invalid_department()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Invalid department selected.');

    //     $mock = Mockery::mock('overload:'.Course::class);
    //     $mock->shouldReceive('save')
    //         ->andThrow(new QueryException('pgsql', 'insert into courses...', [], new Exception('', 23503)));

    //     $service = new CourseService;

    //     $service->createCourse([
    //         'name' => 'BCA',
    //         'code' => 'BCA01',
    //         'duration' => '3 years',
    //         'department_id' => 999,
    //     ]);
    // }

    // public function test_update_course_success()
    // {
    //     $courseMock = Mockery::mock();
    //     $courseMock->shouldReceive('update')->once()->andReturn(true);

    //     $mock = Mockery::mock('alias:'.Course::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->once()
    //         ->andReturn($courseMock);

    //     $service = new CourseService;

    //     $result = $service->updateCourse(1, ['name' => 'Updated']);

    //     $this->assertEquals($courseMock, $result);
    // }

    // public function test_update_course_not_found()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Course not found.');

    //     $mock = Mockery::mock('alias:'.Course::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->andThrow(new ModelNotFoundException);

    //     $service = new CourseService;

    //     $service->updateCourse(1, []);
    // }

    // public function test_update_course_duplicate_code()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Course code already exists.');

    //     $courseMock = Mockery::mock();
    //     $courseMock->shouldReceive('update')
    //         ->andThrow(new QueryException('pgsql', 'update courses...', [], new Exception));

    //     $mock = Mockery::mock('alias:'.Course::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->andReturn($courseMock);

    //     $service = new CourseService;

    //     $service->updateCourse(1, ['code' => 'BCA01']);
    // }

    // public function test_delete_course_success()
    // {
    //     $courseMock = Mockery::mock();
    //     $courseMock->shouldReceive('delete')->once();

    //     $mock = Mockery::mock('alias:'.Course::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->once()
    //         ->andReturn($courseMock);

    //     $service = new CourseService;

    //     $service->deleteCourse(1);

    //     $this->assertTrue(true);
    // }

    // public function test_delete_course_not_found()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Course not found.');

    //     $mock = Mockery::mock('alias:'.Course::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->andThrow(new ModelNotFoundException);

    //     $service = new CourseService;

    //     $service->deleteCourse(1);
    // }

    // public function test_delete_course_with_dependency()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Cannot delete this course because it has assigned records.');

    //     $courseMock = Mockery::mock();
    //     $courseMock->shouldReceive('delete')
    //         ->andThrow(new QueryException('pgsql', 'delete from courses...', [], new Exception));

    //     $mock = Mockery::mock('alias:'.Course::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->andReturn($courseMock);

    //     $service = new CourseService;

    //     $service->deleteCourse(1);
    // }
}
