<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\FriendshipRepository")
 * @ORM\Table(name="friendship")
 */
class Friendship
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Profile")
     **/    
    protected $profile_1;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Profile")
     **/
    protected $profile_2;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $favorite;

    /**
     * Set favorite
     *
     * @param boolean $favorite
     * @return Friendship
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get favorite
     *
     * @return boolean 
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set profile_1
     *
     * @param \Application\Entity\Profile $profile1
     * @return Friendship
     */
    public function setProfile1(\Application\Entity\Profile $profile1)
    {
        $this->profile_1 = $profile1;

        return $this;
    }

    /**
     * Get profile_1
     *
     * @return \Application\Entity\Profile 
     */
    public function getProfile1()
    {
        return $this->profile_1;
    }

    /**
     * Set profile_2
     *
     * @param \Application\Entity\Profile $profile2
     * @return Friendship
     */
    public function setProfile2(\Application\Entity\Profile $profile2)
    {
        $this->profile_2 = $profile2;

        return $this;
    }

    /**
     * Get profile_2
     *
     * @return \Application\Entity\Profile 
     */
    public function getProfile2()
    {
        return $this->profile_2;
    }
}
