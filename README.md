# Vogue Tourism - Tour Management System

## Overview
This is a comprehensive tour management system for Vogue Tourism, allowing administrators to manage destinations, tours, and customer inquiries. The system includes both an admin panel and a user-facing interface for browsing and inquiring about tours.

## Features

### Admin Panel
- **Authentication**: Secure login system for administrators
- **Dashboard**: Overview of system statistics (tours, destinations, inquiries)
- **Destination Management**: Add, edit, and delete tour destinations
- **Tour Management**: Create, edit, and delete tour packages with details like pricing, duration, and images
- **Inquiry Management**: View and respond to customer inquiries

### User Interface
- **Tour Listings**: Browse domestic, international, and cruise tours
- **Filtering**: Filter tours by duration and destination
- **Tour Details**: View comprehensive information about each tour
- **Inquiry System**: Submit inquiries about specific tours

## Technical Details

### Directory Structure
- `/admin`: Admin panel files
  - `/admin/includes`: Reusable components for the admin panel
- `/css`: Stylesheets including admin.css and style.css
- `/js`: JavaScript files for frontend functionality
- `/our-tours`: Tour listing and details pages
- `/uploads/tours`: Storage for tour images

### Database Structure
- **admins**: Administrator accounts
- **categories**: Tour categories (Adventure, Family, etc.)
- **destinations**: Tour destinations with name and type
- **tours**: Tour packages with details and foreign keys to categories and destinations
- **inquiries**: Customer inquiries about tours

## Installation

1. Place the files in your web server directory
2. Import the database structure using setup_database.php
3. Access the admin panel at `/admin/login.php` with default credentials:
   - Username: admin@voguetourism.com
   - Password: admin123

## Usage

### Admin Tasks
1. Log in to the admin panel
2. Add destinations under the Destinations menu
3. Create tours under the Tours menu
4. View and manage customer inquiries

### User Experience
1. Browse tours by category (domestic, international, cruise)
2. Filter tours by duration or destination
3. View detailed information about a specific tour
4. Submit an inquiry about a tour of interest

## Technologies Used
- PHP for server-side processing
- MySQL for database management
- Bootstrap for responsive design
- JavaScript for interactive elements
- AJAX for form submissions

## Credits
Developed for Vogue Tourism to enhance their online tour booking and management capabilities.



Volume serial number is DE7B-FA3C
C:.
│   aboutus.php
│   blogs.php
│   career.php
│   career.zip
│   contact.php
│   cruise.php
│   dbc.php
│   flight.php
│   index.php
│   README.md
│   setup_database.php
│   visa-info.php
│
├───admin
│   │   add-tour.php
│   │   dashboard.php
│   │   destinations.php
│   │   edit-tour.php
│   │   index.php
│   │   inquiries.php
│   │   login.php
│   │   logout.php
│   │   tours.php
│   │
│   └───includes
│           footer.php
│           functions.php
│           header.php
│
├───css
│       admin.css
│       style.css
│
├───images
│       10.jpg
│       11.png
│       16.png
│       aazar.png
│       aboutus.454Z.png
│       aboutus.517Z.png
│       Adventure.jpg
│       Andaman_2 (1).jpg
│       Andaman_2.jpg
│       Australia.010Z.png
│       Australia.369Z.png
│       Australia.webp
│       Bali-1.jpg
│       bali.png
│       banner1.jpg
│       banner2.jpg
│       beach-suitcase.png
│       beach.png
│       book.svg
│       Canada.769Z.png
│       career.395Z.png
│       Dubai-1.jpg
│       dubai.400Z.png
│       Egypt.312Z.png
│       Family-1.webp
│       flight.jpg
│       fort-aguada-.jpg
│       Gir-and-Dwarka_4.jpg
│       Google_AI_Studio_2025-08-01T19_09_55.141Z.png  
│       Himachal_1.jpg
│       Honeymoon.jpg
│       Indonesia.314Z.png
│       Kashmir_3.jpg
│       Kerela_1.jpg
│       ladakh.png
│       Leisure-1.webp
│       location.svg
│       Maldives-2.jpg
│       Maldives.700Z.png
│       man-test.jpg
│       Paragliding-e1694853800441.webp
│       Pilmigrage.webp
│       Rajasthan_1.jpg
│       RiverRafting.webp
│       Screenshot-2024-01-24-141943.png
│       search.svg
│       seychelles.577Z.png
│       Singapore.817Z.png
│       Solo.jpg
│       South-Africa.985Z.png
│       step-3-7OYqXIyu.svg
│       thailand.013Z.png
│       thailand.jpg
│       Türkiye.606Z.png
│       usa.054Z.png
│       Vietnam.628Z.png
│       visa.367Z.png
│       visa.990Z.png
│       WhatsApp-Image-2023-12-01-at-19.55.05_c1a50cfe.jpg
│       WhatsApp-Image-2023-12-02-at-19.15.59_5a596b46.jpg
│
├───js
│       custom.js
│       tour.js
│
├───our-tours
│       cruise-listing.php
│       details.php
│       domestic-listing.php
│       international-listing.php
│       process-inquiry.php
│
├───uploads
│   └───tours
│           688e1aca2f771.jpg
│
└───video
        dubai.mp4