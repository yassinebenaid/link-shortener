<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Link Shortener</title>

    <link rel="shortcut icon" href="favicon.svg" type="image/svg">

    @vite('resources/ts/app.ts')
    @inertiaHead
</head>

<body>
    @routes
    @inertia
    @include('placeholder')
</body>

</html>
