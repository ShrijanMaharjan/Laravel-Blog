<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
        let postTitles = @json($labels);   // Post titles
        let postViews  = @json($data);     // Views count

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
                color: '#4F46E5' // nice indigo color
            }]
        });

        let commentLabels = @json($post_title);   // Post titles
        let postComments = @json($comments_count); // Comments count

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
