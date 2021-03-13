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

    <div id="visualization"></div>
</div>

<script src="https://visjs.github.io/vis-timeline/standalone/umd/vis-timeline-graph2d.min.js"></script>

<script type="text/javascript">
    // DOM element where the Timeline will be attached
    let container = document.getElementById('visualization');

    // Create a DataSet (allows two way data-binding)
    let items = new vis.DataSet({!! json_encode($data ?? []) !!});

    // Configuration for the Timeline
    let options = {
        moment: function(date) {
            return vis.moment(date).utc();
        },
        editable: false,
        minHeight: 300
    };

    // Create a Timeline
    let timeline = new vis.Timeline(container, items, options);
</script>

</body>
</html>
