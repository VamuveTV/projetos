<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use Application\Constants\Constants;

use Application\Form\ReportForm;

use Application\Form\AdminUserCreationForm;

class ReportController extends BaseController {

	 public function indexAction() {

        $em = $this->getEntityManager();

		$form = new ReportForm($em);
		
		$sql_users = 'SELECT u FROM Application\Entity\User u';

        $users = $this->getEntityManager()->createQuery($sql_users)->getResult();

        $id = (int) $this->params('id', null);

        $tpView = (int) $this->params('tpView', null);

		return new ViewModel(array(
		'form' => $form, 
		'users' => $users,
		'id' => $id,
		'tpView' => $tpView));
			
    }

	public function quantitativoAction() {

        $id = (int) $this->params('id', null);
        if (null === $id) {
            return $this->redirect()->toRoute('report');
        }
        
        $em = $this->getEntityManager();
        
        $user = $em->find('Application\Entity\User', $id);
		
        $form = new AdminUserCreationForm($em);

        $form->bind($user);

		# Recuperar qantidade de 'Notificações' catalogadas por Usuário.
		
		$sql1=
		
			'SELECT COUNT(n) '.
			'FROM Application\Entity\User u '.
			'JOIN Application\Entity\Notification n '.
			'WITH u.id=n.sender '.
			'WHERE u.id='.$id;

        $amountNotifications = $this->getEntityManager()->createQuery($sql1)->getResult();
		
		# Recuperar quantidade de 'Atividades' registradas por Usuário.
		
		$sql2=
		
			'SELECT COUNT(c) '.
			'FROM Application\Entity\CalendarEvent c '.
			'JOIN Application\Entity\Profile p '.
			'WITH p.id=c.owner '.
			'JOIN Application\Entity\User u '.	
			'WITH u.profile=p.id '.		
			'WHERE u.id='.$id;
		
        $amountActivityByUser = $this->getEntityManager()->createQuery($sql2)->getResult();

		# Recuperar quantidade de 'Atividades' registradas por Terceiros.
		
		$sql3=
		
			'SELECT COUNT(c) '.
			'FROM Application\Entity\CalendarEvent c '.
			'JOIN Application\Entity\Profile p '.
			'WITH p.id=c.receiver '.
			'WHERE p.id=( '.
			'SELECT IDENTITY(u.profile) '.
			'FROM Application\Entity\User u '.	
			'WHERE u.profile='.$id.
			')';
		
        $amountActivityForOthers = $this->getEntityManager()->createQuery($sql3)->getResult();

		# Recuperar quantidade de 'Amigos(as)' Usuário contém.
		
		$sql4=
		
			'SELECT COUNT(p) '.
			'FROM Application\Entity\Profile p '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=p.id '.
			'JOIN Application\Entity\Friendship f '.
			'WITH p.id=f.profile_1 '.
			'WHERE u.id='.$id;
		
        $amountFriends = $this->getEntityManager()->createQuery($sql4)->getResult();

		# Recuperar quantidade de 'Smiles' Usuário publicou em `Post`.
		
		$sql5=
		
			'SELECT COUNT(pt) '.
			'FROM Application\Entity\Profile pf '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'JOIN Application\Entity\Post pt '.
			'WITH pf.id=pt.sender '.
			"WHERE pt.body LIKE '%emoticons/img/%' ".
			'AND u.id='.$id;

        $amountSmiles1 = $this->getEntityManager()->createQuery($sql5)->getResult();

		# Recuperar quantidade de 'Smiles' Usuário publicou em `Evaluation`.

		$sql6=

			'SELECT COUNT(pf) '.
			'FROM Application\Entity\Profile pf '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'JOIN Application\Entity\Evaluation e '.
			'WITH pf.id=e.sender '.
			"WHERE e.body LIKE '%emoticons/img/%'".
			'AND u.id='.$id;

        $amountSmiles2 = $this->getEntityManager()->createQuery($sql6)->getResult();
		
		# Recuperar quantidade de 'Comentários' postados por Usuário em `Post`.

		$sql7=

			'SELECT COUNT(pf) '.
			'FROM Application\Entity\Profile pf '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'JOIN Application\Entity\Post p '.
			'WITH pf.id=p.sender '.
			"WHERE u.id=".$id;

        $amountComments1 = $this->getEntityManager()->createQuery($sql7)->getResult();
		
		# Recuperar quantidade de 'Comentários' postados por Usuário em `Evaluation`.

		$sql8=

			'SELECT COUNT(pf) '.
			'FROM Application\Entity\Profile pf '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'JOIN Application\Entity\Evaluation e '.
			'WITH pf.id=e.sender '.
			"WHERE u.id=".$id;

        $amountComments2 = $this->getEntityManager()->createQuery($sql8)->getResult();
		
		# Recuperar quantidade de 'Posts' destinados por Usuário, especifique REMETENTE desde que seja Amigo.
		
		$sql9 =
		
			'SELECT IDENTITY (f.profile_2) '.
			'FROM Application\Entity\Friendship f , '.
			'Application\Entity\Profile pf ,'.
			'Application\Entity\User u '.
			'WHERE pf.id=f.profile_1 '.
			'AND u.profile=pf.id '.
			'AND u.id='.$id;

        $listFriends = $this->getEntityManager()->createQuery($sql9)->getResult();

		for ( $corr9 = 0 ; $corr9 < sizeof ($listFriends) ; $corr9++ ) {
		
			$sql9X =
			
				'SELECT (pf.display_name), '. 
				"IDENTITY (p.receiver), ". 
				'COUNT(p) '.
				'FROM Application\Entity\Post p '.
				'JOIN Application\Entity\Profile pf '.
				'WITH pf.id=p.sender '.
				'JOIN Application\Entity\User u '.
				'WITH u.profile=pf.id '.
				'WHERE u.id='.$id.
				'AND p.receiver=('.
				$listFriends[$corr9][1].
				') '.
				'GROUP BY p.receiver';
			
			$sql9X = $this->getEntityManager()->createQuery($sql9X)->getResult();
			
			$amountPostsPerFriends[$corr9] = $sql9X;
		
		}
		
		$sql9Z=
		
			'SELECT (pf.id), '.
			'(pf.display_name) '. 
			'FROM Application\Entity\Profile pf '.
			'WHERE NOT pf.id IN ('.$id.')';
		
		$namesPerFriendsZ = $this->getEntityManager()->createQuery($sql9Z)->getResult();
		
		# Recuperar quantidade de 'Users' que enviaram 'Posts' para Usuário, a partir de `Post`.

		$sql10=
		
			'SELECT COUNT(p) '.
			'FROM Application\Entity\Post p '.
			'JOIN Application\Entity\Profile pf '.
			'WITH pf.id=p.receiver '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'WHERE u.id='.$id.
			'AND pf.id=p.receiver '.
			'AND pf.id<>p.sender '.
			'GROUP BY p.sender';

        $amountCommentsForUser1 = $this->getEntityManager()->createQuery($sql10)->getResult();

		# Recuperar quantidade de 'Users' que enviaram 'Posts' para Usuário, a partir de `Evaluation`.

		$sql11=
		
			'SELECT COUNT(e) '.
			'FROM Application\Entity\Evaluation e '.
			'JOIN Application\Entity\Profile pf '.
			'WITH pf.id=e.receiver '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'WHERE u.id='.$id.
			'AND pf.id=e.receiver '.
			'AND pf.id<>e.sender '.
			'GROUP BY e.sender ';
		
        $amountCommentsForUser2 = $this->getEntityManager()->createQuery($sql11)->getResult();
		
		# Recuperar quantidade de 'Handshakes' e 'Hearts' enviados pelo Usuário.

		$sql12=

			'SELECT (g.type), '.
			'COUNT(pf) '.
			'FROM Application\Entity\Gift g '.
			'JOIN Application\Entity\Profile pf '.
			'WITH pf.id=g.sender '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'WHERE u.id='.$id.
			'AND NOT g.type IN (2) '.
			'AND g.receiver<>g.sender '.
			'GROUP BY g.type ';

        $amountHandshakeAndHeart = $this->getEntityManager()->createQuery($sql12)->getResult();
		
		# Recuperar quantidade de 'Handshake' e 'Heart' recebidos pelo Usuário, enviados por Amigo.

		$sql13X =
		
			'SELECT IDENTITY (f.profile_2) '.
			'FROM Application\Entity\Friendship f , '.
			'Application\Entity\Profile pf ,'.
			'Application\Entity\User u '.
			'WHERE pf.id=f.profile_1 '.
			'AND u.profile=pf.id '.
			'AND u.id='.$id;

        $listFriendsX = $this->getEntityManager()->createQuery($sql13X)->getResult();
		
		for ( $corr13 = 0 ; $corr13 < sizeof ($listFriendsX) ; $corr13++ ) {

			$sql13=

				'SELECT (g.sender), '.
				'(g.receiver), '.
				'(g.type), '.
				'COUNT(g) '.
				'FROM Application\Entity\Gift g '.
				'JOIN Application\Entity\Profile pf '.
				'WITH pf.id=g.sender '.
				'JOIN Application\Entity\User u '.
				'WITH u.profile=pf.id '.
				'WHERE u.id='.$id.
				'AND NOT g.type IN (2) '.
				'AND g.receiver=( '.
				$listFriendsX[$corr13][1].
				') '.
				'GROUP BY g.receiver, g.type ';
			
			 $sql13 = $this->getEntityManager()->createQuery($sql13)->getResult();
			 
			 $amountHandshakeAndHeartPerUser[$corr13] = $sql13;

		}
		
		# Recuperar quantidade de Amigos(as) 'Favoritados' pelo Usuário.

		$sql14=

			'SELECT COUNT(f) '.
			'FROM Application\Entity\User u, '.
			'Application\Entity\Profile p, '.
			'Application\Entity\Friendship f '.		
			'WHERE u.profile=p.id '.
			'AND p.id=f.profile_1 '.
			'AND f.favorite = 1'.
			'AND u.id='.$id;

        $amountFavoriteOfUser = $this->getEntityManager()->createQuery($sql14)->getResult();

		# Recuperar a quantidade de Avaliações que haviam sido feitas para 'Users', categoria 'Aluno'.

		$sql15X = 
		
			'SELECT (pf.id) '.
			'FROM Application\Entity\Profile pf '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'WHERE u.role=1';
		
        $sql15X = $this->getEntityManager()->createQuery($sql15X)->getResult();

		$amountEvaluationForStudents = 0;
		
		for ( $corr15=0; $corr15 < sizeof($sql15X); $corr15++ ) {

		$sql15 = 

			'SELECT COUNT(s) '.
			'FROM Application\Entity\Starrating s '.
			'JOIN Application\Entity\Profile pf '.
			'WITH pf.id=s.sender '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'WHERE u.id='.$id.
			'AND s.receiver = '.
			'( '.		
			$sql15X[$corr15][1].
			') '.
			'GROUP BY pf.id';
		
        $sql15 = $this->getEntityManager()->createQuery($sql15)->getResult();
		
		@$auxSql15 = (int) $sql15[0][1];
		
		$amountEvaluationForStudents += $auxSql15;

		}

		# Recuperar a quantidade de Avaliações que haviam sido feitas para 'Users', categoria 'Funcionário'.

		$sql16X = 
		
			'SELECT (pf.id) '.
			'FROM Application\Entity\Profile pf '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'WHERE u.role=2';
		
        $sql16X = $this->getEntityManager()->createQuery($sql16X)->getResult();

		$amountEvaluationForStaff = 0;
		
		for ( $corr16=0; $corr16 < sizeof($sql16X); $corr16++ ) {

			$sql16 =

				'SELECT COUNT(s) '.
				'FROM Application\Entity\Starrating s '.
				'JOIN Application\Entity\Profile pf '.
				'WITH pf.id=s.sender '.
				'JOIN Application\Entity\User u '.
				'WITH u.profile=pf.id '.
				'WHERE u.id='.$id.
				'AND s.receiver = '.
				'( '.		
				$sql16X[$corr16][1].
				') '.
				'GROUP BY pf.id';
			
			$sql16 = $this->getEntityManager()->createQuery($sql16)->getResult();
			
			@$auxSql16 = (int) $sql16[0][1];
			
			$amountEvaluationForStaff += $auxSql16;

		}

		# Recuperar a quantidade de Avaliações que haviam sido feitas para 'Users', categoria 'Escola'.

		$sql17X = 
		
		'SELECT (pf.id) '.
		'FROM Application\Entity\Profile pf '.
		'JOIN Application\Entity\User u '.
		'WITH u.profile=pf.id '.
		'WHERE u.role=0';
		
        $sql17X = $this->getEntityManager()->createQuery($sql17X)->getResult();

		$amountEvaluationForSchools = 0;
		
		for ( $corr17=0; $corr17 < sizeof($sql17X); $corr17++ ) {

			$sql17 =

			'SELECT COUNT(s) '.
			'FROM Application\Entity\Starrating s '.
			'JOIN Application\Entity\Profile pf '.
			'WITH pf.id=s.sender '.
			'JOIN Application\Entity\User u '.
			'WITH u.profile=pf.id '.
			'WHERE u.id='.$id.
			'AND s.receiver = '.
			'( '.		
			$sql17X[$corr17][1].
			') '.
			'GROUP BY pf.id';
			
			$sql17 = $this->getEntityManager()->createQuery($sql17)->getResult();
			
			@$auxSql17 = (int) $sql17[0][1];
			
			$amountEvaluationForSchools += $auxSql17;

		}
		
		# Somente se utilizará desse return ( ) caso $sql9 e $sql13 tenham surtido efeito (diferente de null, empty e/ou vazio) 
		
		if ( !empty( $listFriends ) && 
		( $namesPerFriendsZ ) && 
		( $amountPostsPerFriends ) && 
		( $amountHandshakeAndHeartPerUser )  ) {
		
				return array(
					'form' => $form,
					'id' => $id,
					'amountNotifications' => $amountNotifications,			
					'amountActivityByUser' => $amountActivityByUser,
					'amountActivityForOthers' => $amountActivityForOthers,
					'amountFriends' => $amountFriends,
					'amountSmiles1' => $amountSmiles1,
					'amountSmiles2' => $amountSmiles2,
					'amountComments1' => $amountComments1,
					'amountComments2' => $amountComments2,
					'listFriends' => $listFriends,
					'namesPerFriends' => $namesPerFriendsZ,
					'amountPostsPerFriends' => $amountPostsPerFriends,
					'amountCommentsForUser1' => $amountCommentsForUser1,
					'amountCommentsForUser2' => $amountCommentsForUser2,
					'amountHandshakeAndHeart' => $amountHandshakeAndHeart,
					'amountHandshakeAndHeartPerUser' => $amountHandshakeAndHeartPerUser,
					'amountFavoriteOfUser' => $amountFavoriteOfUser,
					'amountEvaluationForStudents' => $amountEvaluationForStudents,
					'amountEvaluationForStaff' => $amountEvaluationForStaff,
					'amountEvaluationForSchools' => $amountEvaluationForSchools
				);
		
		} else {
		
				return array(
					'form' => $form,
					'id' => $id,
					'amountNotifications' => $amountNotifications,			
					'amountActivityByUser' => $amountActivityByUser,
					'amountActivityForOthers' => $amountActivityForOthers,
					'amountFriends' => $amountFriends,
					'amountSmiles1' => $amountSmiles1,
					'amountSmiles2' => $amountSmiles2,
					'amountComments1' => $amountComments1,
					'amountComments2' => $amountComments2,
					'amountCommentsForUser1' => $amountCommentsForUser1,
					'amountCommentsForUser2' => $amountCommentsForUser2,
					'amountHandshakeAndHeart' => $amountHandshakeAndHeart,
					'amountFavoriteOfUser' => $amountFavoriteOfUser,
					'amountEvaluationForStudents' => $amountEvaluationForStudents,
					'amountEvaluationForStaff' => $amountEvaluationForStaff,
					'amountEvaluationForSchools' => $amountEvaluationForSchools
				);
		
		}
		
    } # encerrar function quantitative.
	
