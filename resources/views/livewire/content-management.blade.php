<div class="max-w-10xl mx-auto p-6">
    <div class="relative rounded-2xl shadow-2xl backdrop-blur-xl bg-gradient-to-br from-white/95 to-gray-50/95 dark:from-gray-800/95 dark:to-gray-900/95 border border-gray-200/50 dark:border-gray-700/50 p-8">
        <!-- Decorative gradient overlay -->
        <div class="absolute inset-0 overflow-hidden rounded-2xl pointer-events-none -z-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-400/10 to-purple-400/10 dark:from-blue-500/20 dark:to-purple-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-emerald-400/10 to-teal-400/10 dark:from-emerald-500/20 dark:to-teal-500/20 rounded-full blur-3xl"></div>
        </div>

        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>

                <p class="mt-1 text-gray-500 dark:text-gray-400">Manage and oversee your platform's articles.</p>
            </div>

            <div class="flex gap-3">
                 <!-- Actions (Future: Add New, Export, etc) -->
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-inner flex flex-col">
             <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50/50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Author</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Views</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created At</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-transparent">
                        @forelse($articles as $article)
                            <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/20 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $article->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $article->slug }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xs">
                                            {{ substr($article->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $article->user->name ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ number_format($article->views) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $article->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button
                                        wire:click="delete({{ $article->id }})"
                                        wire:confirm="Are you sure you want to delete this article?"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                        <span class="text-lg font-medium">No articles found</span>
                                        <span class="text-sm">Create some articles to see them here.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
