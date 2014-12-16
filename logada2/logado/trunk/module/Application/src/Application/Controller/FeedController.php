<?php
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Application\Constants\Constants;
use Zend\Form\Element\Button;
use Zend\Form\Element\Submit;
use Application\Entity\Post;

/**
 * InitialPostController
 *
 * @author
 *
 * @version
 *
 */
class FeedController extends BaseController
{
        
    private function getFeed()
    {
	    // FIXME : perfil hard-coded
	    $profile_id = 3;
	    $profile = $this->getEntityManager()->find('Application\Entity\Profile', $profile_id);
        $friends = $this->getEntityManager()->getRepository('Application\Entity\Friendship')->getFriendsOf($profile);        
        $postRepo = $this->getEntityManager()->getRepository('Application\Entity\Post');
        
        // posts enviados privadamente para o usuário
        $posts = $postRepo->getPostsSentTo($profile_id);
                
        // posts públicos de seus amigos        
        foreach($friends as $friend)
        {
            $posts = array_merge($posts, $postRepo->getPublicPosts($friend));
        }
        
        // ordena por data de criação
        uksort($posts, function($a, $b) use($posts) {
        	return $posts[$a]->getCreationTime() < $posts[$b]->getCreationTime();
        });
                
        return $posts;
    }
        
    public function indexAction()
    {        
    	$feed = $this->getFeed();
    	$view = new ViewModel(array('feed' => $feed));
    	$postDisplay = new ViewModel(array('feed' => $feed));
    	$postDisplay->setTemplate('application/post/postDisplay');
    	$view->addChild($postDisplay, 'postDisplay');
    	
    	return $view;
    }
}