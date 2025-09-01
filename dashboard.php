<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// User welcome message
$username = $_SESSION['username'];

// Hotel Class Definition
class Hotel {
    private $name;
    private $location;
    private $price;
    private $image;
    private $rating;
    
    public function __construct($name, $location, $price, $image, $rating = null) {
        $this->name = $name;
        $this->location = $location;
        $this->price = $price;
        $this->image = $image;
        $this->rating = $rating ?? rand(35, 50) / 10;
    }
    
    public function getName() { return $this->name; }
    public function getLocation() { return $this->location; }
    public function getPrice() { return $this->price; }
    public function getImage() { return $this->image; }
    public function getRating() { return $this->rating; }
}

// Create hotel objects using OOP
$hotels = [
    new Hotel("Marino hotel", "Maine beach, Colombo, Srilanka", "12,000.00", "expensive.jpg", 4.5),
    new Hotel("Hamshas hotel", "Mount lavinia, Colombo, Srilanka", "11,500.00", "hotel6.jpg", 4.2),
    new Hotel("Hotel Bawas Continental", "Hikkaduwa, Colombo, Srilanka", "7,500.00", "hotel7.jpg", 4.0),
    new Hotel("The Fountain Inn", "Galle face, Colombo, Srilanka", "13,000.00", "hotel9.jpg", 4.7),
    new Hotel("Udaï Niwas", "Hildon place, Pampalapittiya, Srilanka", "15,500.00", "hotel1.jpg", 4.8),
    new Hotel("Love Palace", "W.ASilva mawatha, Wattala, Srilanka", "14,000.00", "hotel2.jpg", 4.3),
    new Hotel("Hotel Bawas Continental", "Fussels road, Colombo, Srilanka", "8,000.00", "hotel3.jpg", 4.1),
    new Hotel("The Fountain Inn", "Frassis road, Colombo, Srilanka", "8,500.00", "hotel.jpg", 4.4),
    new Hotel("Virat villa", "Hildon place, Pampalapittiya, Srilanka", "11,684.00", "hilton.jpg", 4.6),
    new Hotel("House of hotel", "Church road, Wattala, Srilanka", "10,000.00", "royalty.jpg", 4.9),
    new Hotel("Faceni villa", "Colombo0040, Dehiwala, Srilanka", "9,000.00", "laxuary.jpg", 4.0),
    new Hotel("Karavai hotel", "Colombo06, Galle road, Srilanka", "9,500.00", "5star.jpg", 4.2),
    new Hotel("Sheration hotel", "Malwatha, Pettah, Srilanka", "12,000.00", "hotel11.jpg", 4.5),
    new Hotel("Sun flower villa", "Lavinia, Yattiyanthotta, Srilanka", "13,500.00", "hotel12.jpg", 4.7),
    new Hotel("Krish villas", "Havina place, Magaragama, Srilanka", "16,000.00", "hotel13.jpg", 4.8),
    new Hotel("Ariyala hotel", "Paman road, Wellawatte, Srilanka", "17,500.00", "villa.jpg", 4.9)
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Hotel Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            padding: 20px;
            min-height: 100vh;
            position: relative;
        }

        /* NEW USER INFO STYLES */
        .user-info {
            position: absolute;
            top: 30px;
            right: 30px;
            background: rgba(255, 255, 255, 0.9);
            padding: 12px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        
        .user-info span {
            font-weight: 600;
            color: #2d3436;
        }
        
        .logout-btn {
            background: linear-gradient(45deg, #ff6b6b, #ee5253);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            margin-top: 60px;
        }

        .header h1 {
            font-size: 2.8rem;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        .search-filter {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .search-box {
            flex: 1;
            margin-right: 15px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 50px;
            background: #f1f3f6;
            font-size: 16px;
            box-shadow: inset 3px 3px 7px rgba(0, 0, 0, 0.1),
                        inset -3px -3px 7px rgba(255, 255, 255, 0.7);
        }

        .filter-box select {
            padding: 12px 20px;
            border: none;
            border-radius: 50px;
            background: #f1f3f6;
            font-size: 16px;
            box-shadow: inset 3px 3px 7px rgba(0, 0, 0, 0.1),
                        inset -3px -3px 7px rgba(255, 255, 255, 0.7);
            cursor: pointer;
        }

        .hotel-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .hotel-card {
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .hotel-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .hotel-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 4px solid #4ecdc4;
        }

        .hotel-info {
            padding: 20px;
        }

        .hotel-info h3 {
            font-size: 1.4rem;
            color: #2d3436;
            margin-bottom: 10px;
        }

        .hotel-location {
            color: #636e72;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .hotel-location i {
            margin-right: 8px;
            color: #ff6b6b;
        }

        .hotel-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
        }

        .hotel-price {
            font-weight: 700;
            font-size: 1.3rem;
            color: #0984e3;
        }

        .hotel-rating {
            background: linear-gradient(45deg, #ffc048, #ff9f1a);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .hotel-rating i {
            margin-right: 5px;
        }

        .hotel-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            text-align: center;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        .hotel-btn:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            transform: scale(1.03);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: white;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .user-info {
                top: 15px;
                right: 15px;
                padding: 8px 15px;
                flex-direction: column;
                gap: 8px;
            }
            
            .search-filter {
                flex-direction: column;
            }
            
            .search-box {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .hotel-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<!-- NEW USER INFO SECTION -->
<div class="user-info">
    <span>Welcome, <?php echo $username; ?>!</span>
    <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<div class="header">
    <h1>Luxury Stays</h1>
    <p>Discover the finest hotels for your perfect getaway</p>
</div>

<div class="search-filter">
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search hotels by name or location...">
    </div>
    <div class="filter-box">
        <select id="priceFilter">
            <option value="">Filter by Price</option>
            <option value="low">Low to High</option>
            <option value="high">High to Low</option>
        </select>
    </div>
</div>

<div class="hotel-container">
    <?php foreach ($hotels as $hotel): ?>
        <div class="hotel-card">
            <img src="<?php echo $hotel->getImage(); ?>" alt="<?php echo $hotel->getName(); ?>" class="hotel-image">
            <div class="hotel-info">
                <h3><?php echo $hotel->getName(); ?></h3>
                <p class="hotel-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo $hotel->getLocation(); ?>
                </p>
                <div class="hotel-meta">
                    <div class="hotel-price">Rs. <?php echo $hotel->getPrice(); ?></div>
                    <div class="hotel-rating">
                        <i class="fas fa-star"></i>
                        <?php echo $hotel->getRating(); ?>
                    </div>
                </div>
                <p class="room-info">Per night for 2 adults</p>
                <a href="book_room.php?hotel=<?php echo urlencode($hotel->getName()); ?>&price=<?php echo urlencode($hotel->getPrice()); ?>" 
                   class="hotel-btn">Book Now <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="footer">
    <p>© 2023 Luxury Stays. All rights reserved.</p>
</div>

<script>
    // Simple search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const hotels = document.querySelectorAll('.hotel-card');
        
        hotels.forEach(hotel => {
            const name = hotel.querySelector('h3').textContent.toLowerCase();
            const location = hotel.querySelector('.hotel-location').textContent.toLowerCase();
            
            if (name.includes(searchText) || location.includes(searchText)) {
                hotel.style.display = 'block';
            } else {
                hotel.style.display = 'none';
            }
        });
    });

    // Price filter functionality
    document.getElementById('priceFilter').addEventListener('change', function() {
        const value = this.value;
        const hotelContainer = document.querySelector('.hotel-container');
        const hotels = Array.from(document.querySelectorAll('.hotel-card'));
        
        if (value === 'low') {
            hotels.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('.hotel-price').textContent.replace('Rs. ', '').replace(',', ''));
                const priceB = parseFloat(b.querySelector('.hotel-price').textContent.replace('Rs. ', '').replace(',', ''));
                return priceA - priceB;
            });
        } else if (value === 'high') {
            hotels.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('.hotel-price').textContent.replace('Rs. ', '').replace(',', ''));
                const priceB = parseFloat(b.querySelector('.hotel-price').textContent.replace('Rs. ', '').replace(',', ''));
                return priceB - priceA;
            });
        }
        
        // Clear and re-append sorted hotels
        hotelContainer.innerHTML = '';
        hotels.forEach(hotel => hotelContainer.appendChild(hotel));
    });
</script>

</body>
</html>