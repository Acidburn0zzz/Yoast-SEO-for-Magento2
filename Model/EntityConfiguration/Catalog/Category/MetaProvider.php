<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 3.0).
 * This license is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/gpl-3.0.en.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category    Maxserv: MaxServ_YoastSeo
 * @package     Maxserv: MaxServ_YoastSeo
 * @author      Vincent Hornikx <vincent.hornikx@maxserv.com>
 * @copyright   Copyright (c) 2017 MaxServ (http://www.maxserv.com)
 * @license     http://opensource.org/licenses/gpl-3.0.en.php General Public License (GPL 3.0)
 *
 */

namespace MaxServ\YoastSeo\Model\EntityConfiguration\Catalog\Category;

use Magento\Catalog\Block\Product\ListProduct;
use MaxServ\YoastSeo\Model\EntityConfiguration\AbstractMetaProvider;

class MetaProvider extends AbstractMetaProvider
{

    /**
     * @var \Magento\Catalog\Model\Category
     */
    protected $category;

    /**
     * @return \Magento\Catalog\Model\Category
     */
    public function getCategory()
    {
        if (empty($this->category)) {
            $this->category = $this->registry->registry('current_category');
        }

        return $this->category;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'product.group';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getCategory()->getUrl();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if (empty($this->title)) {
            $this->title = $this->getFirstAvailableValue(
                $this->getCategory()->getMetaTitle(),
                $this->getCategory()->getName()
            );
        }

        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        if (empty($this->description)) {
            $this->description = $this->getFirstAvailableValue(
                $this->getCategory()->getMetaDescription(),
                $this->getCategory()->getDescription()
            );
        }

        return $this->description;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImage()
    {
        if (empty($this->image)) {
            $this->image = $this->getCategory()->getImageUrl();
        }

        return $this->image;
    }

    /**
     * @return string
     */
    public function getOpenGraphTitle()
    {
        return $this->getFirstAvailableValue(
            $this->getCategory()->getYoastFacebookTitle(),
            $this->getTitle()
        );
    }

    /**
     * @return string
     */
    public function getOpenGraphDescription()
    {
        return $this->getFirstAvailableValue(
            $this->getCategory()->getYoastFacebookDescription(),
            $this->getDescription()
        );
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOpenGraphImage()
    {
        $openGraphImage = $this->getCategory()->getYoastFacebookImage();

        if ($openGraphImage) {
            $openGraphImage = $this->imageHelper->getYoastImage($openGraphImage);
        } else {
            $openGraphImage = $this->getImage();
        }

        return $openGraphImage;
    }

    /**
     * @return array
     */
    public function getOpenGraphVideo()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getTwitterTitle()
    {
        return $this->getFirstAvailableValue(
            $this->getCategory()->getYoastTwitterTitle(),
            $this->getOpenGraphTitle(),
            $this->getTitle()
        );
    }

    /**
     * @return string
     */
    public function getTwitterDescription()
    {
        return $this->getFirstAvailableValue(
            $this->getCategory()->getYoastTwitterDescription(),
            $this->getOpenGraphDescription(),
            $this->getDescription()
        );
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTwitterImage()
    {
        $twitterImage = $this->getCategory()->getYoastTwitterImage();

        if ($twitterImage) {
            $twitterImage = $this->imageHelper->getYoastImage($twitterImage);
        } else {
            $twitterImage = $this->getOpenGraphImage();
        }

        return $twitterImage;
    }
}
