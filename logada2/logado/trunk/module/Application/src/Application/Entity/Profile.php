<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\ProfileRepository")
 * @ORM\Table(name="profile")
 */
class Profile
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = null;
    
    /**
     * @ORM\ManyToMany(targetEntity="Disability")
     **/
    protected $disabilities;
    
    /**
     * @ORM\ManyToMany(targetEntity="Evaluation")
     **/
    protected $evaluations;
    
    /**
     * @ORM\Column(type="string", length=60, nullable=false)
     **/
    protected $display_name;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     **/
    protected $heart_count;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     **/
    protected $handshake_count;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     **/
    protected $bomb_count;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     **/
    protected $star_rating;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     **/
    protected $public_star_rating;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     **/
    protected $public_bomb_rating;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->disabilities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evaluations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set display_name
     *
     * @param string $displayName
     * @return Profile
     */
    public function setDisplayName($displayName)
    {
        $this->display_name = $displayName;

        return $this;
    }

    /**
     * Get display_name
     *
     * @return string 
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Set heart_count
     *
     * @param integer $heartCount
     * @return Profile
     */
    public function setHeartCount($heartCount)
    {
        $this->heart_count = $heartCount;

        return $this;
    }

    /**
     * Get heart_count
     *
     * @return integer 
     */
    public function getHeartCount()
    {
        return $this->heart_count + 0;
    }

    /**
     * Set handshake_count
     *
     * @param integer $handshakeCount
     * @return Profile
     */
    public function setHandshakeCount($handshakeCount)
    {
        $this->handshake_count = $handshakeCount;

        return $this;
    }

    /**
     * Get handshake_count
     *
     * @return integer 
     */
    public function getHandshakeCount()
    {
        return $this->handshake_count + 0;
    }

    /**
     * Set bomb_count
     *
     * @param integer $bombCount
     * @return Profile
     */
    public function setBombCount($bombCount)
    {
        $this->bomb_count = $bombCount;

        return $this;
    }

    /**
     * Get bomb_count
     *
     * @return integer 
     */
    public function getBombCount()
    {
        return $this->bomb_count + 0;
    }

    /**
     * Set star_rating
     *
     * @param float $starRating
     * @return Profile
     */
    public function setStarRating($starRating)
    {
        $this->star_rating = $starRating;

        return $this;
    }

    /**
     * Get star_rating
     *
     * @return float 
     */
    public function getStarRating()
    {
        return $this->star_rating + 0.0;
    }

    /**
     * Set public_star_rating
     *
     * @param boolean $publicStarRating
     * @return Profile
     */
    public function setPublicStarRating($publicStarRating)
    {
        $this->public_star_rating = $publicStarRating;

        return $this;
    }

    /**
     * Get public_star_rating
     *
     * @return boolean 
     */
    public function getPublicStarRating()
    {
        return $this->public_star_rating;
    }

    /**
     * Set public_bomb_rating
     *
     * @param boolean $publicBombRating
     * @return Profile
     */
    public function setPublicBombRating($publicBombRating)
    {
        $this->public_bomb_rating = $publicBombRating;

        return $this;
    }

    /**
     * Get public_bomb_rating
     *
     * @return boolean 
     */
    public function getPublicBombRating()
    {
        return $this->public_bomb_rating;
    }

    /**
     * Add disabilities
     *
     * @param \Application\Entity\Disability $disabilities
     * @return Profile
     */
    public function addDisability(\Application\Entity\Disability $disabilities)
    {
        $this->disabilities[] = $disabilities;

        return $this;
    }

    /**
     * Remove disabilities
     *
     * @param \Application\Entity\Disability $disabilities
     */
    public function removeDisability(\Application\Entity\Disability $disabilities)
    {
        $this->disabilities->removeElement($disabilities);
    }

    /**
     * Get disabilities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDisabilities()
    {
        return $this->disabilities;
    }

    /**
     * Add evaluations
     *
     * @param \Application\Entity\Evaluation $evaluations
     * @return Profile
     */
    public function addEvaluation(\Application\Entity\Evaluation $evaluations)
    {
        $this->evaluations[] = $evaluations;

        return $this;
    }

    /**
     * Remove evaluations
     *
     * @param \Application\Entity\Evaluation $evaluations
     */
    public function removeEvaluation(\Application\Entity\Evaluation $evaluations)
    {
        $this->evaluations->removeElement($evaluations);
    }

    /**
     * Get evaluations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }
}
