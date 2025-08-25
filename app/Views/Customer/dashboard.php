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
        

        <div class="header">
            <div class="welcome">
                <h1>Welcome back, <?=$name?> 👋</h1>
                <p>Ready to unlock amazing rewards?</p>
            </div>
            
            <div class="points-card">
                <div class="points-display">
                    <div class="points-label">Your Membership Points</div>
                    <div class="points-value" id="pointsValue"><?=$points?></div>
                </div>
                <div class="points-actions">
                    <button class="btn btn-primary" onclick="earnPoints()">Earn More</button>
                    <button class="btn btn-secondary" onclick="viewHistory()">History</button>
                </div>
            </div>
            
            <!-- Additional sidebar actions for desktop -->
            <div class="sidebar-actions">
                <div class="desktop-nav">
                    <div class="desktop-nav-item active">Home</div>
                    <div class="desktop-nav-item">Membership</div>
                    <div class="desktop-nav-item">Order</div>
                    <div class="desktop-nav-item">Profile</div>
                </div>
            </div>
        </div>

        <div class="content">
            <h2 class="section-title">
                <span class="fire-icon">🔥</span>
                Hot Deals
            </h2>
            
            <div class="deals-grid">
                <div class="deal-card featured">
                    <div class="deal-header">
                        <div class="deal-discount">50% OFF</div>
                        <div class="deal-subtitle">Limited Time</div>
                    </div>
                    <div class="deal-body">
                        <div class="deal-title">Premium Coffee Bundle</div>
                        <div class="deal-description">Get your favorite blend with exclusive premium beans from around the world.</div>
                        <div class="deal-footer">
                            <div class="deal-points">500 pts</div>
                            <div class="deal-timer">⏰ 2h 15m left</div>
                        </div>
                    </div>
                </div>

                <div class="deal-card">
                    <div class="deal-header">
                        <div class="deal-discount">30% OFF</div>
                        <div class="deal-subtitle">Popular</div>
                    </div>
                    <div class="deal-body">
                        <div class="deal-title">Wireless Headphones</div>
                        <div class="deal-description">High-quality sound with noise cancellation technology.</div>
                        <div class="deal-footer">
                            <div class="deal-points">800 pts</div>
                            <div class="deal-timer">⏰ 5h 30m left</div>
                        </div>
                    </div>
                </div>

                <div class="deal-card">
                    <div class="deal-header">
                        <div class="deal-discount">Free Gift</div>
                        <div class="deal-subtitle">New Member</div>
                    </div>
                    <div class="deal-body">
                        <div class="deal-title">Welcome Package</div>
                        <div class="deal-description">Starter kit with branded merchandise and discount vouchers.</div>
                        <div class="deal-footer">
                            <div class="deal-points">200 pts</div>
                            <div class="deal-timer">⏰ Always Available</div>
                        </div>
                    </div>
                </div>

                <div class="deal-card">
                    <div class="deal-header">
                        <div class="deal-discount">25% OFF</div>
                        <div class="deal-subtitle">Trending</div>
                    </div>
                    <div class="deal-body">
                        <div class="deal-title">Fitness Tracker</div>
                        <div class="deal-description">Monitor your health with advanced tracking features.</div>
                        <div class="deal-footer">
                            <div class="deal-points">650 pts</div>
                            <div class="deal-timer">⏰ 1 day left</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav-bottom">
            <div class="nav-item active">
                <div class="nav-icon">🏠</div>
                <div class="nav-label">Home</div>
            </div>
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