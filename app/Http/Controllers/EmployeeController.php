<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Requests\Employee\EmployeeCreateRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;

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
    public function store(EmployeeCreateRequest $request): RedirectResponse
    {   

        $data = $request->validated();

        if($request->hasfile('image') && $request->file('image')->isValid()) {

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('img/employee/'), $imageName);
            $data['image'] = $imageName;

            /*$requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $request->image->move(public_path('img/employee'), $imageName);*/
        } else {
            $data['image'] = "Foto_Desconhecido.jpg";
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
    public function update(EmployeeUpdateRequest $request, $id): RedirectResponse
    {
        $data = $request->validated();

        if ($request->has('image')) 
        {
            //Check old image
            $destination = "img/employee/" . $request->image;

            //remove old images
            if(\File::exists($destination)) {
                \File::delete($destination);
            };
            //Add new image
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            //Update new image
            $request->image->move(public_path('img/employee/'), $imageName);
            $data['image'] = $imageName;

        };

        $employee = Employee::find($id);
        $input = $employee->update($data);
        if ($input) {
            session()->flash('flash_message', 'Funcionário Atualizado com Sucesso');
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
        $data = Employee::find($id);
        if($data->image) 
        {
            $destination = public_path('img/employee/'.$data->image);

            if(file_exists($destination && $destination =! public_path('img/employee/Foto_Desconhecido.jpg'))) 
            {
                unlink($destination);
            }; 
        };
        Employee::destroy($id);
        return redirect('employee')->with('flash_message', 'Employee Deleted!');
    }
}
