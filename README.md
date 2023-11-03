
## API Endpoints:

- `POST /api/register` - User registration.

- `POST /api/login` - User login (providing a Sanctum token upon successful login).

- `GET /api/logout` - Remove a Sanctum token and successful logout user.

- `GET /api/products` - Get all products (accessible to everyone).

- `GET /api/products/{id}` - Get a single product by ID (accessible to everyone).

- `POST /api/products` - Create a new product (accessible for logged in users).

- `DELETE /api/products/{id}` - Delete a product by ID (accessible for logged in users).

- `GET /api/users` - Get all users (accessible only for logged in users).