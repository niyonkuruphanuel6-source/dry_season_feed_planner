# 🌱 Dry Season Feed & Silage Planner

A lightweight dairy farm decision-support web application designed to help livestock extension officers, dairy cooperatives, and farmers calculate dry season feed deficits, estimate silage biomass requirements, and manage fodder reserves.

---

## 🌐 Live Web Demo

**Live Public Application**: [https://niyonkuruphanuel6-source.github.io/dry_season_feed_planner/](https://niyonkuruphanuel6-source.github.io/dry_season_feed_planner/)

---

## 📋 Features

- **Farmer Contact Management**: Register smallholder and commercial dairy farmers with contact and location details.
- **Herd Demographics Profiling**: Record animal herd composition (lactating cows, dry cows, heifers, calves).
- **Interactive Silage Calculator**:
  - Live client-side calculation of fresh silage requirements over a specified dry season window.
  - Automatically factors in conservation/fermentation/storage loss ($15\%$ default shrinkage model: $\text{target} = \frac{\text{base}}{1 - \text{loss}\%}$).
  - Computes dry matter (DM) contribution and estimated silo volume compaction at $650\text{ kg/m}^3$.
- **Silage Inventory & Stock Control**: Log silage production, daily feeding intake, and inventory adjustments.
- **Responsive Dashboard**: Summary statistics of total conserved feed, animal counts, and stock status.

---

## 🛠️ Technology Stack

- **Backend**: Pure PHP 8.0+ (native PDO with prepared statements, strict typing)
- **Database**: MySQL / MariaDB (utf8mb4 encoding, foreign key cascade constraints)
- **Frontend**: Semantic HTML5, CSS3 Grid & Flexbox (zero CSS framework dependencies, mobile-responsive)
- **Client Scripting**: Vanilla JavaScript (ES6+)

---

## 🚀 Getting Started

### Prerequisites

- [XAMPP](https://www.apachefriends.org/), [WampServer](https://www.wampserver.com/), or any LAMP/LEMP stack with PHP 8.0+ and MySQL.
- A modern web browser.

### Installation

1. **Clone or copy the project into your web directory**:
   - For XAMPP on Windows:
     ```bash
     git clone https://github.com/niyonkuruphanuel1-hash/dry_season_feed_planner.git C:\xampp\htdocs\dry_season_feed_planner
     ```

2. **Database Setup**:
   - Start Apache and MySQL from the XAMPP Control Panel.
   - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Import [`database.sql`](database.sql) to create the `dry_season_planner` database, tables, and sample data.

3. **Database Configuration**:
   - Open `config.php` and verify your MySQL connection settings:
     ```php
     $host = 'localhost';
     $db   = 'dry_season_planner';
     $user = 'root';
     $pass = ''; // Default is empty in XAMPP
     ```

4. **Launch Application**:
   - Open your browser and navigate to:
     ```
     http://localhost/dry_season_feed_planner/
     ```

---

## 🧮 Calculation Logic & Agronomic Assumptions

$$\text{Daily Silage Intake (kg)} = (N_{\text{lactating}} \times R_{\text{lactating}}) + (N_{\text{dry}} \times R_{\text{dry}}) + (N_{\text{heifers}} \times R_{\text{heifers}}) + (N_{\text{calves}} \times R_{\text{calves}})$$

$$\text{Gross Biomass Target (kg)} = \frac{\text{Daily Silage Intake} \times \text{Days of Dry Season}}{1 - (\text{Storage Loss Percentage} / 100)}$$

$$\text{Approximate Pit / Bunker Volume (m}^3) = \frac{\text{Gross Biomass Target (kg)}}{650\text{ kg/m}^3}$$

> **Disclaimer**: Rations and feeding values should be adapted based on animal live weights, milk yield, forage dry matter content, and validated with a qualified livestock nutritionist or extension officer.

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.
