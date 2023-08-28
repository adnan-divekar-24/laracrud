<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index() {
        $employees = Employee::orderBy('id','DESC')->get();
        return view('employees.list', ['employees' => $employees]);
    }
    public function create() {
        return view('employees.create');
    }
    public function store(Request $request) {
       
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'image'=>'sometimes|image:gif,png,jpeg,jpg',
        ]);

        if( $validator->passes() ){
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();
            if($request->image){

                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().'.'.$ext;
                $request->image->move(public_path().'uploads/employees/',$newFileName);
                $employee->image = $newFileName;
                $employee->save();    
            }

            $request->session()->flash('Success','Employee has been added successfully');
            return redirect()->route('employees.index');
        }else{
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }
    }
}
