<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Employee;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employee', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nome = 'Employee';
        return view('crudEmployee.employee-create', compact('nome'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:255', 'unique:'.Employee::class],
            'address' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg,webp', 'max:10240' ]
        ]);

        if($request->hasfile('image') && $request->file('image')->isValid()) {

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('img/employee'), $imageName);
            $data['image'] = $imageName;

            /*$requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $request->image->move(public_path('img/employee'), $imageName);*/
        };

        $input = Employee::create($data);
        if ($input) {
            session()->flash('flash_message', 'Funcionário Adicionado com Sucesso');
            return redirect(route('employee.index'));
        } else {
            session()->flash('error', 'Ocorreu algum problema');
            return redirect(route('employee.create'));
        }
    }

    /**
     * Display the specified resource.
     */
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $nome = 'Employee';

        $employee = Employee::find($id);
        return view('crudEmployee.employee-edit', compact(['employee', 'nome',]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validation = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg,webp', 'max:10240'],
        ]);

        if ($request->has('image')) {

            $destination = "img/employee/" . $employee->image
        };

        $employee = Employee::find($id);
        $input = $employee->update($validation);
        if ($input) {
            session()->flash('flash_message', 'Funcionário Adicionado com Sucesso');
            return redirect(route('employee.index'));
        } else {
            session()->flash('error', 'Ocorreu algum problema');
            return redirect(route('employee.edit'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Employee::destroy($id);
        return redirect('employee')->with('flash_message', 'Employee Deleted!');
    }
}
