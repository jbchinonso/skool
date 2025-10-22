<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package skool
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta charset = "utf-8" >
    <meta content = "width=device-width, initial-scale=1.0"name = "viewport" >
    <meta content = ""name = "keywords" >
    <meta content = ""name = "description" >

    <!--Favicon-->
    <link href = "img/favicon.ico"rel = "icon" >

    <!--Google WebFonts-->
    <link rel  = "preconnect"href  = "https://fonts.googleapis.com" >
    <link rel  = "preconnect"href  = "https://fonts.gstatic.com"crossorigin >
    <link href = "https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"rel = "stylesheet" >

    <!--Icon FontStylesheet-->
    <link href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"rel = "stylesheet" >
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"rel = "stylesheet" >

    <!--Libraries Stylesheet-->
    <link href = "lib/animate/animate.min.css"rel = "stylesheet" >
    <link href = "lib/owlcarousel/assets/owl.carousel.min.css"rel = "stylesheet" >

    <!--Customized BootstrapStylesheet-->
    <link href = "css/bootstrap.min.css"rel = "stylesheet" >


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'skool' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php the_custom_logo(); ?>
			    <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>SkoolForce</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class  = "navbar-nav ms-auto p-4 p-lg-0" >
                    <?php
                        wp_nav_menu(
                            [
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
                                'menu_class'     => 'navbar-nav ms-auto p-4 p-lg-0',
                                'walker'         => new Bootstrap_Nav_Walker(),
                            ]
                        );
                    ?>
            </div>
            
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->
		
		</div><!-- .site-branding -->
	</header><!-- #masthead -->
