<?php

namespace Tests\Unit;

use App\Models\Department;
use App\Services\DepartmentService;
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

    public function test_get_all_departments()
    {
        $departments = collect([
            new Department(['id' => 1, 'name' => 'HR', 'code' => 'HR01', 'description' => 'Human Resources']),
            new Department(['id' => 2, 'name' => 'IT', 'code' => 'IT01', 'description' => 'Information Technology']),
        ]);

        $this->departmentMock->shouldReceive('select')->with(['id', 'name', 'code', 'description'])->andReturnSelf();
        $this->departmentMock->shouldReceive('get')->andReturn($departments);

        $result = $this->service->getAllDepartments();
        $this->assertCount(2, $result);
        $this->assertEquals('HR', $result[0]->name);
        $this->assertEquals('IT', $result[1]->name);
    }

    public function test_get_all_departments_empty()
    {
        $this->departmentMock->shouldReceive('select')->with(['id', 'name', 'code', 'description'])->andReturnSelf();
        $this->departmentMock->shouldReceive('get')->andReturn(collect());

        $result = $this->service->getAllDepartments();
        $this->assertCount(0, $result);
    }

    public function test_create_department_success()
    {
        $data = [
            'name' => 'Finance',
            'code' => 'FIN01',
            'description' => 'Finance Department',
        ];

        $this->departmentMock->shouldReceive('newInstance')->andReturn($this->departmentMock);
        $this->departmentMock->shouldReceive('setAttribute')->atLeast()->once();
        $this->departmentMock->shouldReceive('save')->once()->andReturn(true);

        $this->departmentMock->shouldReceive('getAttribute')->with('code')->andReturn($data['code']);
        $this->departmentMock->shouldReceive('getAttribute')->with('name')->andReturn($data['name']);

        $result = $this->service->createDepartment($data);
        $this->assertEquals('FIN01', $result->code);
        $this->assertEquals('Finance', $result->name);
    }

    public function test_create_department_duplicate_code()
    {
        $data = [
            'name' => 'Finance',
            'code' => 'FIN01',
            'description' => 'Finance Department',
        ];

        $this->departmentMock->shouldReceive('newInstance')->andReturn($this->departmentMock);
        $this->departmentMock->shouldReceive('setAttribute')->atLeast()->once();
        $this->departmentMock->shouldReceive('save')->once()->andThrow(new QueryException('pgsql', '', [], new \Exception('Duplicate entry')));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Department code already exists.');

        $this->service->createDepartment($data);
    }

    public function test_update_department_not_found()
    {
        $this->departmentMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andThrow(new ModelNotFoundException());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Department not found.');

        $this->service->updateDepartment(1, []);
    }

    public function test_update_department_with_partial_data()
    {
        $department = new Department([
            'name' => 'Finance',
            'code' => 'FIN01',
            'description' => 'Finance Department',
        ]);

        $department = Mockery::mock($department)->makePartial();

        $this->departmentMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(12)
            ->andReturn($department);

        $department
            ->shouldReceive('save')
            ->once()
            ->andReturn(true);

        $result = $this->service->updateDepartment(12, [
            'name' => 'Updated Finance',
        ]);

        $this->assertEquals('Updated Finance', $result->name);
        $this->assertEquals('FIN01', $result->code);
        $this->assertEquals('Finance Department', $result->description);
    }

    public function test_delete_department_successfully()
    {
        $department = Mockery::mock(Department::class);

        $this->departmentMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andReturn($department);

        $department
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $result = $this->service->deleteDepartment(1);

        $this->assertTrue($result);
    }

    public function test_delete_department_not_found()
    {
        $this->departmentMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andThrow(new ModelNotFoundException());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Department not found.');

        $this->service->deleteDepartment(1);
    }
    public function test_delete_department_with_assigned_records()
    {
        $department = Mockery::mock(Department::class);

        $this->departmentMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with(1)
            ->andReturn($department);

        $queryException = new QueryException(
            'pgsql',
            'Foreign key violation',
            ['23503'],
            new \Exception('Foreign key violation')
        );

        $department
            ->shouldReceive('delete')
            ->once()
            ->andThrow($queryException);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            'Cannot delete this department because it has assigned records.'
        );

        $this->service->deleteDepartment(1);
    }
}
