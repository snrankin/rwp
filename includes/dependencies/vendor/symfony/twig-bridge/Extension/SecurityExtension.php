<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bridge\Twig\Extension;

use RWP\Vendor\Symfony\Component\Security\Acl\Voter\FieldVote;
use RWP\Vendor\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use RWP\Vendor\Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use RWP\Vendor\Symfony\Component\Security\Http\Impersonate\ImpersonateUrlGenerator;
use RWP\Vendor\Twig\Extension\AbstractExtension;
use RWP\Vendor\Twig\TwigFunction;

/**
 * SecurityExtension exposes security context features.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class SecurityExtension extends Extension\AbstractExtension {
    private $securityChecker;
    private $impersonateUrlGenerator;
    public function __construct(AuthorizationCheckerInterface $securityChecker = null, ImpersonateUrlGenerator $impersonateUrlGenerator = null) {
        $this->securityChecker = $securityChecker;
        $this->impersonateUrlGenerator = $impersonateUrlGenerator;
    }
    /**
     * @param mixed $object
     */
    public function isGranted($role, $object = null, string $field = null): bool {
        if (null === $this->securityChecker) {
            return \false;
        }
        if (null !== $field) {
            $object = new FieldVote($object, $field);
        }
        try {
            return $this->securityChecker->isGranted($role, $object);
        } catch (AuthenticationCredentialsNotFoundException $e) {
            return \false;
        }
    }
    public function getImpersonateExitUrl(string $exitTo = null): string {
        if (null === $this->impersonateUrlGenerator) {
            return '';
        }
        return $this->impersonateUrlGenerator->generateExitUrl($exitTo);
    }
    public function getImpersonateExitPath(string $exitTo = null): string {
        if (null === $this->impersonateUrlGenerator) {
            return '';
        }
        return $this->impersonateUrlGenerator->generateExitPath($exitTo);
    }
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array {
        return [new TwigFunction('is_granted', [$this, 'isGranted']), new TwigFunction('impersonation_exit_url', [$this, 'getImpersonateExitUrl']), new TwigFunction('impersonation_exit_path', [$this, 'getImpersonateExitPath'])];
    }
}
