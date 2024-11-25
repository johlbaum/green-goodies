<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        //Users
        $user = new User();
        $user->setEmail("user.one@greengoodies.com");
        $user->setFirstName("User");
        $user->setLastName("One");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        $user = new User();
        $user->setEmail("user.two@greengoodies.com");
        $user->setFirstName("User");
        $user->setLastName("Two");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        $user = new User();
        $user->setEmail("user.tree@greengoodies.com");
        $user->setFirstName("User");
        $user->setLastName("Tree");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        // Products
        $product1 = new Product();
        $product1->setName('Kit d\'hygiène recyclable');
        $product1->setShortDescription('Pour une salle de bain éco-friendly');
        $product1->setFullDescription('Kit d\'hygiène 100% bio et recyclable, pour une salle de bain zéro déchet. Chaque élément est fabriqué à partir de matériaux naturels et durables, dans le respect de l\'environnement. Parfait pour une routine éthique et responsable, sans compromis sur la qualité. Tous les produits sont biodégradables et exempts de plastique. Un choix idéal pour réduire votre empreinte écologique au quotidien.');
        $product1->setPrice(24.99);
        $product1->setPicture('/images/products/kit-hygiene.webp');
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Shot Tropical');
        $product2->setShortDescription('Fruits frais, pressés à froid');
        $product2->setFullDescription('Un mélange de fruits frais, issus de l\'agriculture biologique, pressés à froid pour préserver toutes leurs vitamines et antioxydants. Ce shot 100% naturel est une véritable cure de bien-être. Pas de conservateurs, pas de sucres ajoutés, seulement le meilleur de la nature. Un goût vibrant et énergisant, pour un mode de vie sain et durable.');
        $product2->setPrice(4.50);
        $product2->setPicture('/images/products/shot-tropical.webp');
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName('Gourde en bois');
        $product3->setShortDescription('50cl, bois d’olivier');
        $product3->setFullDescription('Cette gourde est fabriquée à partir de bois d\'olivier durable, récolté de manière éthique et responsable. Elle est conçue pour durer et vous accompagner dans vos moments de détente ou vos activités sportives. Sa capacité de 50cl permet une hydratation optimale, tout en réduisant l\'utilisation de plastique. Un accessoire éco-responsable, alliant élégance et durabilité, pour ceux qui choisissent un mode de vie plus vert.');
        $product3->setPrice(16.99);
        $product3->setPicture('/images/products/gourde-bois.webp');
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setName('Disques Démaquillants x30');
        $product4->setShortDescription('Solution efficace pour vous démaquiller en douceur');
        $product4->setFullDescription('Ces disques démaquillants sont fabriqués à partir de coton bio, doux pour la peau et respectueux de l\'environnement. Lavables et réutilisables, ils offrent une alternative durable aux disques jetables. Un geste simple pour votre peau et la planète. Le coton bio est cultivé sans pesticides ni produits chimiques, pour un soin doux et éthique au quotidien.');
        $product4->setPrice(9.99);
        $product4->setPicture('/images/products/disques.webp');
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setName('Bougie Lavande & Patchouli');
        $product5->setShortDescription('Cire naturelle');
        $product5->setFullDescription('Bougie fabriquée à partir de cire naturelle, sans produits chimiques ni additifs nocifs. L\'association de lavande et patchouli crée une ambiance apaisante et relaxante, idéale pour la détente. La cire utilisée est biodégradable et provient de sources durables, respectant l\'environnement. Un produit éthique qui vous permet de profiter d\'un parfum agréable tout en réduisant votre empreinte écologique.');
        $product5->setPrice(22);
        $product5->setPicture('/images/products/bougies.webp');
        $manager->persist($product5);

        $product6 = new Product();
        $product6->setName('Brosse à dent');
        $product6->setShortDescription('Bois de hêtre rouge issu de forêts gérées durablement');
        $product6->setFullDescription('Cette brosse à dents est fabriquée à partir de bois de hêtre rouge, provenant de forêts gérées de manière durable. Son manche est biodégradable et son design simple permet une prise en main optimale. Les poils sont en nylon recyclable, sans BPA, pour une hygiène bucco-dentaire naturelle et respectueuse de l\'environnement. Un produit zéro déchet et éthique pour un soin de qualité.');
        $product6->setPrice(5.40);
        $product6->setPicture('/images/products/brosses.webp');
        $manager->persist($product6);

        $product7 = new Product();
        $product7->setName('Kit couvert en bois');
        $product7->setShortDescription('Revêtement Bio en olivier & sac de transport');
        $product7->setFullDescription('Ce kit de couverts en bois d\'olivier est idéal pour remplacer les ustensiles jetables. Conçu dans une démarche éco-responsable, chaque couvert est fabriqué à la main à partir de bois d\'olivier, un matériau durable et éthique. Il est livré avec un sac de transport en tissu bio, pour emporter vos couverts partout avec vous. Un choix parfait pour vos repas à emporter ou vos pique-niques.');
        $product7->setPrice(12.30);
        $product7->setPicture('/images/products/brosses.webp');
        $manager->persist($product7);

        $product8 = new Product();
        $product8->setName('Nécessaire, déodorant Bio');
        $product8->setShortDescription('50ml déodorant à l’eucalyptus');
        $product8->setFullDescription('Déodorant bio à l\'eucalyptus, fabriqué avec des ingrédients naturels, certifiés biologiques. Il offre une protection longue durée tout en respectant votre peau et l\'environnement. Sa formulation sans aluminium, sans parabens et sans produits chimiques vous permet de prendre soin de vous de manière éthique. Le packaging est également recyclable, pour réduire l\'impact environnemental.');
        $product8->setPrice(8.50);
        $product8->setPicture('/images/products/deo.webp');
        $manager->persist($product8);

        $product9 = new Product();
        $product9->setName('Savon Bio');
        $product9->setShortDescription('Thé, Orange & Girofle');
        $product9->setFullDescription('Ce savon bio est formulé à base de produits naturels, comme le thé, l\'orange et la girofle, pour un nettoyage doux et agréable. Tous les ingrédients sont issus de l\'agriculture biologique, garantissant un soin respectueux de la peau et de l\'environnement. Le savon est fabriqué sans parabens, sulfates ou produits chimiques, pour une expérience de soin pure et authentique. Un geste éthique au quotidien pour une peau propre et nourrie.');
        $product9->setPrice(18.90);
        $product9->setPicture('/images/products/savon.webp');
        $manager->persist($product9);

        $manager->flush();
    }
}
