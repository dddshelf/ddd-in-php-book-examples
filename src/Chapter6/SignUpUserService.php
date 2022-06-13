<?php

namespace Chapter6;

//snippet code
class SignUpUserService implements ApplicationService
{
    private UserRepository $userRepository;
    private UserFactory $userFactory;
    private UserTransformer $userTransformer;

    public function __construct(
        UserRepository $userRepository,
        UserFactory $userFactory,
        UserTransformer $userTransformer
    )
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param SignUpUserRequest $request
     * @throws UserAlreadyExistsException
     */
    public function execute(SignUpUserRequest $request): User
    {
        $email = $request->email();
        $password = $request->password();

        $user = $this->userRepository->userOfEmail($email);
        if ($user) {
            throw new UserAlreadyExistsException();
        }

        $user = $this->userFactory->build(
            $this->userRepository->nextIdentity(),
            $email,
            $password
        );

        $this->userRepository->add($user);
        $this->userTransformer->write($user);
    }
}
//end-snippet
