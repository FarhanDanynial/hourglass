<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coffee Café Ordering Interface</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .menu, .summary {
            width: 45%;
        }
        .menu h2, .summary h2 {
            margin-bottom: 10px;
        }
        .menu button {
            display: block;
            margin: 5px 0;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }
        .summary {
            border-left: 1px solid #ccc;
            padding-left: 20px;
        }
        .highlight {
            font-weight: bold;
            color: green;
        }
        #customize-modal {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        #customize-modal select {
            display: block;
            margin-bottom: 10px;
        }
        #scanner-container {
            display: none;
            width: 100%;
            max-width: 300px;
            border: 2px solid #ccc;
        }
    </style>
</head>
<body>
<div class="menu">
    <h2>☕ Menu</h2>
    <?php foreach ($items as $item): ?>
        <button onclick="addItem(<?= $item['it_id'] ?>, '<?= htmlspecialchars(addslashes($item['it_name'])) ?>', <?= $item['it_price'] ?>)"><?= $item['it_name'] ?> - RM<?= $item['it_price'] ?></button>
    <?php endforeach; ?>

    <h3>🎯 Loyalty</h3>
    <div style="display:flex; flex-direction: row;">
        <input style="width:250px; height:auto" type="text" placeholder="Enter phone number" id="phone-input">
        <button style="width:250px; height:auto" onclick="fetchCustomerByPhone()">Search By Number</button>
    </div>
    <button style="width:300px;" onclick="startScanner()">📷 Scan Loyalty Card</button>
    <div id="scanner-container"></div>
</div>

<div class="summary">
    <h2>🧾 Order Summary</h2>
    <div id="customer-info">
        <p><strong>Name:</strong> <span id="cust-name">-</span></p>
        <p><strong>Points:</strong> <span id="cust-points">-</span></p>
    </div>
    <div id="order-list">
        <h3>Items:</h3>
        <ul id="items"></ul>
    </div>
    <p>Total: <span class="highlight" id="total">RM0</span></p>
    <p>Redeemable Points: <span class="highlight" id="redeemed">0</span></p>
    <form id="order-form">
        <input type="hidden" name="order_json" id="order-json">
        <input type="hidden" name="customer_phone" id="hidden-phone">
        <input type="hidden" name="redeemable" id="redeemable">
        <button type="submit">Submit Order</button>
    </form>
</div>

<div id="customize-modal">
    <h3>Customize Drink</h3>
    <label>Sweetness:
        <select id="sweetness">
            <option value="0%">0%</option>
            <option value="50%">50%</option>
            <option value="100%" selected>100%</option>
        </select>
    </label>
    <label>Ice:
        <select id="ice">
            <option value="No Ice">No Ice</option>
            <option value="Less Ice">Less Ice</option>
            <option value="Regular" selected>Regular</option>
        </select>
    </label>
    <label>Whipped Cream:
        <select id="cream">
            <option value="Yes">Yes</option>
            <option value="No" selected>No</option>
        </select>
    </label>
    <label>Quantity:
        <input type="number" id="quantity" value="1" min="1" max="10">
    </label>
    <button onclick="confirmCustomization()">✔ Confirm</button>
</div>

<!-- QuaggaJS -->
<script src="https://unpkg.com/@ericblade/quagga2@1.2.6/dist/quagga.min.js"></script>
<script>
    let order = [];
    let currentItem = null;

    function addItem(it_id, it_name, it_price) {
        currentItem = { it_id, it_name, it_price };
        document.getElementById('customize-modal').style.display = 'block';
    }

    function confirmCustomization() {
        const sweetness = document.getElementById('sweetness').value;
        const ice = document.getElementById('ice').value;
        const cream = document.getElementById('cream').value;
        const quantity = document.getElementById('quantity').value;

        currentItem.sweetness = sweetness;
        currentItem.ice = ice;
        currentItem.cream = cream;
        currentItem.quantity = quantity;
        currentItem.price *= quantity; // Adjust price based on quantity

        order.push(currentItem);
        updateOrderSummary();
        document.getElementById('customize-modal').style.display = 'none';
    }

    function updateOrderSummary() {
        const itemsList = document.getElementById('items');
        itemsList.innerHTML = '';
        let total = 0;

        order.forEach((item, index) => {
            const li = document.createElement('li');
            li.textContent = `${item.it_name} - RM${item.it_price} (Sweet: ${item.sweetness}, Ice: ${item.ice}, Cream: ${item.cream}) x ${item.quantity}`;
            itemsList.appendChild(li);
            total += item.it_price;
        });

        document.getElementById('total').textContent = `RM${total}`;
        document.getElementById('redeemed').textContent = Math.floor(total);
        document.getElementById('redeemable').value = Math.floor(total);
        document.getElementById('order-json').value = JSON.stringify(order);
    }

    function fetchCustomerByPhone() {
        const phone = document.getElementById('phone-input').value;
        fetch('/staff/loyalty/checkNum/' + phone)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cust-name').textContent = data.user.name;
                    document.getElementById('cust-points').textContent = data.user.points;
                    document.getElementById('hidden-phone').value = phone;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'User not found.',
                    });
                }
            });
    }

    function startScanner() {
        document.getElementById('scanner-container').style.display = 'block';
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner-container'),
                constraints: {
                    facingMode: "environment"
                }
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "code_39_reader"]
            }
        }, err => {
            if (err) return console.error(err);
            Quagga.start();
        });

        Quagga.onDetected(data => {
            const code = data.codeResult.code;
            Quagga.stop();
            document.getElementById('scanner-container').style.display = 'none';
            fetch('/staff/loyalty/checkCode/' + code)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cust-name').textContent = data.user.name;
                    document.getElementById('cust-points').textContent = data.user.points;
                    document.getElementById('hidden-phone').value = data.user.phone;
                } else {
                    alert("User not found.");
                }
            });
        });
    }
</script>
<script>
    document.getElementById('order-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("<?= base_url('/staff/submit') ?>", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to submit order.',
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                });
            });
    });
</script>
</body>
</html>
