
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
                <h4 class="mb-3">Your Membership Barcode</h4>
                <p><strong>ID:</strong> <?= $membership_id ?></p>

                <svg id="barcode" style="width: 100%; max-width: 100%; height: auto;"></svg>

                <button id="downloadBtn" class="btn btn-success mt-3">Download PNG</button>
            </div>
        </div>

         <div class="nav-bottom">
             <a class="nav-item" href="/customer/dashboard" style="text-decoration: none;">
                <div class="nav-icon">🏠</div>
                <div class="nav-label">Home</div>
             </a>
            <div class="nav-item active">
                <div class="nav-icon">🎁</div>
                <div class="nav-label">Membership</div>
            </div>
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

<script>
  const membershipId = "<?= $membership_id ?>";

  const barcodeElement = document.querySelector("#barcode");
  const containerWidth = barcodeElement.parentElement.offsetWidth;
  const barWidth = Math.max(1, Math.floor(containerWidth / (membershipId.length * 10)));
  console.log(`Calculated bar width: ${barWidth}px`);

  // Generate barcode
  JsBarcode("#barcode", membershipId, {
    format: "CODE128",
    displayValue: true,
    lineColor: "#000",
    width: (barWidth-0.5),
    height: 80,
    margin: 10
  });

  // Download barcode as PNG
  document.getElementById('downloadBtn').addEventListener('click', function () {
    const svgElement = document.getElementById("barcode");
    const svgData = new XMLSerializer().serializeToString(svgElement);
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    const img = new Image();

    img.onload = function () {
      canvas.width = img.width;
      canvas.height = img.height;
      ctx.drawImage(img, 0, 0);
      const png = canvas.toDataURL("image/png");
      const a = document.createElement("a");
      a.href = png;
      a.download = "barcode.png";
      a.click();
    };

    img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
  });
</script>

</body>
</html>
