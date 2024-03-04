<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIMPLE LARAVEL 8 CRUD</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">SIMPLE LARAVEL 8 CRUD</div>
        </div>
    </div>

    <div class="container ">
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Employees</div>
            <div>
                <a href="{{ route('employees.create')}}" class="btn btn-primary">Create</a>
            </div>
        </div>

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th width="30">ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th width="150">Action</th>
                    </tr>
                    @if($employees->isNotEmpty())
                    @foreach ($employees as $employee)
                    <tr>
                        <td width="30">{{$employee->id}}</td>
                        <td>
                            @if($employee->image !='' && file_exists(public_path().'/uploads/employees/'.$employee->image))
                            <img src="{{ asset('uploads/employees/' . $employee->image) }}" alt="Image" width="40" height="40" class="rounded-circle">
                            @else
                            <img src="{{ asset('uploads/employees/no-image.png') }}" alt="Image" width="40" height="40" class="rounded-circle">
                            @endif
                        </td>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->address}}</td>
                        <td>
                            <a href="{{ route('employees.edit', $employee->id) }}"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('employees.viewpdf', $employee->id) }}" target="_blank"><i class="fa fa-file"></i></a>
                            <a href="#" onclick="deleteEmployee({{ $employee->id }})"><i class="fa fa-trash"></i></a>
                            <form id="employee-edit-action-{{ $employee->id }}" action="{{ route( 'employees.destroy', $employee->id )}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6">No Record Found</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $employees->links() }}
        </div>

    </div> 

    
</body>
</html>
<script>
    function deleteEmployee(id) {
        if (confirm("Are you sure you want to delete?")) {
            document.getElementById('employee-edit-action-'+id).submit();
        }
    }
</script>