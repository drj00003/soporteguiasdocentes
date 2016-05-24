<?php
// src/GuiasDocentes/AppBundle/Twig/AppExtension.php
namespace GuiasDocentes\AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            // <!--new \Twig_SimpleFilter('ebase64', array($this, 'priceFilter')),-->
            new \Twig_SimpleFilter('dbase64', 'base64_decode'),
            new \Twig_SimpleFilter('ebase64', 'base64_encode'),
        );
    }

    // <!--public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')-->
    // <!--{-->
    // <!--    $price = number_format($number, $decimals, $decPoint, $thousandsSep);-->
    // <!--    $price = '$'.$price;-->

    // <!--    return $price;-->
    // <!--}-->

    public function getName()
    {
        return 'app_extension';
    }
}
