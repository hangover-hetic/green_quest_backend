<?php

namespace App\Factory;

use App\Entity\FeedPost;
use App\Repository\FeedPostRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<FeedPost>
 *
 * @method        FeedPost|Proxy create(array|callable $attributes = [])
 * @method static FeedPost|Proxy createOne(array $attributes = [])
 * @method static FeedPost|Proxy find(object|array|mixed $criteria)
 * @method static FeedPost|Proxy findOrCreate(array $attributes)
 * @method static FeedPost|Proxy first(string $sortedField = 'id')
 * @method static FeedPost|Proxy last(string $sortedField = 'id')
 * @method static FeedPost|Proxy random(array $attributes = [])
 * @method static FeedPost|Proxy randomOrCreate(array $attributes = [])
 * @method static FeedPostRepository|RepositoryProxy repository()
 * @method static FeedPost[]|Proxy[] all()
 * @method static FeedPost[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static FeedPost[]|Proxy[] createSequence(array|callable $sequence)
 * @method static FeedPost[]|Proxy[] findBy(array $attributes)
 * @method static FeedPost[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FeedPost[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class FeedPostFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->text(70),
            'content' => self::faker()->realTextBetween(100, 400),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(FeedPost $feedPost): void {})
        ;
    }

    protected static function getClass(): string
    {
        return FeedPost::class;
    }
}
