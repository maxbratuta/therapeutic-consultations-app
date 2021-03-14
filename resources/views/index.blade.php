<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://visjs.github.io/vis-timeline/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Therapeutic consultations</title>
</head>
<body>

<div class="container w-1/2 mx-auto">
    <h1 class="pt-14 pb-12 text-3xl font-medium">Therapeutic consultations</h1>

    <p class="pb-6">Select the time for consultation from the range - 10:00 - 13:00, 14:00 - 18:00 <b>by clicking on the time section</b>.</p>

    <div id="visualization"></div>
</div>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

</body>
</html>
