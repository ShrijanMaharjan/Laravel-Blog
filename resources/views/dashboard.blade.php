<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
   <form method="GET" action="{{ route('dashboard') }} "class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-6 grid grid-cols-1 md:grid-cols-3 gap-3">
    <select name="sort_by" class="border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">Sort by Date</option>
        <option value="7_days" {{ request('sort_by') == '7_days' ? 'selected' : '' }}>Last 7 days</option>
        <option value="1_month" {{ request('sort_by') == '1_month' ? 'selected' : '' }}>Last Month</option>
    </select>
    <button type="submit" 
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
        Apply
    </button>
</form>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">📊 Top 5 Most Liked Posts</h3>
                    <div id="likesContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">📊 Top 5 Most Viewed Posts</h3>
                    <div id="viewsContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">📊 Top 5 Most Comments Posts</h3>
                    <div id="commentsContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        let labels = @json($like_labels);   // Post titles
        let data   = @json($like_data); 
        Highcharts.chart('likesContainer', {
            chart: {
                type: 'column'   
            },
            title: {
                text: 'Top 5 Most Liked Posts'
            },
            xAxis: {
                categories: labels,
                title: {
                    text: 'Posts'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Likes Count'
                }
            },
            series: [{
                name: 'Likes Count',
                data: data,
                color: '#FFACAC'
            }]
        });    

        let postTitles = @json($labels);   
        let postViews  = @json($data);     

        Highcharts.chart('viewsContainer', {
            chart: {
                type: 'bar'   
            },
            title: {
                text: 'Top 5 Posts by Views'
            },
            xAxis: {
                categories: postTitles,
                title: {
                    text: 'Posts'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Views'
                }
            },
            series: [{
                name: 'Views',
                data: postViews,
                color: '#4F46E5' 
            }]
        });

        let commentLabels = @json($post_title);   
        let postComments = @json($comments_count); 

        Highcharts.chart('commentsContainer', {
            chart: {
                type: 'bar'   
            },
            title: {
                text: 'Top 5 Posts by Comments'
            },
            xAxis: {
                categories: commentLabels,
                title: {
                    text: 'Posts'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Comments Count'
                }
            },
            series: [{
                name: 'Comments Count',
                data: postComments,
                color: '#F59E0B' // nice indigo color
            }]
        });
    </script>
</x-app-layout>
