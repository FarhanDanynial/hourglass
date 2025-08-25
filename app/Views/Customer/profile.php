
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Membership Barcode</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php base_url()?>/assets/css/customerCSS.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <!-- Desktop Navigation -->
        

        <div class="header">
            <div class="points-card">
                <!-- logout -->
                 <a href="logout" class="btn btn-outline-danger">Logout</a>
            </div>
        </div>

        <div class="nav-bottom">
            <a class="nav-item" href="/customer/dashboard" style="text-decoration: none;">
                <div class="nav-icon">🏠</div>
                <div class="nav-label">Home</div>
            </a>
            <a class="nav-item" href="/customer/membership" style="text-decoration: none;">
                <div class="nav-icon">🎁</div>
                <div class="nav-label">Membership</div>
            </a>
            <a class="nav-item" href="/customer/order" style="text-decoration: none;">
                <div class="nav-icon">🏪</div>
                <div class="nav-label">Order</div>
            </a>
            <a class="nav-item" href="/customer/voucher" style="text-decoration: none;">
                <div class="nav-icon">🎫</div>
                <div class="nav-label">Vouchers</div>
            </a>
            <div class="nav-item active">
                <div class="nav-icon">👤</div>
                <div class="nav-label">Profile</div>
            </div>
        </div>
    </div>

    <script>

        // Desktop navigation interactions
        document.querySelectorAll('.desktop-nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.desktop-nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Navigation interactions
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

    </script>


</body>
</html>
