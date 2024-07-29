<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parameters</title>
</head>
<body>
    <div class="container">
        <h1>Parameters</h1>
        <form method="GET" action="/parameters">
            <input type="text" name="search" placeholder="Search by ID or Title" value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parameters as $parameter)
                    <tr>
                        <td>{{ $parameter->id }}</td>
                        <td>{{ $parameter->title }}</td>
                        <td>{{ $parameter->type }}</td>
                        <td>
                            @foreach($parameter->images as $image)
                                <div>
                                    <img src="{{ asset('storage/images/' . $image->filename) }}" alt="{{ $image->original_filename }}" width="50">
                                    <p>{{ $image->type }}: {{ $image->original_filename }}</p>
                                    <form action="{{ route('parameters.delete-image', $image->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ route('parameters.upload-images', $parameter->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="icon">
                                <input type="file" name="icon_gray">
                                <button type="submit">Upload</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
