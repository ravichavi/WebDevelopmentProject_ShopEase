SHOPEASE - FRESH PHP + MYSQL PROJECT

This is an original ShopEase marketplace-style storefront. It is inspired by common online-shopping patterns, not an Amazon copy.

INSTALLATION (XAMPP / WINDOWS)
1. Extract the ShopEase folder to: C:\xampp\htdocs\ShopEase
2. Start Apache and MySQL in XAMPP.
3. Open http://localhost/phpmyadmin
4. Import database.sql (it creates the shopease database and sample products).
5. Open config.php and confirm:
   BASE_URL = '/ShopEase'
   DB_NAME = 'shopease'
   DB_USER = 'root'
   DB_PASS = ''
6. Open http://localhost/ShopEase/

FEATURES INCLUDED
- Responsive ShopEase homepage, product cards, categories, search and sorting
- Product detail pages
- Add to cart, cart summary and remove from cart
- Customer registration, login, logout and account
- Checkout with Cash on Delivery demo
- Stock check and stock reduction when placing orders
- Customer order history
- Contact form saved to database
- CSRF protection for POST forms and password hashing

IMPORTANT
- This is a local learning/demo project, not production-ready.
- Checkout is Cash on Delivery only; no real online payment gateway.
- Wishlist page is a placeholder and can be built in the next iteration.
- Product images use remote Unsplash URLs and need an internet connection.
- If your folder name or location changes, update BASE_URL in config.php.
