<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ticket controller.
 *
 * @Route("ticket1")
 */
class Ticket1Controller extends Controller
{
    /**
     * Lists all ticket entities.
     *
     * @Route("/", name="ticket_index_admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $tickets = $em->getRepository('AppBundle:Ticket')->findAll();

        return $this->render('ticket1/index.html.twig', array(
            'tickets' => $tickets,
        ));
    }

    /**
     * Creates a new ticket entity.
     *
     * @Route("/new", name="ticket_new_admin")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,\Swift_Mailer $mailer)
    {
        $ticket = new Ticket();
        $form = $this->createForm('AppBundle\Form\TicketType', $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ticket->setEmeteur($this->getUser());

            $email = (new \Swift_Message('Nouveau TICKET'))
                ->setFrom('ecosystem@contact.com')
                ->setTo($ticket->getRecepteur()->getEmail())
                ->setBody(
                    $this->renderView(
                        'Emails/ticket.html.twig', [
                            'name' => $ticket->getRecepteur()->getUsername(),
                            'emetteur' => $ticket->getEmeteur()->getUsername(),
                            'id_ticket' => $ticket->getId()
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($email);

            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('ticket_show_admin', array('id' => $ticket->getId()));
        }
        return $this->render('ticket1/new.html.twig', array(
            'ticket' => $ticket,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticket entity.
     *
     * @Route("/{id}", name="ticket_show_admin")
     * @Method("GET")
     */
    public function showAction(Ticket $ticket,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->findByTicket($ticket);

        $message = new Message();
        $form = $this->createForm('AppBundle\Form\MessageType', $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setUser($this->getUser());
            $message->setTicket($ticket);
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('ticket_show_admin', array('id' => $ticket->getId()));
        }

        return $this->render('ticket1/show.html.twig', array(
            'ticket' => $ticket,
            'form' => $form->createView(),
            'messages' => $messages
        ));
    }

    /**
     * Displays a form to edit an existing ticket entity.
     *
     * @Route("/{id}/edit", name="ticket_edit_admin")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ticket $ticket)
    {
        $deleteForm = $this->createDeleteForm($ticket);
        $editForm = $this->createForm('AppBundle\Form\TicketType', $ticket);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticket_index_admin', array('id' => $ticket->getId()));
        }

        return $this->render('ticket1/edit.html.twig', array(
            'ticket' => $ticket,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ticket entity.
     *
     * @Route("/delete/{id}", name="ticket_delete_admin")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ticket $ticket)
    {
        $form = $this->createDeleteForm($ticket);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticket);
            $em->flush();
        }

        return $this->redirectToRoute('ticket_index_admin');
    }

    /**
     * Creates a form to delete a ticket entity.
     *
     * @param Ticket $ticket The ticket entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ticket $ticket)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticket_delete_admin', array('id' => $ticket->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }







}