	public function qualitativoAction() {
	
		$id = (int) $this->params('id', null);

		$tpView = (int) $this->params('tpView', null);

        $em = $this->getEntityManager();

		$form = new ReportForm($em);
			
		switch ($tpView) {

		# Recuperar todos os 'Dados Cadastrais' que haviam sido informados por 'User'.
		
		case 4 : 

			$sql1 = 

				'SELECT (u.sex), (u.name), (u.email), (u.role), (u.birthday) '.
				'FROM Application\Entity\User u '.
				'JOIN Application\Entity\Profile pf '.
				'WITH pf.id=u.profile '.
				'WHERE u.id='.$id;

			$detailsDataUser = $this->getEntityManager()->createQuery($sql1)->getResult();

			return array(
			'form' => $form,
			'id' => $id,
			'tpView' => $tpView,
			'detailsDataUser' => $detailsDataUser
			);

		break;

		# Recuperar todos os registros contidos em 'Post' desde que os mesmos tenham sido enviados ao Usuário.
		
		case 5 : 
			
			$sql2 = 
			
				'SELECT pf.id, COUNT(pf), pf.display_name '.
				'FROM Application\Entity\Post p , '.		
				'Application\Entity\User u , '.
				'Application\Entity\Profile pf '.
				'WHERE p.receiver=( '.
				'SELECT pfX.id '.
				'FROM Application\Entity\Profile pfX, '.
				'Application\Entity\User uX '.
				'WHERE pfX.id=uX.profile '.
				'AND  uX.id='.$id.
				') '.
				'AND pf.id=u.profile '.
				'AND pf.id=p.sender '.
				#'AND p.receiver<>p.sender '.
				'GROUP BY p.sender ';
			
			$postCatchForUser = $this->getEntityManager()->createQuery($sql2)->getResult();
			
			if ( !empty ( $postCatchForUser ) ) {
			
				for( $corr2X=0; $corr2X < sizeof($postCatchForUser); $corr2X++ ) {

					$sql2X = 

						'SELECT p.creation_time '.
						'FROM Application\Entity\Post p , '.
						'Application\Entity\User u , '.
						'Application\Entity\Profile pf '.
						'WHERE u.profile=pf.id '.
						'AND pf.id=p.receiver '.
						'AND p.sender='.$postCatchForUser[$corr2X]['id'].
						'AND p.receiver=('.
						'SELECT pfX.id '.
						'FROM Application\Entity\Profile pfX, '.
						'Application\Entity\User uX '.
						'WHERE pfX.id=uX.profile '.
						'AND  uX.id='.$id.		
						') '.
						'ORDER BY p.id DESC';
					
					$sql2X = $this->getEntityManager()->createQuery($sql2X)->getResult();		
					
					$vl2X[$corr2X] = $sql2X[0]['creation_time']->format('d-m-Y');
				
				}

				return array (
				'form' => $form,
				'id' => $id,
				'tpView' => $tpView,
				'postCatchForUser' => $postCatchForUser,
				'sql2X' => $vl2X
				);
			
			} else {
			
				return array (
				'form' => $form,
				'id' => $id,
				'tpView' => $tpView
				);
			
			}
			
		break;

		# Recuperar todos os registros no qual Usuário esteve como Remetente.
		
		case 6 : 

			$llaveDest = (int) $this->params('llaveDest', null);
			
			$llaveRemet = (int) $this->params('llaveRemet', null);
	
			$sql3 = 
			
				'SELECT (p.id), (p.body), (p.creation_time) '.
				'FROM Application\Entity\Post p , '.		
				'Application\Entity\User u , '.
				'Application\Entity\Profile pf '.
				'WHERE pf.id=u.profile '.
				'AND pf.id=p.receiver '.
				'AND p.sender='.$llaveRemet.			
				'AND p.receiver=('.
				'SELECT pfX.id '.
				'FROM Application\Entity\Profile pfX, '.
				'Application\Entity\User uX '.
				'WHERE pfX.id=uX.profile '.
				'AND  uX.id='.$llaveDest.		
				') '.			
				'ORDER BY p.id DESC ';
			
			$postCatchForUserY = $this->getEntityManager()->createQuery($sql3)->getResult();
			
			return array(
			'form' => $form,
			'id' => $id,
			'tpView' => $tpView,
			'postCatchForUserY' => $postCatchForUserY
			);
		
		var_dump ( $postCatchForUserY );
		
		break;
		
		# Recuperar todos os registros no qual Usuário esteve como Remetente.

		case 7 : 

			$llavePost = (int) $this->params('llavePost', null);
			
			$sql4 = 
			
				'SELECT (p.body), (p.creation_time) '. 
				'FROM Application\Entity\Post p '. 
				'WHERE p.id='.$llavePost;
			
			$postCatchForUserZ = $this->getEntityManager()->createQuery($sql4)->getResult();
			
			return array(
			'form' => $form,
			'tpView' => $tpView,
			'postCatchForUserZ' => $postCatchForUserZ
			);
		
		break;
				
		# Recuperar histórico de Posts, do Usuário.
		
		case 8 :
		
			$sql5 = 
	
				'SELECT (p.body), (p.mood), (p.creation_time), (p.id) '.
				'FROM Application\Entity\User u, '.
				'Application\Entity\Profile pf, '.
				'Application\Entity\Post p '.
				'WHERE u.id='.$id.
				'AND pf.id=u.profile '.
				'AND p.sender=pf.id '.
				'AND NOT p.body IS NULL '.
				'ORDER BY p.id DESC';

			$allPosts = $this->getEntityManager()->createQuery($sql5)->getResult();

			return array(
			'form' => $form,
			'id' => $id,
			'tpView' => $tpView,
			'allPosts' => $allPosts
			);
		
		break;		
		
		# Recuperar especificamente um Post, do Usuário.
		
		case 9 :
		
			$llavePost = (int) $this->params('llavePost', null);
			
			$sql6 = 
			
				'SELECT (p.body), (p.mood), (p.creation_time) '. 
				'FROM Application\Entity\Post p '. 
				'WHERE p.id='.$llavePost;
				
			$allPostsX = $this->getEntityManager()->createQuery($sql6)->getResult();
			
			return array(
			'form' => $form,
			'tpView' => $tpView,
			'allPostsX' => $allPostsX
			);
			
		break;
		
		# Recuperar tipo de interações que Usuário realizou com Amigos(as).
		
		case 10 :
		
			$sql7X = 
			
				'SELECT pf.id, pf.display_name, (fX.favorite)	 '.
				'FROM Application\Entity\Friendship fX , '.
				'Application\Entity\Profile pf '.
				'WHERE fX.profile_2=pf.id '.
				'AND fX.profile_1=( '.
				'SELECT pfX.id '.
				'FROM Application\Entity\Profile pfX, '.
				'Application\Entity\User uX '.
				'WHERE uX.profile=pfX.id '.
				'AND uX.id='.$id.
				')';
			
			$sql7X = $this->getEntityManager()->createQuery($sql7X)->getResult();

			# Capturando os tipos de o nome do(a) Amigo(a).
			
			#if ( ( !empty($sql7X) ) && ( sizeof($sql7X) > 0 ) ) {
			if ( ( !empty($sql7X) ) ) {
				
				for ( $corr7 = 0 ; $corr7 < sizeof( $sql7X ) ; $corr7++ ) {
				
					$sql7 = 

						'SELECT (g.receiver), (g.type), COUNT(g) '.
						'FROM '.
						'Application\Entity\Gift g , '.
						'Application\Entity\User u '.					
						'JOIN Application\Entity\Profile p '.
						'WITH p.id=u.profile '.
						' '.
						'WHERE g.receiver='.$sql7X[$corr7]['id'].
						'AND g.sender=p.id '.			
						'AND u.id='.$id.
						'GROUP BY g.type';
					
					$sql7 = $this->getEntityManager()->createQuery($sql7)->getResult();
					
					$typesEvaluationsFriends[$corr7] = $sql7;
					
				}
				
				return array(
				'form' => $form,
				'id' => $id,
				'tpView' => $tpView,
				'typesEvaluationsFriends' => $typesEvaluationsFriends,
				'typesEvaluationsFriendsX' => $sql7X
				);

			}

			return array(
			'form' => $form,
			'id' => $id,
			'tpView' => $tpView
			#,
			#'typesEvaluationsFriends' => $typesEvaluationsFriends,
			#'typesEvaluationsFriendsX' => $sql7X
			);

		break;		
		
		case 11 : 

			$sql8 = 
			
				'SELECT (pf.display_name), (s.value) '.
				'FROM Application\Entity\Starrating s '.
				'JOIN Application\Entity\Profile pf '.
				'WITH pf.id=s.receiver '.
				'JOIN Application\Entity\User u '.
				'WITH u.profile=pf.id '.
				'WHERE u.role=1 '.
				'AND s.sender=( '.
				'SELECT pfX.id '.
				'FROM Application\Entity\Profile pfX '.
				'JOIN Application\Entity\User uX '.
				'WITH uX.profile=pfX.id '.
				'WHERE pfX.id=uX.profile '.
				'AND uX.id='.$id.
				')';

			$sql8 = $this->getEntityManager()->createQuery($sql8)->getResult();
			
			$evaluationsPerTypeRole[0] = $sql8;

			return array(
			'form' => $form,
			'id' => $id,
			'tpView' => $tpView,
			'evaluationsPerTypeRole' => $evaluationsPerTypeRole
			);

		break;
		
		
		case 12 : 

			$sql9 = 
			
				'SELECT (pf.display_name), (s.value) '.
				'FROM Application\Entity\Starrating s '.
				'JOIN Application\Entity\Profile pf '.
				'WITH pf.id=s.receiver '.
				'JOIN Application\Entity\User u '.
				'WITH u.profile=pf.id '.
				'WHERE u.role=2'.
				'AND s.sender=( '.
				'SELECT pfX.id '.
				'FROM Application\Entity\Profile pfX '.
				'JOIN Application\Entity\User uX '.
				'WITH uX.profile=pfX.id '.
				'WHERE pfX.id=uX.profile '.
				'AND uX.id='.$id.
				') ';

			$sql9 = $this->getEntityManager()->createQuery($sql9)->getResult();
			
			$evaluationsPerTypeRole[0] = $sql9;

			return array(
			'form' => $form,
			'id' => $id,
			'tpView' => $tpView,
			'evaluationsPerTypeRole' => $evaluationsPerTypeRole
			);
		
		break;
		
		
		case 13 :

			$sql10 = 
			
				'SELECT (pf.display_name), (s.value) '.
				'FROM Application\Entity\Starrating s '.
				'JOIN Application\Entity\Profile pf '.
				'WITH pf.id=s.receiver '.
				'JOIN Application\Entity\User u '.
				'WITH u.profile=pf.id '.
				'WHERE u.role=0 '.
				'AND s.sender=( '.
				'SELECT pfX.id '.
				'FROM Application\Entity\Profile pfX '.
				'JOIN Application\Entity\User uX '.
				'WITH uX.profile=pfX.id '.
				'WHERE pfX.id=uX.profile '.
				'AND uX.id='.$id.
				') ';

			$sql10 = $this->getEntityManager()->createQuery($sql10)->getResult();
			$evaluationsPerTypeRole[0] = $sql10;

			return array(
			'form' => $form,
			'id' => $id,
			'tpView' => $tpView,
			'evaluationsPerTypeRole' => $evaluationsPerTypeRole
			);

		break;
		
		case 14 : 
		
			$sql11 = 
				
				'SELECT (sb.name) , AVG(g.value) '.
				'FROM Application\Entity\Grade g , '.
				'Application\Entity\Subject sb , '.
				'Application\Entity\School sc , '.
				'Application\Entity\User u , '.
				'Application\Entity\Schoolclass sl '.
				'WHERE g.subject=sb.id  '.
				'AND g.school=sc.id '.
				'AND g.user=u.id '.
				'AND g.schoolClass=sl.id '.
				'AND u.id='.$id.
				'GROUP BY sb.id '.
				'ORDER BY sb.name, g.term';				
				
				/*'SELECT (sb.name), AVG(g.value) '.
				'FROM Application\Entity\Grade g '.
				'JOIN Application\Entity\Subject sb '.
				'WITH sb.id=g.subject '.
				'JOIN Application\Entity\School sc '.
				'WITH sc.id=g.schoolClass '.
				'JOIN Application\Entity\User u '.
				'WITH u.id=g.user '.
				'JOIN Application\Entity\Schoolclass sl '.
				'WITH sl.id=g.user '.
				'WHERE u.id='.$id.
				'AND sb.id=g.subject '.
				'AND sc.id=g.schoolClass '.
				'AND u.id=g.user '.
				'GROUP BY sb.id '.
				'ORDER BY sb.name, g.term';*/
			
			$sql11X = 
			
				'SELECT (u.name) , '.
				'(sb.name) , '.
				'(g.value) ,  '.
				'(g.term) '.
				'FROM Application\Entity\Grade g '.
				'JOIN Application\Entity\Subject sb '.
				'WITH sb.id=g.subject '.
				'JOIN Application\Entity\School sc '.
				'WITH sc.id=g.school '.
				'JOIN Application\Entity\User u '.
				'WITH u.id=g.user '.
				'JOIN Application\Entity\Schoolclass sl '.
				'WITH sl.id=g.schoolClass '.
				'WHERE u.id='.$id.
				'ORDER BY sb.name, g.term';

			$sql11 = $this->getEntityManager()->createQuery($sql11)->getResult();
			
			$sql11X = $this->getEntityManager()->createQuery($sql11X)->getResult();
		
			return array ( 
			'form' => $form, 
			'id' => $id, 
			'tpView' => $tpView, 
			'avgPerSchoolSubjectOfUser' => $sql11, 
			'valueSchoolSubjectOfUser' => $sql11X
			);
		
		break;
		
		# Primeira aparição, somente resgatar valores com find().
		
		default:

		return array(
		'form' => $form,
		'id' => $id,
		'tpView' => $tpView
		);

		break;


		}
		
	}

}