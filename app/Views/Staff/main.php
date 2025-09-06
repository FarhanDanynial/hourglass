<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .dashboard-square {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 150px;
      font-size: 1.5rem;
      color: #fff;
      border-radius: 12px;
      text-decoration: none;
      transition: transform 0.1s, box-shadow 0.1s;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .dashboard-square:hover {
      transform: translateY(-4px) scale(1.03);
      box-shadow: 0 4px 16px rgba(0,0,0,0.12);
      text-decoration: none;
      color: #fff;
    }
  </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh;">

  <div class="container">
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-md-6 col-lg-6">
        <a href="/staff/pos" class="dashboard-square bg-primary w-100">POS</a>
      </div>
      <div class="col-12 col-md-6 col-lg-6">
        <a href="/staff/inventory" class="dashboard-square bg-success w-100">Inventory</a>
      </div>
      <div class="col-12 col-md-6 col-lg-6">
        <a href="/staff/settings" class="dashboard-square bg-warning w-100">Settings</a>
      </div>
      <div class="col-12 col-md-6 col-lg-6">
        <a href="/staff/editPos" class="dashboard-square bg-danger w-100">Edit POS</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
