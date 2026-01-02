<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users Data Import</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Upload Box */
        .upload-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f9fafb;
            padding: 15px;
            border: 1px dashed #ccc;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .upload-box input[type="file"] {
            flex: 1;
            padding: 6px;
        }

        .upload-box button {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .upload-box button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
        }

        .success {
            color: #16a34a;
        }

        .error {
            color: #dc2626;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background: #111827;
            color: #fff;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
        }

        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        table tbody tr:hover {
            background: #eef2ff;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 6px 10px;
            margin-right: 4px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
        }

        .pagination .active span {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📥 Bulk Users Upload (Excel / CSV)</h2>

    <!-- Upload Form -->
    <form id="uploadForm" class="upload-box">
        <input type="file" name="file" id="fileInput" accept=".xlsx,.csv" required>
        <button type="submit" id="uploadBtn">Upload</button>
    </form>

    <div id="msg" class="message"></div>

    <!-- Users Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->created_at?->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No data found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>

<script>
document.getElementById('uploadForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let fileInput = document.getElementById('fileInput');
    let msg = document.getElementById('msg');
    let btn = document.getElementById('uploadBtn');

    if (!fileInput.files.length) {
        msg.innerHTML = '<span class="error">Please select a file.</span>';
        return;
    }

    let formData = new FormData();
    formData.append('file', fileInput.files[0]);

    btn.disabled = true;
    msg.innerHTML = '⏳ Uploading & processing... please wait';

    fetch('/users/upload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;

        if (data.status) {
            msg.innerHTML = '<span class="success">' + data.message + '</span>';
            fileInput.value = '';
        } else {
            msg.innerHTML = '<span class="error">' + (data.message || 'Upload failed') + '</span>';
        }
    })
    .catch(err => {
        btn.disabled = false;
        msg.innerHTML = '<span class="error">Something went wrong.</span>';
        console.error(err);
    });
});
</script>

</body>
</html>
