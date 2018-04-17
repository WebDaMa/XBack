<?php

namespace App\Entity;


use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RefreshTokenRepository")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="token",
 *          column=@ORM\Column(
 *              name     = "token",
 *              length   = 191,
 *              unique   = true
 *          )
 *      )
 * })
 */
class RefreshToken extends BaseRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;
}