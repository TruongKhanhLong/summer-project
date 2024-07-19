<!DOCTYPE html>
<html>
<head>
    <title>Data Display</title>
</head>
<body>
    <h1>Data from API</h1>
    @if(isset($data))
        <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
    @else
        <p>No data available.</p>
    @endif
</body>
</html>
