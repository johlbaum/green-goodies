<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $product1 = new Product();
        $product1->setName('Savon bio');
        $product1->setShortDescription('Savon naturel fait main');
        $product1->setFullDescription('Ce savon bio est fabriqué à la main avec des ingrédients 100 % naturels. Il est doux pour la peau et convient à tous les types de peau, même les plus sensibles. Enrichi en huiles essentielles, il laisse une agréable odeur sur la peau. Optez pour un choix éthique et respectueux de l\'environnement.');
        $product1->setPrice(5.99);
        $product1->setPicture('https://cdn.shopify.com/s/files/1/2281/4553/files/SAVON_NATURE_3_480x480.jpg?v=1659358946');
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Déodorant éthique');
        $product2->setShortDescription('Déodorant sans aluminium');
        $product2->setFullDescription('Ce déodorant naturel est formulé sans aluminium et sans produits chimiques agressifs. Il offre une protection efficace tout en respectant votre peau et l\'environnement. Avec des ingrédients biologiques, il vous laisse une sensation de fraîcheur tout au long de la journée. Faites le choix d\'un produit éthique et responsable.');
        $product2->setPrice(7.50);
        $product2->setPicture('https://www.comme-avant.bio/cdn/shop/products/deodorant-solide-au-beurre-de-cacao-version-3-deo-nat-solid-cacao-v3-comme-avant-440220_2048x.jpg?v=1689765117');
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName('Brosse à dents en bambou');
        $product3->setShortDescription('Brosse à dents écologique');
        $product3->setFullDescription('Cette brosse à dents en bambou est l\'alternative parfaite aux brosses en plastique. Elle est fabriquée à partir de bambou durable, ce qui en fait un choix respectueux de l\'environnement. Sa douceur permet un nettoyage efficace sans abîmer les gencives. En optant pour cette brosse à dents, vous contribuez à réduire les déchets plastiques.');
        $product3->setPrice(3.50);
        $product3->setPicture('https://m.media-amazon.com/images/I/51l5aQhODiL._AC_.jpg');
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setName('Bougie parfumée bio');
        $product4->setShortDescription('Bougie naturelle');
        $product4->setFullDescription('Cette bougie parfumée est fabriquée à la main avec de la cire naturelle et des huiles essentielles. Elle crée une ambiance chaleureuse et apaisante dans votre maison. En choisissant une bougie bio, vous évitez les produits chimiques nocifs pour votre santé et l\'environnement. Profitez d\'un moment de détente tout en respectant la planète.');
        $product4->setPrice(12.00);
        $product4->setPicture('https://www.ohme.shop/453-large_default/bougie-parfumee-apres-la-pluie-40h.webp');
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setName('Gourde réutilisable');
        $product5->setShortDescription('Gourde en inox');
        $product5->setFullDescription('Cette gourde en inox est parfaite pour les personnes soucieuses de l\'environnement. Elle est réutilisable et permet de réduire considérablement l\'utilisation de plastique à usage unique. Sa conception isotherme garde vos boissons chaudes ou froides pendant des heures. Emportez-la partout avec vous et faites un geste pour la planète.');
        $product5->setPrice(19.99);
        $product5->setPicture('https://shop-ta-gourde.com/cdn/shop/products/gourde-inox-bois_600x600.jpg?v=1597938736');
        $manager->persist($product5);

        $product6 = new Product();
        $product6->setName('Disques démaquillants lavables');
        $product6->setShortDescription('Disques en coton bio');
        $product6->setFullDescription('Ces disques démaquillants lavables sont fabriqués en coton bio, doux et respectueux de la peau. Ils remplacent les disques jetables et contribuent à réduire les déchets. Faciles à nettoyer, il vous suffit de les passer à la machine pour les réutiliser. Adoptez une routine beauté éco-responsable avec ces disques pratiques et durables.');
        $product6->setPrice(10.00);
        $product6->setPicture('https://tootopoids.com/wp-content/uploads/2018/09/Disques-d%C3%A9maquillant-lavable-chez-tootopoids.jpg');
        $manager->persist($product6);

        $manager->flush();
    }
}
