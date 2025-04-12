<?php $__env->startSection('content'); ?>
<style>
    .about-hero {
        text-align: center;
        padding: 60px 20px 40px;
        background-color: #f5fdfc;
    }

    .about-hero h2 {
        font-size: 36px;
        font-weight: 700;
        color: #003B3B;
        margin-bottom: 10px;
    }

    .about-hero p {
        font-size: 18px;
        color: #555;
        max-width: 700px;
        margin: 0 auto;
    }

    .mission-section {
        padding: 50px 20px;
        background-color: #ffffff;
    }

    .mission-card {
        border-radius: 16px;
        padding: 30px;
        background-color: #e7f5f2;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .mission-card h4 {
        color: #007872;
        font-weight: 700;
    }

    .mission-card p {
        color: #444;
        font-size: 16px;
        margin-top: 10px;
    }

    .team-section {
        background: #f9fafa;
        padding: 60px 20px;
    }

    .team-title {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        color: #003B3B;
        margin-bottom: 30px;
    }

    .team-card {
        text-align: center;
        padding: 20px;
        background-color: white;
        border-radius: 14px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    }

    .team-card img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .team-card h6 {
        margin-bottom: 4px;
        font-weight: 600;
    }

    .team-card small {
        color: #666;
    }
</style>

<!-- Hero Section -->
<div class="about-hero">
    <h2>About Airscape</h2>
    <p>We are a passionate team committed to providing accurate and real-time air quality data to help people breathe better and live healthier lives.</p>
</div>

<!-- Mission Section -->
<div class="mission-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mission-card">
                    <h4>🌍 Our Mission</h4>
                    <p>To empower communities through transparent air quality insights, promoting environmental responsibility and better health decisions.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mission-card">
                    <h4>📈 What We Do</h4>
                    <p>We collect, simulate, and display real-time AQI data from sensors deployed in urban areas using cutting-edge technology and intuitive interfaces.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Team Section -->
<div class="team-section">
    <div class="container">
        <div class="team-title">Meet Our Team</div>
        <div class="row g-4">
            <?php
                $team = [
                    ['name' => 'Akila Lakshitha', 'role' => 'Frontend Developer', 'img' => asset('assests/team1.jpg')],
                    ['name' => 'Thanuga Soysa', 'role' => 'Backend Developer', 'img' => asset('assests/team1.jpg')],
                    ['name' => 'Janudi Meegoda', 'role' => 'UI/UX Designer', 'img' => asset('assets/user3.jpg')],
                    ['name' => 'Yenuli Tharandi', 'role' => 'QA & Research', 'img' => asset('assets/user4.jpg')],
                ];
            ?>

            <?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-6 col-md-3">
                    <div class="team-card">
                        <img src="<?php echo e($member['img']); ?>" alt="<?php echo e($member['name']); ?>">
                        <h6><?php echo e($member['name']); ?></h6>
                        <small><?php echo e($member['role']); ?></small>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\Airscape\resources\views/pages/user/about.blade.php ENDPATH**/ ?>