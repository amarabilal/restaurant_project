# Restaurant Management System - Symfony Project

## **Overview**
This project is a **Restaurant Management System** built with **Symfony**. It allows users to manage restaurants, menus, tables, reservations, and reviews with role-based access control (RBAC). The project is designed with dynamic role management for **Admin**, **Manager (Gérant)**, **User**, and **Banned** users.

---

## **Features**

### **1. User Authentication & Roles**
- **Login/Logout system** with hashed passwords.
- Role-based access control (RBAC):
  - **Admin**: Full access to all features and user management.
  - **Manager (Gérant)**: Can manage only the restaurants they own, including menus, tables, and reservations.
  - **User**: Can browse restaurants, make reservations, and leave reviews.
  - **Banned**: Restricted access; can only view the "Banned" page.
- Secure session handling with **CSRF protection**.
- Password recovery with **ResetPasswordBundle**.

### **2. CRUD Operations**
- **Restaurants**: Create, read, update, delete.
- **Menus**: Manage items available in a restaurant.
- **Tables**: Assign and manage restaurant tables.
- **Reservations**: Allow users to book tables with validation.
- **Reviews**: Users can leave feedback and ratings.
- **Users**: Admin can manage user accounts.

### **3. Dynamic Role-Based Access**
- **Admin Dashboard** for full control.
- **Manager Dashboard** limited to their owned restaurants.
- **User View** for basic browsing and reservations.
- **Banned Users** redirected to a restricted access page.

### **4. Security Features**
- CSRF protection on all forms.
- Validation for inputs and entities.
- Session timeout and remember-me functionality.
- Firewall protection using Symfony security.

### **5. Fixtures for Testing**
- Database pre-filled with sample data using Doctrine Fixtures for quick setup and testing.

---

## **Project Setup**

### **1. Prerequisites**
- PHP 8.1 or later
- Composer
- Symfony CLI
- MySQL Database

### **2. Installation**
```bash
# Clone the repository
git clone <repository-url>
cd restaurant_project

# Install dependencies
composer install

# Setup environment variables
cp .env .env.local

# Update database settings in .env.local
DATABASE_URL="mysql://user:password@127.0.0.1:3306/restaurant"

# Create the database
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Load sample data
php bin/console doctrine:fixtures:load
```

### **3. Running the Application**
```bash
symfony server:start
```
Access the application at: **http://127.0.0.1:8000**

---

## **Testing Roles**
- **Admin**: Full access.
- **Manager**: Restricted to their restaurants.
- **User**: Limited to viewing and reservations.
- **Banned**: Redirected to **/banned** with a warning message.

---

## **Potential Improvements**
1. **Search and Filters:** Add search bars and filters for restaurants, menus, and reservations.
2. **Real-time Notifications:** Implement live updates for reservations and reviews using **Mercure**.
3. **Payment Integration:** Integrate payment gateways like **Stripe** for reservation payments.
4. **Email Notifications:** Send confirmations and updates via email.
5. **Reporting Dashboard:** Add graphs and reports for admins.
6. **Temporary Bans:** Manage time-limited bans with expiration dates.
7. **Mobile Responsiveness:** Enhance UI for mobile devices.
8. **API Endpoints:** Provide a RESTful API for external integrations.
9. **Multi-Language Support:** Implement translations for multilingual users.

---

## **Contact Information**
For support or questions, please reach out to the project maintainer at: **support@example.com**.

