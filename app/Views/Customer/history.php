<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RewardZone - Loyalty App</title>
    <link href="<?php base_url()?>/assets/css/customerCSS.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Desktop Navigation -->
        

        <div class="header" style="height: 100vh;">
            <div class="welcome" style="display:flex; flex-direction: row;">
                <a href="/customer/dashboard" style="text-decoration: none;">&#x25C4; &#x200B;</a><h1>Purchase History</h1>
            </div>
            
            <p>Display history here in table form</p>
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
            <a class="nav-item" href="/customer/profile" style="text-decoration: none;">
                <div class="nav-icon">👤</div>
                <div class="nav-label">Profile</div>
            </a>
        </div>
    </div>

    <script>

        // Button interactions
        function earnPoints() {
            window.location.href = '/customer/membership';
        }

        function viewHistory() {
            window.location.href = '/customer/history';
        }


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

        // Deal card interactions
        document.querySelectorAll('.deal-card').forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('.deal-title').textContent;
                alert(`🛍️ Redeeming: ${title}\n\nThis would normally open the redemption flow!`);
            });
        });

        // Initialize animations
        window.addEventListener('load', () => {
            setTimeout(animatePoints, 500);
        });

        // Add some interactive effects
        document.querySelectorAll('.deal-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>