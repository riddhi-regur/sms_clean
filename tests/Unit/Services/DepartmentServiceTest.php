<?php

namespace Tests\Unit;

use App\Models\Department;
use App\Services\DepartmentService;
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
    
}
