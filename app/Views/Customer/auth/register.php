<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
  <h4 class="mb-3 text-center">Register</h4>

  <form id="registerForm">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" class="form-control" name="name" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" class="form-control" name="username" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Phone Number</label>
      <input type="tel" class="form-control" name="phone" placeholder="e.g. 0123456789">
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="password" id="password" required minlength="6">
    </div>

    <div class="mb-3">
      <label class="form-label">Confirm Password</label>
      <input type="password" class="form-control" name="confirm_password" id="confirm_password" required minlength="6">
    </div>

    <button type="submit" class="btn btn-success w-100">Register</button>
  </form>

  <div class="text-center mt-3">
    <a href="/customer/login">Already have an account? Login</a>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    const password = formData.get('password');
    const confirmPassword = formData.get('confirm_password');
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');


    if (password !== confirmPassword) {
      Swal.fire({
        icon: 'error',
        title: 'Passwords do not match!',
        text: 'Please re-enter matching passwords.'
      });
      return;
    }

    fetch('/customer/registerHandle', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
        })
        .then(res => res.json())
        .then(data => {
        if (data.success) {
            Swal.fire({
            icon: 'success',
            title: 'Registered!',
            text: data.message
            }).then(() => {
            window.location.href = "/customer/login";
            });
        } else {
            Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: data.message
            });
        }
        })
        .catch(err => {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong while registering.'
        });
        });
    });
</script>

</body>
</html>
