<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Low Stock Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .product-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .warning {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Low Stock Alert</h1>
    </div>
    <div class="content">
        <p>Hello Admin,</p>
        <p>This is an automated notification to inform you that the following product is running low on stock:</p>

        <div class="product-info">
            <h3>{{ $product->name }}</h3>
            <p><strong>Current Stock:</strong> <span class="warning">{{ $product->stock_quantity }} units</span></p>
            <p><strong>Low Stock Threshold:</strong> {{ $product->low_stock_threshold }} units</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
        </div>

        <p>Please consider restocking this item soon to avoid running out of inventory.</p>
    </div>
    <div class="footer">
        <p>This is an automated message from your E-Commerce System.</p>
    </div>
</body>
</html>

