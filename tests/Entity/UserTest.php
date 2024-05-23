<?php
// tests/Entity/UserTest.php
namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $user = new User();

        $email = 'test@test.com';
        $lastname = 'Doe';
        $firstname = 'John';
        $password = 'password123';
        $role = 'ROLE_USER';
        $subscriptionEndAt = new \DateTimeImmutable('2024-12-31');
        $createdAt = new \DateTimeImmutable();
        $updatedAt = new \DateTimeImmutable();

        $user->setEmail($email);
        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setPassword($password);
        $user->setRole($role);
        $user->setSubscriptionEndAt($subscriptionEndAt);
        $user->setCreatedAt($createdAt);
        $user->setUpdatedAt($updatedAt);

        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($role, $user->getRole());
        $this->assertEquals($subscriptionEndAt, $user->getSubscriptionEndAt());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
    }
}
