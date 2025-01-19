

<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="center-wrapper">
	<div class="content">
		<nav>
			<a href="#" class="menu">Menu</a>
			<h1 class="logo">CanonCode</h1>
			<div class="icons">
				<i class="fas fa-search"></i>
				<i class="fas fa-shopping-bag"></i><span style="margin-left: 0.3rem;">1</span>
			</div>
		</nav>
		<div class="top-bar">
			<i class="fas fa-arrow-left"></i>
			<span>Continue shopping</span>
		</div>
		<div class="bag">
			<p class="bag-head"><span style="text-transform: uppercase">Your Bag</span> - 1 item</p>
		</div>
		<div class="bag-product">
			<div class="image">
				<img src="1616499931_iph12pm.jpg" class="product-image">
			</div>
			<div class="description">
				<p class="product-code small muted">Product code: SS022592000</p>
				<h1>iPhone 12 Pro Max</h1>
				<p>Sun</p>
				<p class="description-text">iPhone 12 Pro Max 256GB......</p>
				<p style="margin-bottom: 0.5rem;">Blue</p>
				<h2>$825.00</h2>
				<input type="text" name="amount" id="amount" value="<?= 200 ?>">
				<div class="quantity-wrapper">
					<div>
						<label for="quantity" style="margin-right: 0.5rem;">Quantity:</label>
						<select name="quantity" style="margin-bottom: 1rem;">
							<option value disabled>Please select</option>
							<option value="1" selected>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
					<button class="btn-remove">Remove</button>
				</div>
			</div>
		</div>
		<div class="bag-total">
			<div class="subtotal">
				<p class="small">Subtotal:</p>
				<p class="small">$825.00</p>
			</div>
			<div class="delivery">
				<p class="small">Delivery (Standard - 2 working days):<br>
					<span class="change-delivery">Change delivery method</span>
				</p>
				<p class="small">Free</p>
			</div>
			<div class="total">
				<h3>Total:</h3>
				<h3>$825.00</h3>
			</div>
            <form action="" method="post">
                <input type="text" name>
                <div class="promo-checkbox">
                    <input type="checkbox" name="promo-check" checked>
                    <label for="promo-check">I have a promo code</label>
                </div>
                <div class="promo-code">
                    <input type="text" name="promo-checkbox" placeholder="Enter your promo code here" checked>
                    <button class="apply">Apply</button>
                </div>
                <button class="btn-go-checkout">
                    <i class="fas fa-lock"></i>
                    <span>Go to Checkout</span>
                </button>
				<br>
                <div id="paypal-button-container"></div>
            </form>
			
		</div>
		<div class="help">
			<p>Need help? Call Canon Code via +254 741 575274</p>
		</div>
	</div>
</div>
<div class="bg"></div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
 <!-- Replace the "test" client-id value with your client-id -->
<script src="https://www.sandbox.paypal.com/sdk/js?client-id=Ae15xLTKadxt1n17OTKnYK9GKc6TTcqvBM5CHt1IXAAKKwlTtx_RJ82ndJssVjy8ioL6Hw3bxz2teIqU&currency=USD"></script>
<script src="app.js"></script>
 
