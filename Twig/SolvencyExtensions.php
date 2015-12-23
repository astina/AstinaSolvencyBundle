<?php

namespace Astina\Bundle\SolvencyBundle\Twig;

use Astina\Bundle\PromotionsBundle\Entity\SellablePromotion;
use Astina\Bundle\PromotionsBundle\Entity\SellablePromotionRepository;
use Astina\Bundle\ShopBundle\Model\CartItem;
use Astina\Bundle\ShopBundle\Model\Sellable;
use Astina\Bundle\ShopBundle\Model\StoreProductVariant;
use Astina\Bundle\ShopBundle\Model\StoreCategory;
use Astina\Bundle\ShopBundle\Model\StoreProduct;
use Astina\Bundle\ShopBundle\Customer\CustomerServiceInterface;
use Astina\Bundle\ShopBundle\Product\DefaultPriceFinder;
use Astina\Bundle\ShopBundle\Util\MoneyFormatter;

use Babymueller\ShopBundle\Store\DiaforaResolver;
use Babymueller\ShopBundle\Entity\Customer;
use Babymueller\ShopBundle\Entity\CustomerCredit;
use Babymueller\ShopBundle\Entity\GroupedProduct;
use Babymueller\ShopBundle\Entity\GroupedProductSellable;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Intl\Intl;

class SolvencyExtensions extends \Twig_Extension
{

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'street_number'         => new \Twig_Filter_Method($this, 'streetNumber'),
            'street_name'           => new \Twig_Filter_Method($this, 'streetName'),
            'country_convert'          => new \Twig_Filter_Method($this, 'convertCountry'),
        );
    }

    public function streetNumber($street) {
        return trim(preg_replace("/[^0-9]/","",$street));
    }

    public function streetName($street) {
        return trim(preg_replace("/[0-9]/","",$street));
    }

    /**
     *
     * convert country ISO-3 to ISO-2
     *
     * @param $country
     * @return null|string
     */
    public function convertCountry($country)
    {
        $c = null;

        switch ($country) {
            case 'CHE' :
                $c = "CH";
                break;
            case 'DEU' :
                $c = "DE";
                break;
        }

        return $c;
    }

    public function getName() {
        return 'astina_solvency';
    }
}
