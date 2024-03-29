<?php
// include('database.inc.php');
// include('function.inc.php');
// include('constant.inc.php');
include('top.php');
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
                
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode[0]["code"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
        break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["code"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
        break;
        case "empty":
            unset($_SESSION["cart_item"]);
        break;	
    }
    }
?>

        <!-- <div class="slider-area">
            <div class="slider-active owl-dot-style owl-carousel">
                <?php
				$banner_res=mysqli_query($con,"select * from banner where status='1' order by order_number");
				while($banner_row=mysqli_fetch_assoc($banner_res)){
				?>
				<div class="single-slider pt-210 pb-220 bg-img" style="background-image:url(<?php echo SITE_BANNER_IMAGE.$banner_row['image']?>);">
                    <div class="container">
                        <div class="slider-content slider-animated-1">
                            <h1 class="animated"><?php echo $banner_row['heading']?></h1>
                            <h3 class="animated"><?php echo $banner_row['sub_heading']?></h3>
                            <div class="slider-btn mt-90">
                                <a class="animated" href="<?php echo $banner_row['link']?>"><?php echo $banner_row['link_txt']?></a>
                            </div>
                        </div>
                    </div>
                </div>
				<?php } ?>
            </div>
        </div> -->





<!-- home section starts  -->

<section class="home" id="home">

    <div class="content">
        <span>welcome foodies</span>
        <h3>different spices for the different tastes 😋</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis unde dolores temporibus hic quam debitis tenetur harum nemo.</p>
        <!-- <a href="#" class="btn">order now</a> -->
    </div>

    <div class="image">
        <img src="image/home-img.png" alt="" class="home-img">
        <img src="image/home-parallax-img.png" alt="" class="home-parallax-img">
    </div>

</section>

<!-- home section ends  -->

<!-- category section starts  -->

<section class="category">
    <?php 
    global $con;
	$sql="SELECT id,category,category_image FROM category where status=1 ORDER BY order_number";
	$res=mysqli_query($con,$sql);
	
	while($row=mysqli_fetch_assoc($res)){
		?>
        <a href="<?php echo FRONT_SITE_PATH?>dish_show?id=<?php echo $row['id'] ?>" class="box">
        <img src="image/cat_img/<?php echo ($row['category_image']); ?>" alt="Category Image">       
        <h3><?php echo $row['category']?></h3>
        </a> 
	<?php } ?>
</section>

<!-- category section ends -->

<!-- about section starts  -->

<section class="about" id="about">

    <div class="image">
        <img src="image/about-img.png" alt="">
    </div>

    <div class="content">
        <span>why choose us?</span>
        <h3 class="title">what's make our food delicious!</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos ut explicabo, numquam iusto est a ipsum assumenda tempore esse corporis?</p>
        <a href="#" class="btn">read more</a>
        <div class="icons-container">
            <div class="icons">
                <img src="image/serv-1.png" alt="">
                <h3>fast delivery</h3>
            </div>  
            <div class="icons">
                <img src="image/serv-2.png" alt="">
                <h3>fresh food</h3>
            </div>   
            <div class="icons">
                <img src="image/serv-3.png" alt="">
                <h3>best quality</h3>
            </div>  
            <div class="icons">
                <img src="image/serv-4.png" alt="">
                <h3>24/7 support</h3>
            </div>           
        </div>
    </div>

</section>

<!-- about section ends -->

        <!-- popular section starts  -->

<section class="popular" id="popular">

<div class="heading">
    <span>popular food</span>
    <h3>our special dishes</h3>
</div>

<div class="box-container">

<?php 
    global $con;
	//$sql="SELECT dish.id,dish.category_id,dish.dish,dish.image,dish.type,dish_details.attribute,dish_details.price FROM dish,dish_details where dish.id=dish_details.dish_id AND dish.status=1 and dish_details.status=1 ORDER BY dish.added_on DESC LIMIT 8";
    $sql="SELECT * FROM restaurants";
	$res=mysqli_query($con,$sql);
	
	while($row=mysqli_fetch_assoc($res)){
		?>
             <div class="box">
        <a href="#" class="fas fa-heart"></a>
        <div class="image">
            <img src="image/resturant_logo/<?php echo ($row['logo']); ?>" alt="Image">
        </div>
        <div class="content">
            <h3><?php echo $row['name']?></h3>
            <p style="font-size: 15px;"><?php echo $row['address'] ?></p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span> (50) </span>
            </div>
            <div class="price">Ph: <?php echo $row['phone']?></div>
            <a href="<?php echo FRONT_SITE_PATH?>all_dish?id=<?php echo $row['r_id'] ?>" class="btn">View all Dish</a>
        </div>
    </div>
        <?php } ?>
</div>

</section>

<!-- popular section ends -->
      
<?php 
include('footer.php');
?>

    
<!-- Comment -->