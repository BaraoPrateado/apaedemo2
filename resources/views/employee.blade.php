<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row" style="margin:20px">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                            {{ __('Employees CRUD') }}
                        </h2>
                    </div>

                    <div class="card-body">
                        <a href="{{ route('employee.create') }}" class="btn btn-success btn-sm"
                            title="Add New Employee">
                            {{ __('Add New') }}
                        </a>
                        <br>
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Image')}}</th>
                                        <th>{{ __('Name')}}</th>
                                        <th>CPF</th>
                                        <th>{{ __('Address')}}</th>
                                        <th>{{ __('Actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($employees->count() > 0)
                                        @foreach ($employees as $employee)
                                            <tr class="align-middle">
                                                <td>{{ $loop->iteration }}</td>
                                                <td> <img style="width:50px; height:50px" class="rounded-circle" src="{{ asset('img/employee/' . $employee->image) }}" alt="{{ __('Image not loaded') }}"> </td>
                                                <td>{{ $employee->name }}</td>
                                                <td>{{ $employee->cpf }}</td>
                                                <td>{{ $employee->address }}</td>

                                                <td>
                                                    <a href="{{ route('employee.edit', ['employee' => $employee->id]) }}"
                                                        title="Edit Employee">
                                                        <button class="btn btn-warning btn-sm">
                                                            {{ __('Edit') }}
                                                        </button>
                                                    </a>

                                                    <form method="POST"
                                                        action="{{ route('employee.destroy', ['employee' => $employee->id]) }}"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Employee"
                                                            onclick="return confirm('{{ __('Confirm delete?') }}')">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="5">{{ __('Employees not found!') }}</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>