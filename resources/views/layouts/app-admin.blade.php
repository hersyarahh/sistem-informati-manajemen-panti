<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body class="m-0 p-0 bg-gray-100">

    <div class="flex min-h-screen w-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-blue-700 text-white flex flex-col min-h-screen">

            <!-- TITLE -->
            <div class="px-5 py-6">
                <h2 class="text-xl font-bold mb-10">Menu Admin</h2>
            </div>

            <!-- NAV LINKS -->
            <nav class="flex flex-col space-y-4 px-5 flex-1">
                <a href="/admin/dashboard" class="hover:bg-blue-600 p-3 rounded">Dashboard</a>
                <a href="/admin/lansia" class="hover:bg-blue-600 p-3 rounded">Data Lansia</a>
                <a href="/admin/kegiatan" class="hover:bg-blue-600 p-3 rounded">Data Kegiatan</a>
                <a href="/admin/inventaris" class="hover:bg-blue-600 p-3 rounded">Inventaris</a>
                <a href="/admin/donasi" class="hover:bg-blue-600 p-3 rounded">Donasi</a>
            </nav>

            <!-- LOGOUT BUTTON -->
            <div class="px-5 pb-4"> 
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl text-center">
                        Logout
                    </button>
                </form>
            </div>

        </aside>


        <!-- MAIN CONTENT -->
        <main class="flex-1 h-screen overflow-auto px-8 py-8 flex items-start justify-center">
            <div class="w-full max-w-6xl flex flex-col gap-6">
                @yield('content')
            </div>
        </main>

    </div>

</body>

</html>
