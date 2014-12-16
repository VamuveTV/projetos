<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Profile;
use Doctrine\Common\Collections\ArrayCollection;

class FriendshipRepository extends EntityRepository
{
    /**
     * Obtém uma lista de Ids dos amigos de um dado perfil.
     * @param Profile $profile
     * @return unknown
     */
	public function getFriendsOf(Profile $profile) {
	    $q = 'SELECT (f.profile_2) FROM Application\Entity\Friendship f WHERE f.profile_1 = :profile_id';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		$friendships = $q->getResult();
		
		$q = 'SELECT (f.profile_1) FROM Application\Entity\Friendship f WHERE f.profile_2 = :profile_id';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		//$friendships_2 = $q->getResult();
				
		$friendships = array_merge($friendships, $q->getResult());
        
		
		return $friendships;
	}

	/**
	 * Obtém uma lista de entities dos amigos (profile) favoritos de um dado perfil.
	 * @param Profile $profile
	 * @return unknown
	 */
	public function getFavoriteFriendsOf(Profile $profile) {
		$q = 'SELECT p FROM Application\Entity\Friendship f '.
    		'JOIN Application\Entity\Profile p '.
    		'WITH p.id=f.profile_2 '.
    		'WHERE f.profile_1 = :profile_id AND f.favorite=1';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		$friendships = $q->getResult();
	
		$q = 'SELECT p FROM Application\Entity\Profile p '.
        	'JOIN Application\Entity\Friendship f '.
        	'WITH p.id=f.profile_1 '.
		    'WHERE f.profile_2 = :profile_id AND f.favorite=1';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		//$friendships_2 = $q->getResult();
	
		$friendships = array_merge($friendships, $q->getResult());
	
	
		return $friendships;
	}

	/**
	 * Obtém uma lista de entities dos amigos (profile) favoritos de um dado perfil.
	 * @param Profile $profile
	 * @return unknown
	 */
	public function getAllFriendsOf(Profile $profile) {
		$q = 'SELECT p FROM Application\Entity\Friendship f '.
    		'JOIN Application\Entity\Profile p '.
    		'WITH p.id=f.profile_2 '.
    		'WHERE f.profile_1 = :profile_id';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		$friendships = $q->getResult();
	
		$q = 'SELECT p FROM Application\Entity\Profile p '.
        	'JOIN Application\Entity\Friendship f '.
        	'WITH p.id=f.profile_1 '.
		    'WHERE f.profile_2 = :profile_id';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		//$friendships_2 = $q->getResult();
	
		$friendships = array_merge($friendships, $q->getResult());
	
	
		return $friendships;
	}
	
	// Obtém uma lista de Ids dos amigos de um dado perfil.
	/*public function getFriendsAndSchoolOf(Profile $profile) {
		$q = 'SELECT p FROM Application\Entity\Profile p '.
    		'JOIN Application\Entity\Friendship f '.
    		'JOIN Application\Entity\School s '.
    		'WITH p.id=f.profile_2 AND s.profile=f.profile_1 '.
    		'WHERE f.profile_1 = :profile_id '.
    		'AND s.id IN '.
        		'(SELECT IDENTITY(se.school) FROM Application\Entity\StudentEnrollment se '.
        		'JOIN se.user u WHERE se.user=:profile_id)';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		$friendships = $q->getResult();
        die(var_dump($friendships));
		$q = 'SELECT p FROM Application\Entity\Profile p '.
        	'JOIN Application\Entity\Friendship f '.
        	'JOIN Application\Entity\School s '.
        	'WITH p.id=f.profile_1 AND s.profile=f.profile_1 '.
		    'WHERE f.profile_2 = :profile_id '.
        	'AND s.id IN '.
            	'(SELECT IDENTITY(se.school) FROM Application\Entity\StudentEnrollment se '.
            	'JOIN se.user u WHERE se.user=:profile_id)';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		//$friendships_2 = $q->getResult();
	
		$friendships = array_merge($friendships, $q->getResult());

		die(var_dump($friendships));
		return $friendships;
	}*/
	
    /**
     * Obtém perfil de amigo pelo nome
     * @param unknown $name
     * @return multitype:
     */
	public function getFriendByName(Profile $profile, $name) {
	    $q = 'SELECT p FROM Application\Entity\Profile p '.
   	        'JOIN Application\Entity\Friendship f '.
   	        'WITH p.id = f.profile_2 '.
            'WHERE f.profile_1 = :profile_id AND p.display_name = :pname ';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		$q->setParameter('pname', $name);
		$friendships = $q->getResult();
		
		//$q = 'SELECT (f.profile_1) FROM Application\Entity\Friendship f WHERE f.profile_2 = :profile_id';
	    $q = 'SELECT p FROM Application\Entity\Profile p '.
   	        'JOIN Application\Entity\Friendship f '.
   	        'WITH p.id = f.profile_1 '.
            'WHERE f.profile_2 = :profile_id AND p.display_name = :pname ';
		$q = $this->_em->createQuery($q);
		$q->setParameter('profile_id', $profile->getId());
		$q->setParameter('pname', $name);
				
		$friendships = array_merge($friendships, $q->getResult());
        
		
		return $friendships;
	}
    
	public function checkFriendship($profile1_id, $profile2_id)
	{
	    $qb = $this->createQueryBuilder('check_friendship');
	    $qb->select('f')
    	    ->from('Application\Entity\Friendship', 'f')
    	    ->where('f.profile_1 = :profile1')
    	    ->andWhere('f.profile_2 = :profile2')
    	    ->setParameter('profile1', $profile1_id)
	        ->setParameter('profile2', $profile2_id);
	    $query = $qb->getQuery();
	    $friendship = $query->execute();
	    	    
	    if (count($friendship) > 0)
	    {
	        return true;
	    }
	    
	    $qb
    	    ->setParameter('profile1', $profile2_id)
    	    ->setParameter('profile2', $profile1_id);
	    $query = $qb->getQuery();
	    $friendship = $query->execute();
	    
	    return count($friendship) > 0;
	}
}