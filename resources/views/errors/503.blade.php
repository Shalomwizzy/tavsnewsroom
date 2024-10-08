<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <title>Site Maintenance</title>
    <style>
        /* Add your custom styling here */
        body {
            text-align: center;
            padding: 150px;
            background-color: black;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        h3{
            font-size: 50px;
            font-family: Georgia, 'Times New Roman', Times, serif !important;
            color: #6C7293 !important;
        }
        body {
            font: 20px Helvetica, sans-serif;
            color: #333;
        }
        article {
            display: block;
            text-align: left;
            width: 650px;
            margin: 0 auto;
            color: #6C7293 !important;
        }
        a {
            color: #dc8100;
            text-decoration: none;
        }
        a:hover {
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <article>
        <h3>We&rsquo;ll be back soon!</h3>
        <div>
            <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. This maintenance is expected to take longer than usual. If you need to, you can always <a href="mailto:{{ $siteEmail }}">contact us</a>, otherwise we&rsquo;ll be back online shortly!</p>
            <p>&mdash; The {{ $siteName }} Team</p>
        </div>
    </article>
</body>
</html>

