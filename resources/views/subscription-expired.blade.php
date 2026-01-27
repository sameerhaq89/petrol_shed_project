<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expired</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .expired-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .expired-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            padding: 50px 30px;
            color: white;
        }

        .expired-header i {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .expired-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .expired-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .expired-body {
            padding: 50px 40px;
        }

        .expired-body h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .expired-body p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .features {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }

        .features h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .features ul {
            list-style: none;
            padding: 0;
        }

        .features li {
            padding: 8px 0;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .features li i {
            color: #4CAF50;
            font-size: 14px;
        }

        .contact-info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .contact-info h3 {
            color: #856404;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .contact-info p {
            color: #856404;
            margin: 5px 0;
        }

        .contact-info a {
            color: #856404;
            font-weight: 600;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .btn-logout {
            display: inline-block;
            padding: 14px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="expired-container">
        <div class="expired-header">
            <i class="fas fa-exclamation-triangle"></i>
            <h1>Subscription Expired</h1>
            <p>Your access has been suspended</p>
        </div>

        <div class="expired-body">
            <h2>Your subscription has expired</h2>
            <p>We're sorry, but your station's subscription has expired and you no longer have access to the Petrol Shed platform.</p>

            <div class="features">
                <h3><i class="fas fa-crown"></i> Renew to unlock:</h3>
                <ul>
                    <li><i class="fas fa-check-circle"></i> Full access to all features</li>
                    <li><i class="fas fa-check-circle"></i> Tank and fuel management</li>
                    <li><i class="fas fa-check-circle"></i> Settlement tracking</li>
                    <li><i class="fas fa-check-circle"></i> Advanced reporting</li>
                    <li><i class="fas fa-check-circle"></i> Unlimited addons (Premium plan)</li>
                </ul>
            </div>

            <div class="contact-info">
                <h3><i class="fas fa-phone-alt"></i> Contact Administrator</h3>
                <p>Please contact your system administrator to renew your subscription.</p>
                <p>Email: <a href="mailto:admin@petrolshed.com">admin@petrolshed.com</a></p>
                <p>Phone: <a href="tel:+1234567890">+123 456 7890</a></p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
