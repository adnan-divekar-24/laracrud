<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$employee['name']}}</title>
</head>

<body>
<table class="table" border="1" cellpadding = "0" cellspacing="0">
  <thead>
    <tr>
      <th scope="col col-lg-2">#</th>
      <th scope="col col-lg-2">Name</th>
      <th scope="col col-lg-2">Email</th>
      <th scope="col col-lg-2">Address</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>{{$employee['name']}}</td>
      <td>{{$employee['email']}}</td>
      <td>{{$employee['address']}}</td>
    </tr>
  </tbody>
</table>
</body>
</html>



