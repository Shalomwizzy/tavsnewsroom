<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - 404</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: black;
            color: white;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }
        .container {
            text-align: center;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 2.5rem;
            }
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="display-1 fw-bold">404</h1>
        <h1 class="mb-4">Page Not Found</h1>
        <p class="mb-4">We’re sorry, the page you are looking for does not exist on our website, or you may not have the required permissions to access this page. You can go to our home page or try using the search feature.</p>
        <a class="btn" href="{{ route('welcome') }}">Go Back To Home</a>
    </div>
</body>
</html>

