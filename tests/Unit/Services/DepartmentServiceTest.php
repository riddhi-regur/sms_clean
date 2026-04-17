<?php

use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class DepartmentServiceTest extends TestCase
{
    public function test_create_department_success()
    {
        $data = [
            'name' => 'IT',
            'code' => 'IT01',
            'description' => 'Tech Dept',
        ];

        // Mock Department model
        $mock = Mockery::mock('overload:'.Department::class);
        $mock->shouldReceive('save')->once()->andReturn(true);

        $service = new DepartmentService;

        $result = $service->createDepartment($data);

        $this->assertInstanceOf(Department::class, $result);
    }

    // public function test_create_department_duplicate_code()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Department code already exists.');

    //     $data = [
    //         'name' => 'IT',
    //         'code' => 'IT01',
    //     ];

    //     $mock = Mockery::mock('overload:'.Department::class);
    //     $mock->shouldReceive('save')
    //         ->andThrow(new QueryException('', [], new Exception));

    //     $service = new DepartmentService;

    //     $service->createDepartment($data);
    // }

    // public function test_update_department_not_found()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Department not found.');

    //     $mock = Mockery::mock('alias:'.Department::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->andThrow(new ModelNotFoundException);

    //     $service = new DepartmentService;

    //     $service->updateDepartment(1, []);
    // }

    // public function test_delete_department_success()
    // {
    //     $departmentMock = Mockery::mock();
    //     $departmentMock->shouldReceive('delete')->once();

    //     $mock = Mockery::mock('alias:'.Department::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->andReturn($departmentMock);

    //     $service = new DepartmentService;

    //     $service->deleteDepartment(1);

    //     $this->assertTrue(true); // if no exception = pass
    // }

    // public function test_delete_department_with_courses()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Cannot delete this department because it has assigned courses.');

    //     $departmentMock = Mockery::mock();
    //     $departmentMock->shouldReceive('delete')
    //         ->andThrow(new QueryException('', [], new Exception));

    //     $mock = Mockery::mock('alias:'.Department::class);
    //     $mock->shouldReceive('findOrFail')
    //         ->andReturn($departmentMock);

    //     $service = new DepartmentService;

    //     $service->deleteDepartment(1);
    // }
}
