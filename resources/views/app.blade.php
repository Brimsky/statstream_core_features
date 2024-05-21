<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        <!-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('b3d507537fb39f00b817', {
        cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
        app.messages.push(JSON.stringify(data));
        });

        // Vue application
        const app = new Vue({
        el: '#app',
        data: {
            messages: [],
        },
        });
    </script> -->
        @inertiaHead
    </head>
    <body class="font-sans antialiased dark:bg-neutral-900 bg-white">
        @inertia
    </body>
</html>
