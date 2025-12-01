<?php
$title = "About Us - Harvest";
$description = "Learn more about Your Website Name, our mission, values, and story.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $description; ?>">
    <title><?php echo $title; ?></title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include('header.php'); ?>

<main>

	<section class="overview">
	<h2> Meet the Team</h2>
        <p>Our Dedicated Team At Harvest, we are proud to have a passionate and diverse team committed to our mission. Each member brings unique skills and experiences that contribute to our collective effort to combat food insecurity.</p>
    </section>
       
        <div class = " members" >
        
        <div class = "member_info">
        <h2> [Ng Wen Jien] - Leader </h2>
        <p>VIRGIL has over 2 years of experience in non-profit management and community outreach. With a background in social work and public health, he is passionate about addressing food insecurity and advocating for sustainable food systems. Under her leadership, Harvest has expanded its food distribution initiatives and developed strong partnerships with local farmers.</p>
        </div>
          
        <div class = "member_info">
        <h2> [Chia Yong Qi] - Member </h2>
        <p>YONG QI brings a wealth of experience in community organizing and volunteer management. With a degree in Environmental Studies, he is committed to promoting sustainable agricultural practices and building community resilience. He has successfully launched multiple community garden projects and educational workshops that educate residents about healthy eating and food production.</p>
		</div>
		
        <div class = "member_info">
        <h2> [Benjamin Chin Tse Yuen] - Member </h2>
        <p>BEN has a background in nutrition and public policy, and he has been with Harvest for five years. As Program Manager, he oversees the organization’s food distribution programs and educational initiatives.</p>
        
        </div>
        
        </div>
	
    <section class="overview">
        <h2> ABOUT US </h2>
        <p>At Harvest, we are deeply committed to addressing food insecurity by ensuring that everyone has access to sustainable and nutritious food resources. Our efforts go beyond just providing food; we aim to create lasting solutions that empower individuals and communities to thrive. Through innovative approaches, we support local farmers, reduce food waste, and strengthen food distribution networks to reach those in need.</p>
    </section>
    <section class="overview">
        <h2> Mission </h2>
        <p>Our mission is to eliminate hunger and food insecurity by creating a world where nutritious and sustainable food is accessible to all. We strive to achieve this by connecting local farmers with communities, ensuring that fresh, healthy produce reaches those who need it most. Through educational programs, we empower individuals and families to adopt sustainable practices that not only benefit their health but also nurture the environment.
        We believe that everyone deserves the opportunity to make informed choices about their food, and we are committed to fostering partnerships that bridge gaps in the food system. By collaborating with farmers, organizations, and community leaders, we aim to build resilient food networks that uplift local economies, reduce waste, and promote long-term sustainability. Together, we are working toward a future where hunger is eradicated, and everyone has the knowledge and resources to lead a nourished and fulfilling life.</p>
    </section>
    <section class="overview">
        <h2> Donate Team </h2>	
        <p>Our Donate Team works tirelessly to ensure that every contribution is effectively utilized to fight hunger in our communities. Through partnerships
         with local organizations and transparent financial practices, we maximize the impact of every donation.</p>
 	</section>

 

 <?php include('footer.php'); ?>
<script src="/FinalAssignment/Harvest/script.js?v=1"></script>
</main>
</body>
</html>