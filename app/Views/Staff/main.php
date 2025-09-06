<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .square {
      aspect-ratio: 1 / 1; /* keeps squares responsive */
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: bold;
      color: white;
      border-radius: 10px;
      transition: transform 0.2s ease-in-out;
      text-decoration: none;
    }
    .square:hover {
      transform: scale(1.05);
      opacity: 0.9;
    }
  </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

  <div class="container">
    <div class="row g-4">
      <div class="col-6">
        <a href="/page1" class="square bg-primary w-100">Page 1</a>
      </div>
      <div class="col-6">
        <a href="/page2" class="square bg-success w-100">Page 2</a>
      </div>
      <div class="col-6">
        <a href="/page3" class="square bg-warning w-100">Page 3</a>
      </div>
      <div class="col-6">
        <a href="/page4" class="square bg-danger w-100">Page 4</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
