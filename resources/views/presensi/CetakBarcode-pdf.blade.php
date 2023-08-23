<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi Nore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
           
        }
        h1 {
            color: #000000;
            margin-bottom: 20px;
        }
        img {
            display: block;
            margin: 30px auto;
            width: 80%;
            max-width: 80%;
            border: 1px solid #ccc;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            background-color: white;
            padding: 10px;
            border-radius: 10px;
            
        }
        .description {
            font-size: 30px;
            margin-bottom: 30px;
        }
       
    </style>
</head>
<body>
    
    <h1>Absensi Harian</h1>
    <p class="description"> {{ date("Y-m-d")}}</p>
    <div class="qr-container">
        <img src="data:image/png;base64,{{ base64_encode($data) }}" alt="QR Code">
    </div>
  
    
</body>
</html>
