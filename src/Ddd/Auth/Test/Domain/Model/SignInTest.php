<?php

namespace Ddd\Auth\Test\Domain\Model;

use Ddd\Auth\Domain\Model\User\SignIn;
use Ddd\Auth\Domain\Model\User\UserRepository;
use Ddd\Auth\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use Ddd\Auth\Infrastructure\Authentication\NoEncryptionSignIn;
use Ddd\Auth\Domain\Model\User\User;
use PHPUnit_Framework_TestCase;

class SignInTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SignIn
     */
    private $signIn;

    /**
     * @var UserRepository
     */
    private $userRepository;

    protected function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->signIn = new NoEncryptionSignIn(
            $this->userRepository
        );
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function itShouldComplainIfTheUserDoesNotExist()
    {
        $this->signIn->execute('test-username', 'test-password');
    }

    /**
     * @test
     * @expectedException BadCredentialsException
     */
    public function itShouldTellIfTheUserIsFoundButThePasswordDoesNotMatch()
    {
        $this->userRepository->add(
            new User(
                'test-username',
                'test-password'
            )
        );

        $this->signIn->execute('test-username', 'no-matching-password');
    }

    /**
     * @test
     */
    public function itShouldTellIfTheUserIsFoundAndMatchesTheProvidedPassword() {
        $this->userRepository->add(
            new User(
                'test-username',
                'test-password'
            )
        );

        $this->assertInstanceOf(
            'Ddd\Domain\Model\User\User',
            $this->signIn->execute('test-username', 'test-password')
        );
    }
}