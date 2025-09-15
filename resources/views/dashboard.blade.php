<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight flex items-center gap-2">
            📊 {{ __('Dashboard Analytics') }}
        </h2>
    </x-slot>

    {{-- Filter Section --}}
    <form method="GET" action="{{ route('dashboard') }}" 
          class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 flex flex-col md:flex-row md:items-center gap-3 bg-white p-4 rounded-xl shadow-sm">
        <select name="sort_by" 
            class="w-full md:w-1/3 border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Sort by Date</option>
            <option value="7_days" {{ request('sort_by') == '7_days' ? 'selected' : '' }}>Last 7 days</option>
            <option value="1_month" {{ request('sort_by') == '1_month' ? 'selected' : '' }}>Last Month</option>
        </select>
        <div class="flex gap-3">
            <button type="submit" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow-md transition">
                Apply
            </button>
            @if(request()->has('sort_by'))
                <a href="{{ route('dashboard') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow-md transition">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Charts Section --}}
    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        
        {{-- Likes Chart --}}
        <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">❤️ Top 5 Most Liked Posts</h3>
            <div id="likesContainer" class="h-80"></div>
        </div>

        {{-- Views Chart --}}
        <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-2xl transition">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">👁️ Top 5 Most Viewed Posts</h3>
            <div id="viewsContainer" class="h-80"></div>
        </div>

        {{-- Comments Chart --}}
        <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 hover:shadow-2xl transition md:col-span-2">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">💬 Top 5 Most Commented Posts</h3>
            <div id="commentsContainer" class="h-96"></div>
        </div>
    </div>

    {{-- Highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        // Likes Chart
        Highcharts.chart('likesContainer', {
            chart: { type: 'column', backgroundColor: 'transparent' },
            title: { text: null },
            xAxis: { categories: @json($like_labels), title: { text: 'Posts' } },
            yAxis: { min: 0, title: { text: 'Likes Count' } },
            tooltip: { shared: true, valueSuffix: ' ❤️' },
            plotOptions: { column: { borderRadius: 6, dataLabels: { enabled: true } } },
            series: [{
                name: 'Likes',
                data: @json($like_data),
                color: '#FF6B6B'
            }]
        });

        // Views Chart
        Highcharts.chart('viewsContainer', {
            chart: { type: 'bar', backgroundColor: 'transparent' },
            title: { text: null },
            xAxis: { categories: @json($labels), title: { text: 'Posts' } },
            yAxis: { min: 0, title: { text: 'Views' } },
            tooltip: { shared: true, valueSuffix: ' 👁️' },
            plotOptions: { bar: { borderRadius: 6, dataLabels: { enabled: true } } },
            series: [{
                name: 'Views',
                data: @json($data),
                color: '#4F46E5'
            }]
        });

        // Comments Chart
        Highcharts.chart('commentsContainer', {
            chart: { type: 'bar', backgroundColor: 'transparent' },
            title: { text: null },
            xAxis: { categories: @json($post_title), title: { text: 'Posts' } },
            yAxis: { min: 0, title: { text: 'Comments Count' } },
            tooltip: { shared: true, valueSuffix: ' 💬' },
            plotOptions: { bar: { borderRadius: 6, dataLabels: { enabled: true } } },
            series: [{
                name: 'Comments',
                data: @json($comments_count),
                color: '#F59E0B'
            }]
        });
    </script>
</x-app-layout>
