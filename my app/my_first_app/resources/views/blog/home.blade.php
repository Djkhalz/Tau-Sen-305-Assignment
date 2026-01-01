@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="min-h-screen bg-dark-bg">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 opacity-90"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-purple-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                        <i class="fas fa-moon text-6xl text-purple-400 relative"></i>
                    </div>
                </div>
                <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6 animate-fade-in">
                    Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Fola's Blog</span>
                </h1>
                <p class="text-xl text-dark-muted mb-8 max-w-3xl mx-auto">
                    Explore the depths of knowledge in our dark mode sanctuary. Discover insights, tutorials, and stories that illuminate the path to understanding.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('blog.index') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-4 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        <i class="fas fa-book-open mr-2"></i>Explore Articles
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-purple-500 text-purple-400 px-8 py-4 rounded-lg font-semibold hover:bg-purple-500 hover:text-white transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-user mr-2"></i>Join Community
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Animated Background Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-purple-500 rounded-full blur-2xl opacity-20 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-pink-500 rounded-full blur-3xl opacity-20 animate-float-delayed"></div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-dark-card border border-dark-border rounded-lg p-6 text-center hover:border-purple-500 transition-colors">
                <i class="fas fa-newspaper text-3xl text-purple-400 mb-3"></i>
                <div class="text-2xl font-bold text-white">{{ $recentPosts->count() }}</div>
                <div class="text-dark-muted">Articles Published</div>
            </div>
            <div class="bg-dark-card border border-dark-border rounded-lg p-6 text-center hover:border-purple-500 transition-colors">
                <i class="fas fa-tags text-3xl text-pink-400 mb-3"></i>
                <div class="text-2xl font-bold text-white">{{ $categories->count() }}</div>
                <div class="text-dark-muted">Categories</div>
            </div>
            <div class="bg-dark-card border border-dark-border rounded-lg p-6 text-center hover:border-purple-500 transition-colors">
                <i class="fas fa-users text-3xl text-blue-400 mb-3"></i>
                <div class="text-2xl font-bold text-white">Growing</div>
                <div class="text-dark-muted">Community</div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-white">Latest Articles</h2>
            <a href="{{ route('blog.index') }}" class="text-purple-400 hover:text-purple-300 transition-colors">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($recentPosts as $post)
                <article class="bg-dark-card border border-dark-border rounded-lg overflow-hidden hover:border-purple-500 transition-all duration-300 transform hover:scale-105">
                    @if ($post->featured_image)
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-bg via-transparent to-transparent"></div>
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br from-purple-900 to-blue-900 flex items-center justify-center">
                            <i class="fas fa-image text-dark-muted text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            @foreach ($post->categories as $category)
                                <span class="bg-purple-900 text-purple-300 text-xs px-2 py-1 rounded-full mr-2">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                        
                        <h3 class="text-xl font-semibold mb-3">
                            <a href="{{ route('blog.show', $post) }}" class="text-white hover:text-purple-400 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h3>
                        
                        <p class="text-dark-muted mb-4">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                        
                        <div class="flex items-center justify-between text-sm text-dark-muted">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                {{ $post->user->name }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $post->published_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-inbox text-6xl text-dark-muted mb-4"></i>
                    <p class="text-dark-muted">No articles found. Start your journey with the first post!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Popular Posts & Categories -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Popular Posts -->
            <div class="bg-dark-card border border-dark-border rounded-lg p-6">
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-fire text-orange-400 mr-3"></i>
                    Trending Articles
                </h3>
                <div class="space-y-4">
                    @forelse ($popularPosts as $post)
                        <div class="border-b border-dark-border pb-4 last:border-b-0 hover:border-purple-500 transition-colors">
                            <h4 class="font-medium mb-2">
                                <a href="{{ route('blog.show', $post) }}" class="text-white hover:text-purple-400 transition-colors">
                                    {{ Str::limit($post->title, 60) }}
                                </a>
                            </h4>
                            <div class="flex items-center text-sm text-dark-muted">
                                <i class="fas fa-eye mr-2"></i>
                                {{ $post->views }} views
                                <span class="mx-2">•</span>
                                <i class="fas fa-heart mr-2"></i>
                                {{ rand(10, 100) }} likes
                            </div>
                        </div>
                    @empty
                        <p class="text-dark-muted">No trending articles yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-dark-card border border-dark-border rounded-lg p-6">
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-layer-group text-purple-400 mr-3"></i>
                    Explore Categories
                </h3>
                <div class="space-y-3">
                    @forelse ($categories as $category)
                        <a href="{{ route('blog.category', $category) }}" class="flex items-center justify-between p-3 rounded-lg bg-dark-bg hover:bg-purple-900 transition-colors group">
                            <span class="flex items-center">
                                <span class="w-3 h-3 rounded-full mr-3 bg-gradient-to-r from-purple-400 to-pink-400"></span>
                                <span class="text-white group-hover:text-purple-300">{{ $category->name }}</span>
                            </span>
                            <span class="text-sm text-dark-muted bg-dark-card px-2 py-1 rounded-full">{{ $category->published_posts_count }}</span>
                        </a>
                    @empty
                        <p class="text-dark-muted">No categories found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-30px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
}

.animate-fade-in {
    animation: fadeIn 1s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
