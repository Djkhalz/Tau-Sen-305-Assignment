<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fola\'s Blog') - Dark Mode Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#0f172a',
                            card: '#1e293b',
                            border: '#334155',
                            text: '#e2e8f0',
                            muted: '#94a3b8'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-bg text-dark-text">
    <!-- Navigation -->
    <nav class="bg-dark-card border-b border-dark-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white hover:text-purple-400 transition-colors">
                        <i class="fas fa-moon mr-2 text-purple-400"></i>Fola's Blog
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('blog.index') }}" class="text-dark-muted hover:text-white transition-colors">Blog</a>
                    
                    @auth
                        <span class="text-dark-muted">Welcome, {{ auth()->user()->name }}</span>
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                                <i class="fas fa-tachometer-alt mr-2"></i>Admin
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Success Messages -->
    @if (session('success'))
        <div class="bg-green-900 border border-green-700 text-green-300 px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Error Messages -->
    @if (session('error'))
        <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-card border-t border-dark-border text-dark-text py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Fola's Blog. Created by Fola. All rights reserved.</p>
                <div class="mt-4 flex justify-center space-x-4">
                    <a href="#" class="text-dark-muted hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-dark-muted hover:text-white transition-colors">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="text-dark-muted hover:text-white transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
                <p>&copy; {{ date('Y') }} Blog System. Created by Fola. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
