<?php

namespace Tests\Unit;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Mockery;
use Tests\TestCase;

class DepartmentServiceTest extends TestCase
{
    protected $departmentMock;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->departmentMock = Mockery::mock(Department::class);
        $this->service = new DepartmentService($this->departmentMock);
    }

    /**
     * Helper to mock validation success
     */
    protected function mockFormRequestSuccess(array $data)
    {

        $this->mock(StoreDepartmentRequest::class, function ($mock) use ($data) {

            $mock->shouldReceive('validateResolved')->andReturn(true);

            $mock->shouldReceive('validated')->andReturn($data);

            $mock->shouldReceive('all')->andReturn($data);
        });
    }

    public function test_create_department_success()
    {
        $data = ['name' => 'IT', 'code' => 'IT01', 'description' => 'Tech Dept'];
        $this->mockFormRequestSuccess($data);

        $instanceMock = Mockery::mock(Department::class);
        $this->departmentMock->shouldReceive('newInstance')->once()->andReturn($instanceMock);

        $instanceMock->shouldReceive('setAttribute')->atLeast()->once();
        $instanceMock->shouldReceive('save')->once()->andReturn(true);

        $result = $this->service->createDepartment($data);
        $this->assertInstanceOf(Department::class, $result);
    }

    public function test_create_department_validation_fails()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Department code already exists.');

        $departmentMock = Mockery::mock(Department::class);

        $this->departmentMock->shouldReceive('newInstance')->once()->andReturn($departmentMock);

        $departmentMock->shouldReceive('setAttribute')->andReturn(null); // Handles $model->name = ...

        $departmentMock->shouldReceive('save')
            ->once()
            ->andThrow(new QueryException('pgsql', 'insert into...', [], new Exception('Duplicate entry')
            ));

        $this->service->createDepartment([
            'name' => 'IT',
            'code' => 'IT01',
            'description' => 'Test',
        ]);
    }

    public function test_update_department_success()
    {
        $data = ['name' => 'IT Updated', 'code' => 'IT02', 'description' => 'Updated Dept'];
        $this->mockFormRequestSuccess($data);

        $existingDept = Mockery::mock(Department::class);
        $this->departmentMock->shouldReceive('findOrFail')->with(1)->andReturn($existingDept);

        $existingDept->shouldReceive('setAttribute')->atLeast()->once();
        $existingDept->shouldReceive('save')->once()->andReturn(true);

        $result = $this->service->updateDepartment(1, $data);
        $this->assertInstanceOf(Department::class, $result);
    }

    public function test_update_department_not_found()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Department not found.');

        $data = ['name' => 'IT', 'code' => 'IT01', 'description' => 'Desc'];
        $this->mockFormRequestSuccess($data);

        $this->departmentMock->shouldReceive('findOrFail')
            ->with(99)
            ->andThrow(new ModelNotFoundException);

        $this->service->updateDepartment(99, $data);
    }

    public function test_delete_department_success()
    {
        $existingDept = Mockery::mock(Department::class);
        $this->departmentMock->shouldReceive('findOrFail')->with(1)->andReturn($existingDept);
        $existingDept->shouldReceive('delete')->once()->andReturn(true);

        $result = $this->service->deleteDepartment(1);
        $this->assertTrue($result);
    }

    public function test_delete_department_database_constraint_error()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cannot delete this department because it is in use.');

        $existingDept = Mockery::mock(Department::class);
        $this->departmentMock->shouldReceive('findOrFail')->with(1)->andReturn($existingDept);

        $queryException = new QueryException('sql', 'delete...', [], new Exception);
        $existingDept->shouldReceive('delete')->andThrow($queryException);

        $this->service->deleteDepartment(1);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
