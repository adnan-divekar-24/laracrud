<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    public function index() {
        $employees = Employee::orderBy('id','DESC')->paginate(5);
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
                $request->image->move(public_path().'/uploads/employees/',$newFileName);
                $employee->image = $newFileName;
                $employee->save();    
            }

            // $request->session()->flash('Success','Employee has been added successfully');
            return redirect()->route('employees.index')->with('Success','Employee has been added successfully');
        }else{
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }
    }
    public function edit($id) {
        $employee = Employee::findOrFail($id);
        
        return view('employees.edit',['employee' => $employee ]);
    }

    public function update($id,Request $request) {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'image'=>'sometimes|image:gif,png,jpeg,jpg',
        ]);

        if( $validator->passes() ){
            $employee = Employee::find($id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();

            if($request->image){
                $oldImage = $employee->image;
                
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().'.'.$ext;
                $request->image->move(public_path().'/uploads/employees/',$newFileName);
                $employee->image = $newFileName;
                $employee->save();  
                
                File::delete(public_path().'/uploads/employees/',$oldImage);
                
            }

            // $request->session()->flash('Success','Employee has been updated successfully');
            return redirect()->route('employees.index')->with('Success','Employee has been updated successfully');
        }else{
            return redirect()->route('employees.edit',$id)->withErrors($validator)->withInput();
        }
    }

    public function destroy($id,Request $request) {
        $employee = Employee::findOrFail($id);
        // dd($employee);
        // dd($employee->image);
        // die;
        File::delete(public_path().'/uploads/employees/'.$employee->image);
        $employee->delete();
        // $request->session()->flash('Success','Employee deleted Successfully');
        return redirect()->route('employees.index',$id)->with('Success','Employee deleted Successfully');

    }

}
