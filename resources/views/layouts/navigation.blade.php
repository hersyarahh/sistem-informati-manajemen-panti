<nav x-data="{ open:false }" class="bg-white shadow fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        
        <!-- Logo -->
        <a href="/" class="text-2xl font-bold text-blue-700">
            PSTW Husnul Khotimah
        </a>

        <!-- Menu Desktop -->
        <div class="hidden md:flex space-x-8 font-medium">
            <a href="/" class="hover:text-blue-600">Home</a>
            <a href="/tentang" class="hover:text-blue-600">Tentang Kami</a>
            <a href="/galeri" class="hover:text-blue-600">Galeri</a>
        </div>

        <!-- Login Button -->
        <div class="hidden md:block">
            <a href="{{ route('login') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Login Admin
            </a>
        </div>

        <!-- Hamburger -->
        <button @click="open = !open" class="md:hidden text-gray-700">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{ 'hidden':open }" class="block" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{ 'hidden':!open }" class="hidden" stroke-width="2" d="M6 6l12 12M6 18L18 6"/>
            </svg>
        </button>
    </div>

    <!-- Menu Mobile -->
    <div x-show="open" class="md:hidden bg-white shadow px-6 pb-4 space-y-3">
        <a href="/" class="block py-2">Home</a>
        <a href="/tentang" class="block py-2">Tentang Kami</a>
        <a href="/galeri" class="block py-2">Galeri</a>

        <a href="{{ route('login') }}" 
           class="block bg-blue-600 text-white text-center py-2 rounded">
            Login Admin
        </a>
    </div>
</nav>
