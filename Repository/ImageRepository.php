<?php
/**
 * This file is part of the IrishDan\ResponsiveImageBundle package.
 *
 * (c) Daniel Byrne <danielbyrne@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source
 * code.
 */

namespace IrishDan\ResponsiveImageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use IrishDan\ResponsiveImageBundle\ResponsiveImageRepositoryInterface;

/**
 * Class ImageRepository
 *
 * @package IrishDan\ResponsiveImageBundle\Repository
 */
class ImageRepository extends EntityRepository implements ResponsiveImageRepositoryInterface
{
    /**
     * @param $filename
     *
     * @return mixed
     */
    public function findImageFromFilename($filename)
    {
        return $this->findOneByPath($filename);
    }
}
