<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory & POS System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .item-card {
      aspect-ratio: 1 / 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 10px;
      border-radius: 10px;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      position: relative;
      transition: transform 0.2s ease-in-out;
    }
    .item-card:hover {
      transform: scale(1.05);
    }
    .item-img {
      width: 100%;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .delete-btn {
      position: absolute;
      top: 8px;
      right: 8px;
    }
    .pos-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
      padding: 5px 0;
    }
  </style>
</head>
<body class="bg-light">

<div class="container-fluid py-4">
  <div class="row">
    <!-- Inventory -->
    <div class="col-md-6 mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Inventory</h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">+ Add Item</button>
      </div>

      <div class="row g-3" id="inventory">
        <!-- Item cards will be appended here -->
      </div>
    </div>

    <!-- POS System -->
    <div class="col-md-6">
      <h4 class="mb-3">POS System</h4>
      <div id="posCart" class="bg-white p-3 rounded shadow-sm" style="min-height: 300px;">
        <p class="text-muted">No items yet.</p>
      </div>
    </div>
  </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addItemForm">
        <div class="modal-header">
          <h5 class="modal-title">Add New Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Image URL</label>
            <input type="text" class="form-control" name="image" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" class="form-control" name="price" step="0.01" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const inventoryEl = document.getElementById('inventory');
  const posCartEl = document.getElementById('posCart');
  let inventory = [];
  let cart = [];

  // Add item to inventory
  document.getElementById('addItemForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const data = new FormData(this);
    const newItem = {
      id: Date.now(),
      name: data.get('name'),
      image: data.get('image'),
      price: parseFloat(data.get('price')).toFixed(2),
      stock: parseInt(data.get('stock'))
    };
    inventory.push(newItem);
    renderInventory();
    this.reset();
    bootstrap.Modal.getInstance(document.getElementById('addItemModal')).hide();
  });

  // Render inventory
  function renderInventory() {
    inventoryEl.innerHTML = '';
    inventory.forEach(item => {
      const card = document.createElement('div');
      card.className = 'col-6 col-md-4';
      card.innerHTML = `
        <div class="item-card">
          <button class="btn btn-sm btn-danger delete-btn" onclick="deleteFromInventory(${item.id})">&times;</button>
          <img src="${item.image}" class="item-img" onclick="addToCart(${item.id})">
          <div onclick="addToCart(${item.id})">
            <h6>${item.name}</h6>
            <p class="mb-1">RM ${item.price}</p>
            <small>Stock: ${item.stock}</small>
          </div>
        </div>
      `;
      inventoryEl.appendChild(card);
    });
  }

  // Delete from inventory
  function deleteFromInventory(id) {
    inventory = inventory.filter(item => item.id !== id);
    cart = cart.filter(c => c.id !== id); // also remove from cart
    renderInventory();
    renderCart();
  }

  // Add to cart
  function addToCart(id) {
    const item = inventory.find(i => i.id === id);
    if (item && item.stock > 0) {
      item.stock -= 1;
      const cartItem = cart.find(c => c.id === id);
      if (cartItem) {
        cartItem.qty += 1;
      } else {
        cart.push({ ...item, qty: 1 });
      }
      renderInventory();
      renderCart();
    } else {
      alert("Out of stock!");
    }
  }

  // Remove item from cart
  function removeFromCart(id) {
    const cartItem = cart.find(c => c.id === id);
    if (cartItem) {
      // return stock to inventory
      const item = inventory.find(i => i.id === id);
      if (item) item.stock += cartItem.qty;
    }
    cart = cart.filter(c => c.id !== id);
    renderInventory();
    renderCart();
  }

  // Render POS cart
  function renderCart() {
    posCartEl.innerHTML = '';
    if (cart.length === 0) {
      posCartEl.innerHTML = '<p class="text-muted">No items yet.</p>';
      return;
    }
    cart.forEach(item => {
      const div = document.createElement('div');
      div.className = 'pos-item';
      div.innerHTML = `
        <span>${item.name} (x${item.qty})</span>
        <span>
          RM ${(item.price * item.qty).toFixed(2)}
          <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeFromCart(${item.id})">Remove</button>
        </span>
      `;
      posCartEl.appendChild(div);
    });
  }
</script>

</body>
</html>
