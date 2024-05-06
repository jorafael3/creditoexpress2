<?php

?>

<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <base href="" />
    <meta charset="utf-8" />
    <title>Crédito Express</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?php echo constant('URL') ?>public/img/SV24 - Logos LC_Icon.png" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used by this page)-->
    <link href="<?php echo constant('URL') ?>public/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="<?php echo constant('URL') ?>public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo constant('URL') ?>public/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" data-kt-app-header-stacked="true" class="app-default bg-light">
    <!--begin::Theme mode setup on page load-->
    <script>

        var defaultThemeMode = "light";
        var themeMode;
        
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->

    <!--begin::Content-->
    <div id="kt_app_content" class="bg-light">
        <!--begin::Row-->