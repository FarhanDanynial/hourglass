<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
  <h4 class="mb-3 text-center">Login</h4>

  <!-- Tabs for login methods -->
  <ul class="nav nav-tabs mb-3" id="loginTabs">
    <li class="nav-item">
      <a class="nav-link active" href="#" id="tab-username">Username</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" id="tab-whatsapp">WhatsApp</a>
    </li>
  </ul>

  <!-- Username login form -->
  <form id="loginForm">
    <div id="username-login">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </div>
  </form>

  <!-- WhatsApp login form -->
  <form id="otpForm" class="d-none">
    <div class="mb-3">
      <label class="form-label">Phone Number</label>
      <input type="tel" class="form-control" id="phoneNumber" placeholder="e.g., 0123456789" required>
    </div>
    <button type="button" class="btn btn-success w-100" id="sendOtpBtn">Send OTP</button>

    <div id="otpSection" class="mt-3 d-none">
      <label class="form-label">Enter OTP</label>
      <input type="text" class="form-control mb-2" id="otpCode" required>
      <button type="button" class="btn btn-primary w-100" id="verifyOtpBtn">Verify & Login</button>
    </div>
  </form>

  <div class="text-center mt-3">
    <a href="/customer/register">Don't have an account? Register</a>
  </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('/customer/loginHandle', {
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
          title: 'Login Successful',
          text: data.message
        }).then(() => {
          window.location.href = data.redirect || '/customer/dashboard';
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Login Failed',
          text: data.message
        });
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Something went wrong while logging in.'
      });
    });
  });
</script>
<script>
  // Tab switching
  const usernameTab = document.getElementById("tab-username");
  const whatsappTab = document.getElementById("tab-whatsapp");
  const usernameLogin = document.getElementById("username-login");
  const otpForm = document.getElementById("otpForm");

  usernameTab.addEventListener('click', function(e) {
    e.preventDefault();
    usernameTab.classList.add('active');
    whatsappTab.classList.remove('active');
    usernameLogin.classList.remove('d-none');
    otpForm.classList.add('d-none');
  });

  whatsappTab.addEventListener('click', function(e) {
    e.preventDefault();
    whatsappTab.classList.add('active');
    usernameTab.classList.remove('active');
    otpForm.classList.remove('d-none');
    usernameLogin.classList.add('d-none');
  });

  // OTP Send
  document.getElementById('sendOtpBtn').addEventListener('click', () => {
    const phone = document.getElementById('phoneNumber').value;
    if (!phone) return Swal.fire('Warning', 'Enter phone number', 'warning');

    fetch('/customer/sendOtpWhatsapp', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ phone })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire('OTP Sent', data.message, 'success');
        document.getElementById('otpSection').classList.remove('d-none');
      } else {
        Swal.fire('Error', data.message, 'error');
      }
    });
  });

  // OTP Verify
  document.getElementById('verifyOtpBtn').addEventListener('click', () => {
    const phone = document.getElementById('phoneNumber').value;
    const otp = document.getElementById('otpCode').value;

    fetch('/customer/verifyOtp', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ phone, otp })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire('Login Success', data.message, 'success').then(() => {
          window.location.href = data.redirect || '/customer/dashboard';
        });
      } else {
        Swal.fire('Invalid OTP', data.message, 'error');
      }
    });
  });
</script>

</body>
</html>
