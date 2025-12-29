<?php
// Default values if not set by the page
$pageTitle = isset($pageTitle) ? $pageTitle : "Lexora Tech | Creative Design & Tech Solutions";
$pageDesc  = isset($pageDesc) ? $pageDesc : "Lexora Tech specializes in UI/UX design, web development, branding, and digital marketing. We transform ideas into masterpieces.";
$pageImg   = isset($pageImg) ? $pageImg : "img/logo/logo.png"; 
$pageUrl   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="description" content="<?php echo htmlspecialchars($pageDesc); ?>">
<link rel="canonical" href="<?php echo $pageUrl; ?>">

<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo $pageUrl; ?>">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($pageDesc); ?>">
<meta property="og:image" content="<?php echo htmlspecialchars($pageImg); ?>">

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo $pageUrl; ?>">
<meta property="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
<meta property="twitter:description" content="<?php echo htmlspecialchars($pageDesc); ?>">
<meta property="twitter:image" content="<?php echo htmlspecialchars($pageImg); ?>">

<link rel="stylesheet" href="css/plugins/bootstrap-grid.css">
<link rel="stylesheet" href="css/plugins/fontawesome.min.css">
<link rel="stylesheet" href="css/plugins/swiper.min.css">
<link rel="stylesheet" href="css/style-stylish.css">
<?php if(isset($extraCss)) { echo $extraCss; } ?>

<title><?php echo htmlspecialchars($pageTitle); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3130344952697641"
     crossorigin="anonymous"></script>