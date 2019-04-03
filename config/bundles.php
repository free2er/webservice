<?php

return [
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class                 => ['all' => true],
    Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class       => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class     => ['all' => true],
    EightPoints\Bundle\GuzzleBundle\EightPointsGuzzleBundle::class       => ['all' => true],
    FOS\RestBundle\FOSRestBundle::class                                  => ['all' => true],
    Free2er\Jwt\JwtAuthenticatorBundle::class                            => ['all' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class                            => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class                => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class                    => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class                  => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class                          => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class                => ['dev' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class            => [
        'dev'  => true,
        'test' => true,
    ],
];
