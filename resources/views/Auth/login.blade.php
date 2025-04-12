<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Login</h2>
        <form class="mt-4" 
        action="{{ route('authProccess') }}"
        method="POST">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Email" required>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Password" required>
            </div>
            <button type="submit" class="w-full px-4 py-2 mt-6 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Login</button>
        </form>
    </div>
    
    <script src="{{ asset('assets/libs/sweetalert/sweetalert.js') }}"></script>
    <script>
        @if ($message = Session::get('success'))
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "{{ $message }}"
            });
        @endif
        @if ($message = Session::get('error'))
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "{{ $message }}"
            });
        @endif
    </script>
</body>
</html>
