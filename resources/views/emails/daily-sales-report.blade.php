<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Sales Report</title>
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
            background-color: #007bff;
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
        .summary {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }
        .summary-item {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            flex: 1;
            margin: 0 5px;
        }
        .summary-item h3 {
            margin: 0;
            color: #007bff;
        }
        .summary-item p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #6c757d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
        }
        .no-sales {
            text-align: center;
            padding: 30px;
            background-color: white;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Sales Report</h1>
        <p>{{ $date->format('l, F j, Y') }}</p>
    </div>
    <div class="content">
        <p>Hello Admin,</p>
        <p>Here is your daily sales summary:</p>

        <div class="summary">
            <div class="summary-item">
                <h3>{{ $totalOrders }}</h3>
                <p>Total Orders</p>
            </div>
            <div class="summary-item">
                <h3>${{ number_format($totalSales, 2) }}</h3>
                <p>Total Sales</p>
            </div>
        </div>

        @if(count($productsSold) > 0)
            <h3>Products Sold Today</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productsSold as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>${{ number_format($product['revenue'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-sales">
                <p>No sales recorded for today.</p>
            </div>
        @endif
    </div>
    <div class="footer">
        <p>This is an automated daily report from your E-Commerce System.</p>
    </div>
</body>
</html>

