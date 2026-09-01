<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>PhonePe Payment Gateway Integration in Laravel</title>
 
    <!-- BOOTSTRAP -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
 
    <!-- Styles -->
    <style>
       body {
            background: #f7f7f7;
        }
 
        .form-box {
            max-width: 500px;
            margin: auto;
            padding: 50px;
            background: #ffffff;
            border: 10px solid #f2f2f2;
            margin-top: 100px;
        }
 
        h1, p {
            text-align: center;
        }
 
        input, textarea {
            width: 100%;
        }
        .form-control{
            margin-bottom:20px;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h4>Pay with PhonePe</h4>
    <form action="{{ route('phonepe.store') }}" method="post" style="margin-top: 50px;">
        @csrf
        <div class="formgroup">
        <label>Amount</label>
        <input type="number" name="amount" placeholder="Amount" class="form-control">
    </div>
        <button type="submit" class="btn btn-primary">Pay Now</button>
    </form>
</div>
</body>
</html>