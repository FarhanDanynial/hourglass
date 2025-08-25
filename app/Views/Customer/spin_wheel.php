<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spin Wheel</title>
    <style>
        canvas { 
            margin: 30px auto; 
            display: block; 
            width: 400px;
            height: 400px;
        }

        button { 
            display: block; 
            margin: 20px auto; 
            padding: 10px 20px; 
        }

        @media (max-width: 767px) {
            canvas {
                width: 250px;
                height: 250px;
            }
        }
    </style>

    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php base_url()?>/assets/css/customerCSS.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="header">
            <div class="points-card">
                <div >
                    <!-- Arrow Pointer -->
                    <div id="arrow" style="
                        position: absolute;
                        top: -10px;
                        left: 50%;
                        transform: translateX(-50%);
                        width: 0;
                        height: 0;
                        border-left: 20px solid transparent;
                        border-right: 20px solid transparent;
                        border-top: 30px solid red;
                        z-index: 2;
                    "></div>

                    <!-- Wheel Canvas -->
                    <canvas id="wheel" style="z-index: 1; position: relative;"></canvas>
                                    
                    <!-- Spin Button -->
                    <button onclick="spinWheel()">Spin!</button>

                    <h2 id="result" style="text-align:center;"></h2>
                </div>
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
            <a class="nav-item" href="/customer/profile" style="text-decoration: none;">
                <div class="nav-icon">👤</div>
                <div class="nav-label">Profile</div>
            </a>
        </div>
    </div>


<script>
    const segments = <?= json_encode($segments); ?>;
    const canvas = document.getElementById("wheel");
    // Resize canvas based on screen size
    if (window.innerWidth < 768) {
        canvas.width = 250;
        canvas.height = 250;
    } else {
        canvas.width = 400;
        canvas.height = 400;
    }

    const ctx = canvas.getContext("2d");
    let center = canvas.width / 2;
    const totalSegments = segments.length;
    const anglePerSegment = 2 * Math.PI / totalSegments;
    let currentAngle = 0;

    // Draw wheel
    function drawWheel() {
        for (let i = 0; i < totalSegments; i++) {
            const angleStart = i * anglePerSegment;
            const angleEnd = angleStart + anglePerSegment;

            ctx.beginPath();
            ctx.moveTo(center, center);
            ctx.arc(center, center, center - 10, angleStart, angleEnd);
            ctx.fillStyle = `hsl(${i * 360 / totalSegments}, 80%, 60%)`;
            ctx.fill();
            ctx.stroke();

            // Label
            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(angleStart + anglePerSegment / 2);
            ctx.textAlign = "right";
            ctx.fillStyle = "#000";
            ctx.font = "bold 16px Arial";
            ctx.fillText(segments[i].label, center - 20, 10);
            ctx.restore();
        }

        // Draw center
        ctx.beginPath();
        ctx.arc(center, center, 20, 0, 2 * Math.PI);
        ctx.fillStyle = "#fff";
        ctx.fill();
        ctx.stroke();
    }

    drawWheel();

    function getWeightedRandomSegment() {
        const weighted = [];
        segments.forEach((seg, index) => {
            for (let i = 0; i < seg.percentage; i++) {
                weighted.push(index);
            }
        });
        const randIndex = Math.floor(Math.random() * weighted.length);
        return weighted[randIndex];
    }

    function spinWheel() {
        const winningIndex = getWeightedRandomSegment();
        const segmentAngle = 360 / totalSegments;
        const spinToAngle = (360 * 10) + 270 - (winningIndex * segmentAngle + segmentAngle / 2);
        const duration = 4000; // 4 seconds
        const start = performance.now();

        function animate(time) {
            const elapsed = time - start;
            const progress = Math.min(elapsed / duration, 1);
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const angle = easeOut * spinToAngle;

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(angle * Math.PI / 180);
            ctx.translate(-center, -center);
            drawWheel();
            ctx.restore();

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                document.getElementById("result").innerText = "You got: " + segments[winningIndex].label;
            }
        }

        requestAnimationFrame(animate);
    }
</script>

</body>
</html>
