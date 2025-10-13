
<p align="center">
  <a href="https://laravel.com" target="_blank">
	 <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# AI - Mobile Hub

> A full-featured AI based e-commerce web application for buying and selling mobile phones and accessories, built with Laravel 12.

---

## 🚀 Features

### User Features
- **User Registration & Login** (with email verification)
- **Profile Management**: Edit personal info, change password, manage privacy
- **Product Browsing & Search**: High-quality images, detailed specs, search by brand/model/price/features
- **Filters**: RAM, storage, display size, camera quality
- **Shopping Cart & Wishlist**: Add to cart, save favorites
- **Order Placement & Tracking**: Streamlined checkout, delivery preferences, order status notifications
- **Customer Support**: Contact form, FAQ, (optional) live chat

### Admin Features
- **Admin Login & Dashboard**
- **Product Management**: Add, edit, delete, manage featured/new/hot products
- **Inventory Management**: Real-time stock tracking
- **Order Management**: Track/update order status
- **Analytics Dashboard**: Sales & user activity
- **Category & Brand Management**

### AI Agent Integration (Planned)
- Personalized product recommendations
- Real-time chat assistant
- Smart analytics & inventory prediction

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12, PHP
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap
- **Database:** MySQL
- **Image Handling:** Intervention Image v3 (resize, folder creation, safe delete)
- **Version Control:** Git & GitHub

---

## ⚙️ Installation & Setup

1. **Clone the repository**
	```sh
	git clone https://github.com/username/mobile-hub.git
	cd mobile-hub
	```
2. **Install PHP dependencies**
	```sh
	composer install
	```
3. **Install frontend dependencies**
	```sh
	npm install
	npm run dev
	```
4. **Configure `.env` file**
	- Set database connection
	- Set mail settings for notifications
5. **Run migrations & seeders**
	```sh
	php artisan migrate --seed
	```
6. **Start the development server**
	```sh
	php artisan serve
	```
7. **Access the application**
	- Open [http://localhost:8000](http://localhost:8000) in your browser

---

## 📂 Folder Structure Highlights

- `app/Models` – Eloquent Models
- `app/Http/Controllers/Mobilehub` – Controllers
- `resources/views/admin` – Admin dashboard views
- `public/uploads` – Uploaded images for brands, products, etc.

---

## 🔒 Notes

- Admin and Customer are separate roles with different access rights
- Image handling uses Intervention Image v3 for resizing, folder creation, and safe deletion
- AI Agent integration is planned for enhanced recommendations and analytics in future updates

---

## 🛣️ Future Roadmap

- Full AI-based recommendation engine
- Real-time chatbot support
- Multi-language support
- Enhanced payment integration (mobile banking & card payments)
- Improved analytics and reporting tools for administrators

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
