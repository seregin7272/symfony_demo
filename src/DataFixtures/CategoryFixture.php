<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\FortuneCookie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CategoryFixture extends Fixture
{
    private $fortunes = [
        'job' => [
            'It would be best to maintain a low profile for now.',
            '404 Fortune not found. Abort, Retry, Ignore?',
            'You laugh now, wait til you get home.',
            'If your work is not finished, blame it on the computer.',
        ],
        'lunch' => [
            'You will be hungry again in one hour.',
            'Vampires will soon strike you if you do not order again',
            'A nice cake is waiting for you',
            'Warning: Do not eat your fortune',
        ],
        'proverb' => [
            'A conclusion is simply the place where you got tired of thinking.',
            'Cookie said: "You really crack me up"',
            'When you squeeze an orange, orange juice comes out. Because that\'s what\'s inside.',
        ],
        'pets' => [
            'There\'s no such thing as an ordinary cat',
            'That wasn\'t chicken',
        ],
        'love' => [
            'An alien of some sort will be appearing to you shortly!',
            'Are your legs tired? You\'ve been running through someone\'s mind all day long.',
            'run',
        ],
        'lucky_number' => [
            42,
            12,
            '10^2',
            'Jar Jar Binks',
            'Pi',
        ]
    ];

    private $categories = [
        'job' => [
            'name' => 'Job',
            'iconKey' => 'fa-dollar',
        ],
        'proverb' => [
            'name' => 'Proverbs',
            'iconKey' => 'fa-quote-left',
        ],
        'lucky_number' => [
            'name' => 'Lucky Number',
            'iconKey' => 'fa-bug',
        ],
        'love' => [
            'name' => 'Love',
            'iconKey' => 'fa-heart',
        ],
        'pets' => [
            'name' => 'Pets',
            'iconKey' => 'fa-paw',
        ],
        'lunch' => [
            'name' => 'Lunch',
            'iconKey' => 'fa-spoon',
        ],
    ];
    /** @var Generator */
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker =  $this->faker = Factory::create();

        foreach ($this->categories as $k => $category){
            $entityCategory = new Category();
            $entityCategory->setName($category['name']);
            $entityCategory->setIconKey($category['iconKey']);
            $manager->persist($entityCategory);

            foreach ($this->fortunes[$k] as $fortune){
                $fortuneCookie = new FortuneCookie();
                $fortuneCookie
                    ->setDiscontinued($this->faker->boolean(50))
                    ->setNumberPrinted($this->faker->numberBetween(100, 99999))
                    ->setCategory($entityCategory)
                    ->setCreatedAt($this->faker->dateTimeBetween('-5 years', 'now'))
                    ->setFortune($fortune);

                $manager->persist($fortuneCookie);
            }
        }

        $manager->flush();
    }
}
