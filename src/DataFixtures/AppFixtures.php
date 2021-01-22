<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        /* Setting up supper admin user */
        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setFirstName('Adam');
        $user->setLastName('Gill');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'123456'));
        $user->setMobile('9988799887');
        $user->setDob(new \DateTime('1987-01-15'));
        $manager->persist($user);

        /* Setting up menu */
        $menus = [
            [ 'id' => 1, 'parent_id' => NULL, 'name' => 'Main', 'icon' => NULL, 'role' => NULL, 'type' => 'section', 'entity_path' => NULL, ],
            [ 'id' => 2, 'parent_id' => NULL, 'name' => 'Dashboard', 'icon' => 'fa fa-home', 'role' => 'ROLE_ADMIN', 'type' => 'linktoDashboard', 'entity_path' => NULL, ],
            [ 'id' => 3, 'parent_id' => NULL, 'name' => 'Dashboard', 'icon' => 'fa fa-home', 'role' => 'ROLE_AUTHOR', 'type' => 'linktoDashboard', 'entity_path' => NULL, ],
            [ 'id' => 4, 'parent_id' => NULL, 'name' => 'Users', 'icon' => 'fa fa-user', 'role' => 'ROLE_ADMIN', 'type' => 'linkToCrud', 'entity_path' => 'App\\Entity\\User', ],
            [ 'id' => 6, 'parent_id' => NULL, 'name' => 'Menus', 'icon' => 'fa fa-sitemap', 'role' => 'ROLE_ADMIN', 'type' => 'linkToCrud', 'entity_path' => 'App\\Entity\\Menu', ],
            [ 'id' => 8, 'parent_id' => NULL, 'name' => 'Blog', 'icon' => NULL, 'role' => NULL, 'type' => 'section', 'entity_path' => NULL, ],
            [ 'id' => 9, 'parent_id' => NULL, 'name' => 'Category', 'icon' => 'fa fa-code-fork', 'role' => 'ROLE_ADMIN', 'type' => 'linkToCrud', 'entity_path' => 'App\\Entity\\PostCategory', ],
            [ 'id' => 10, 'parent_id' => NULL, 'name' => 'Posts', 'icon' => 'fa fa-hashtag', 'role' => 'ROLE_ADMIN', 'type' => 'linkToCrud', 'entity_path' => 'App\\Entity\\Post', ],
            [ 'id' => 11, 'parent_id' => NULL, 'name' => 'Category', 'icon' => 'fa fa-code-fork', 'role' => 'ROLE_AUTHOR', 'type' => 'linkToCrud', 'entity_path' => 'App\\Entity\\PostCategory', ],
            [ 'id' => 12, 'parent_id' => NULL, 'name' => 'Posts', 'icon' => 'fa fa-hashtag', 'role' => 'ROLE_AUTHOR', 'type' => 'linkToCrud', 'entity_path' => 'App\\Entity\\Post', ]
        ];
        
        foreach ($menus as $item) {
            $menu = new Menu();
            $menu->setId((int)$item['name']);
            $menu->setName($item['name']);
            $menu->setParent($item['parent_id']);
            $menu->setIcon((string)$item['icon']);
            $menu->setRole((string)$item['role']);
            $menu->setType($item['type']);
            $menu->setEntityPath((string)$item['entity_path']);

            $manager->persist($menu);
        }
        
        $manager->flush();
    }
}
