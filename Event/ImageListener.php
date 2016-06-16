<?php

namespace ResponsiveImageBundle\Event;

use ResponsiveImageBundle\Event\ImageEvent;

/**
 * Class ImageListener
 *
 * @package ResponsiveImageBundle\Event
 */
class ImageListener {
    /**
     * @var
     */
    private $config;

    /**
     * @var
     */
    private $imageManager;

    /**
     * ImageListener constructor.
     *
     * @param $config
     * @param $imageManager
     */
    public function __construct($config, $imageManager)
    {
        $this->config = $config;
        $this->imageManager = $imageManager;
    }

    /**
     * Generates styled images of an image object.
     *
     * @param \ResponsiveImageBundle\Event\ImageEvent $event
     */
    public function imageGenerateStyled(ImageEvent $event) {
        $image = $event->getImage();
        $style = NULL;

        if (method_exists($event, 'getStyle')) {
            if (!empty($event->getStyle())) {
                $style = $event->getStyle();
            }
        }
        
        $this->imageManager->createStyledImages($image, $style);
        // $this->imageManager->alterImagesArray();
        // $this->imageManager->doS3Transfer();
    }

    /**
     * Delete all images including the original.
     *
     * @param \ResponsiveImageBundle\Event\ImageEvent $event
     */
    public function imageDeleteAll(ImageEvent $event)
    {
        $image = $event->getImage();
        if (!empty($image)) {
            $this->imageManager->deleteImageAllFiles($image);
        }
    }

    /**
     * Delete the original.
     *
     * @param \ResponsiveImageBundle\Event\ImageEvent $event
     */
    public function imageDeleteOriginal(ImageEvent $event)
    {
        $image = $event->getImage();
        if (!empty($image)) {
            $this->imageManager->deleteImageOriginalFiles($image);
        }
    }

    /**
     * Delete styled images fof an object.
     *
     * @param \ResponsiveImageBundle\Event\ImageEvent $event
     */
    public function imageDeleteStyled(ImageEvent $event)
    {
        $image = $event->getImage();
        if (!empty($image)) {
            $this->imageManager->deleteImageStyledFiles($image);
        }
    }

    /**
     * Delete all images of given style.
     *
     * @param \ResponsiveImageBundle\Event\ImageEvent $event
     */
    public function styleDeleteStyled(ImageEvent $event) {
        $styles = $event->getStyles();
        if (!empty($styles)) {
            $this->imageManager->deleteStyleFiles($styles);
        }
    }

    /**
     * Delete all styled images for all styles.
     */
    public function styleDeleteAll() {

    }
}