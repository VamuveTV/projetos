<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
	public function getAllPosts () {
		$posts = $this->_em->createQuery('SELECT u FROM Application\Entity\Post u')->getResult();
		return $posts;
	}
	
	// posts enviados para o usuário corrente menos aqueles que foram criados por ele mesmo
	public function getPostsSentTo($profile_id)
	{
	    $qb = $this->createQueryBuilder('posts_sent_to_me');
	    $qb->select('p')
	       ->from('Application\Entity\Post', 'p')
	       ->where('p.sender != :profile')
	       ->andWhere('p.receiver = :profile')
	       ->setParameter('profile', $profile_id);
	    $query = $qb->getQuery();
	    $posts = $query->execute();
	    return $posts;
	}
	
	// posts "públicos", aqueles que foram enviados para o perfil do próprio usuário por ele mesmo
	public function getPublicPosts($profile_id)
	{
		$qb = $this->createQueryBuilder('public_posts');
		$qb->select('p')
           ->from('Application\Entity\Post', 'p')
           ->where('p.sender = :profile')
           ->andWhere('p.receiver = :profile')
           ->setParameter('profile', $profile_id);
		$query = $qb->getQuery();
		$posts = $query->execute();
		return $posts;
	}
}