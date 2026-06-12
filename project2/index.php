<?php
$page = 'Home';
require_once __DIR__ . '/header.php';

// Fetch featured cars (top 6)
$stmt = $pdo->query("SELECT * FROM cars WHERE available = 1 ORDER BY created_at DESC LIMIT 6");
$featured = $stmt->fetchAll();

// Categories for the search slider
$cats = $pdo->query("SELECT DISTINCT category FROM cars ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>

<!-- HERO -->
<section class="hero">
  <div class="container hero-content">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">Premium Car Rentals</span>
        <h1>Drive your <span class="grad">dream car</span> today.</h1>
        <p class="lead mt-3">Choose from a curated fleet of luxury, electric and economy cars. Book in seconds, drive in style.</p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="cars.php" class="btn btn-primary-grad"><i class="bi bi-search"></i> Browse Cars</a>
          <a href="#search" class="btn btn-ghost"><i class="bi bi-calendar-check"></i> Quick Booking</a>
        </div>
      </div>

      <!-- SEARCH SLIDER FORM -->
      <div class="col-lg-5" id="search">
        <form class="search-card" action="cars.php" method="get">
          <h5 class="fw-bold mb-3">Find your car</h5>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
              <option value="">All Categories</option>
              <?php foreach ($cats as $c): ?>
                <option value="<?= e($c) ?>"><?= e($c) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Max Price / day: <span id="priceLbl" class="text-warning fw-bold">$200</span></label>
            <input type="range" name="max_price" min="20" max="500" value="200" step="10" class="form-range"
                   oninput="document.getElementById('priceLbl').textContent='$'+this.value">
          </div>
          <div class="row g-2 mb-3">
            <div class="col"><label class="form-label">Pick-up</label><input type="date" name="pickup" class="form-control"></div>
            <div class="col"><label class="form-label">Return</label><input type="date" name="ret" class="form-control"></div>
          </div>
          <button class="btn btn-primary-grad w-100"><i class="bi bi-search"></i> Search Cars</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="bg-black-50">
  <div class="container">
    <div class="text-center mb-5 fade-up">
      <h2 class="section-title">Why choose DriveLux</h2>
      <p class="section-sub">Built for travelers who value time, style and reliability.</p>
    </div>
    <div class="row g-4">
      <?php
      $features = [
        ['bi-lightning-charge-fill','Instant Booking','Confirm your rental in under 60 seconds.'],
        ['bi-shield-check','Fully Insured','All vehicles covered with premium insurance.'],
        ['bi-cash-coin','Best Prices','Transparent pricing, automatic multi-day discounts.'],
        ['bi-headset','24/7 Support','We are always one call away, anywhere you drive.'],
      ];
      foreach ($features as $f): ?>
        <div class="col-md-6 col-lg-3 fade-up">
          <div class="feature">
            <div class="ico"><i class="bi <?= $f[0] ?>"></i></div>
            <h5 class="fw-bold"><?php echo e($f[1]); ?></h5>
            <p class="text-secondary mb-0"><?php echo e($f[2]); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FEATURED CAROUSEL SLIDER -->
<section id="fleet">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-4 fade-up">
      <div>
        <h2 class="section-title">Featured fleet</h2>
        <p class="section-sub mb-0">Hand-picked vehicles ready for your next trip.</p>
      </div>
      <a href="cars.php" class="btn btn-ghost d-none d-md-inline-flex">View all <i class="bi bi-arrow-right"></i></a>
    </div>

    <div id="fleetSlider" class="carousel slide fade-up" data-bs-ride="carousel" data-bs-interval="4500">
      <div class="carousel-inner">
        <?php
        $chunks = array_chunk($featured, 3);
        foreach ($chunks as $i => $group): ?>
          <div class="carousel-item <?php echo $i === 0 ? 'active' : '' ?>">
            <div class="row g-4">
              <?php foreach ($group as $car): ?>
                <div class="col-md-4">
                  <div class="car-card">
                    <div class="img">
                      <span class="badge-cat"><?php echo e($car['category']); ?></span>
                      <img src="<?php echo e(car_image_url($car['image'])); ?>" alt="<?php echo e($car['brand'].' '.$car['model']); ?>">
                    </div>
                    <div class="body">
                      <h5><?php echo e($car['brand'].' '.$car['model']); ?></h5>
                      <small class="text-secondary"><?php echo e($car['year']); ?> · <?php echo e($car['transmission']); ?></small>
                      <div class="meta">
                        <span><i class="bi bi-people"></i> <?php echo (int)$car['seats']; ?></span>
                        <span><i class="bi bi-fuel-pump"></i> <?php echo e($car['fuel']); ?></span>
                        <span><i class="bi bi-gear"></i> <?php echo e($car['transmission']); ?></span>
                      </div>
                      <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="price">$<?php echo number_format($car['price_per_day'],2); ?> <small>/day</small></div>
                        <a href="car.php?id=<?php echo (int)$car['id']; ?>" class="btn btn-primary-grad btn-sm">Book</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if (count($chunks) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#fleetSlider" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#fleetSlider" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section id="about" class="bg-black-50">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 fade-up">
        <img src="https://images.unsplash.com/photo-1493238792000-8113da705763?w=1000&q=80" class="img-fluid rounded-4 shadow">
      </div>
      <div class="col-lg-6 fade-up">
        <h2 class="section-title mb-3">Built around your journey</h2>
        <p class="text-secondary">From electric city runners to luxury SUVs for road trips, our fleet is maintained to factory standards and inspected before every booking.</p>
        <ul class="list-unstyled mt-4">
          <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Free cancellation up to 24h</li>
          <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Unlimited mileage on all rentals</li>
          <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Pickup & delivery at any location</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
