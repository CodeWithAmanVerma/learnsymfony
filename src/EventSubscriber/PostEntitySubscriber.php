<?php

    namespace App\EventSubscriber;

    use App\Entity\Post;
    use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
    use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Symfony\Component\Security\Core\Security;
    use Symfony\Component\String\Slugger\SluggerInterface;

    class PostEntitySubscriber implements EventSubscriberInterface {
        private $slugger;

        public function __construct(Security $security, SluggerInterface $slugger) {
            $this->slugger = $slugger;
            $this->security = $security;
        }

        public static function getSubscribedEvents(){
            return [
                BeforeEntityPersistedEvent::class => ['setPost'],
                BeforeEntityUpdatedEvent::class => ['updatePost'],
            ];
        }

        public function setPost(BeforeEntityPersistedEvent $event){
            $entity = $event->getEntityInstance();
            if ($entity instanceof Post) {
                $entity->setPostAuthor($this->security->getUser());
                $entity->setCreated(new \DateTime());
                $entity->setUpdated(new \DateTime());
                $entity->setPostSlug($this->slugger->slug($entity->getPostTitle()));
            }
            
            return;
        }

        public function updatePost(BeforeEntityUpdatedEvent $event){
            $entity = $event->getEntityInstance();
            if ($entity instanceof Post) {
                $entity->setPostSlug($this->slugger->slug($entity->getPostTitle()));
                $entity->setUpdated(new \DateTime());
            }
            
            return;
        }
    }
