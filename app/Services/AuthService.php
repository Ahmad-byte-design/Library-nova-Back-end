<?php

namespace App\Services;

use App\Repository\Interfaces\UsersRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $authRepo;

    protected $cacheService;

    /**
     * Create a new class instance.
     */
    public function __construct(UsersRepositoryInterface $authRepo, CacheService $cacheService)
    {
        $this->authRepo = $authRepo;
        $this->cacheService = $cacheService;

        //
    }

    public function getAllUsers(int $page = 1)
    {

        try {

            $cacheKey = "users_page_{$page}";
            $ttl = 3600;

            // return $this->cacheService->remember($cacheKey, function () use ($page) {
                $users = $this->authRepo->all($page);
                if (! $users) {
                    return null;
                }

                return $users;
            // }, $ttl, 'users');

        } catch (Exception $e) {

            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function register($data)
    {

        try {
            $data['password'] = Hash::make($data['password']);

            $user = $this->authRepo->create($data);

            if (! $user) {
                throw new Exception('failed to create user!');
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ];

        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }

    public function login($data)
    {

        try {
            $user = $this->authRepo->findByEmail($data['email']);
            if (! $user || ! Hash::check($data['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['invalid credentials.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];

        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }

    }

    public function updateName($id, $name)
    {

        if (empty($name) || strlen($name) > 255) {
            throw new \InvalidArgumentException('Name must be between 1 and 255 characters.');
        }

        $user = $this->authRepo->update($id, ['name' => $name]);

        if (! $user) {
            throw new Exception('User not found or update failed.');
        }

        return $user;
    }

    public function logout($user)
    {
        try {
            $user->tokens()->delete();

            return true;
        } catch (Exception $e) {
            throw new Exception('Registration failed: '.$e->getMessage());
        }
    }
}
