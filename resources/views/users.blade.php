<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Users List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="p-4">

    <h1 class="mb-4">Users List</h1>

    <form method="GET" action="" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search by name or email"
            value="{{ $search ?? '' }}">
    </form>

    <table class="table table-bordered" id="usersTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="name">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ url('/users/' . $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')"
                                class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // function searchTable() {
        //     const input = document.getElementById('searchInput').value.toLowerCase();
        //     const rows = document.querySelectorAll('#usersTable tbody tr');

        //     rows.forEach(row => {
        //         const name = row.querySelector('.name').textContent.toLowerCase();
        //         if (name.includes(input)) {
        //             row.style.display = '';
        //         } else {
        //             row.style.display = 'none';
        //         }
        //     });
        // }
        // 
    </script>

</body>

</html>
