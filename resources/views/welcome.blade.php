<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Laravel</title>

    </head>
    <body>
    <div class="container" id="app">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <graph-line
                            name="graphline_container" 
                            title="Chart's Title" 
                            value-label="Number" 
                            endpoint="http://graph-line.localhost/graphline/data" 
                        >
                    </graph-line>
                    </div>
                </div>
            </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
