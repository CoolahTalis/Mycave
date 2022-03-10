<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use Psr\Log\LoggerInterface;
use App\Form\InscriptionType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSecuController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function register(Request $request, EntityManagerInterface $u, UserPasswordEncoderInterface $encoder, MailerInterface $mailer ): Response
    {

        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            //ON ENCODE LE MDP DE USER, ON LE RECUP ET ON LE SET AVEC ENCODER <!DOCTYPE html
            $passwordCrypt = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordCrypt);
            $u->persist($user);
            $u->flush();
    
            return $this->redirectToRoute('connexion');
        }

        return $this->render('admin_secu/inscription.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     * 
     * @return response
     */
    public function login(AuthenticationUtils $util ): Response
    {
        return $this->render('admin_secu/connexion.html.twig', [
            "lastUsername" => $util->getLastUsername()

        ]);
    }   

    /**
     * @Route("/deconnexion", name="deconnexion")
     *
     * @return response
     */
    public function logout()
    {
    }

    /**
     * @Route("/contact", name="contact")
     *
     * @return repsonse
     */
    public function sendMail(MailerInterface $mailer, LoggerInterface $logger, Request $request): response
    {
// REFACTO !!!! MOVE CODE DANS UN CONTACTTYPE  !!!!!

            $contact = new Contact;



            $form = $this->createFormBuilder($contact)
            ->add('emailfrom', EmailType::class)
            ->add('emailto', EmailType::class)
            ->add('objet', TextType::class)
            ->add('message', TextType::class)
            ->getform();

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {

                $Emailfrom = $form['emailfrom']->getData();
                $emailto = $form['emailto']->getData();
                $objet = $form['objet']->getData();
                $message = $form['message']->getData();

                $contact->setEmailfrom($Emailfrom);
                $contact->setEmailto($emailto);
                $contact->setObjet($objet);
                $contact->setMessage($message);

                $qry = $this->getDoctrine()->getManager();
                $qry->persist($contact);
                $qry->flush();
            

            $mail = (new Email())
                ->From($contact->get('emailfrom')->getData())
                ->To($emailto)
                // ->addTo('celes.thym@gmail.com')  POUR DEST++
                ->subject($objet)
                // ->text('test')
                ->html('<p>'.$message.'</p>');
        

            $mailer->send($mail);
            
            $logger->info('mail envoyé');
            return $this->redirectToRoute('connexion', [
                
                $this->addFlash('notice', 'mail envoyé')
            ]);


        }
            return $this->render('admin_secu/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
        // Creation du msg
        // $email = (new Email())
        //     ->From('t3st3320@gmail.com')
        //     ->To('celes.thym@gmail.com')
        //     // ->addTo('celes.thym@gmail.com')  POUR DEST++
        //     ->subject('test')
        //     ->text('test')
        //     ->html('<p>jglkjklfjkmdlfgjklsdjgmkgjmlksjgmlkdfjlgkjlfkmdsg</p>');
        

        //         $mailer->send($email);




}