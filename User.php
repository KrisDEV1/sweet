<?php

namespace userdata;


class User
{
    private $id;
    private $facebookId;
    private $userName;
    private $userEmail;
    private $userImage;
    private $isActive;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param mixed $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return mixed
     */
    public function getUserImage()
    {
        return $this->userImage;
    }

    /**
     * @param mixed $userImage
     */
    public function setUserImage($userImage)
    {
        $this->userImage = $userImage;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }


    public function userDataArray(array $userData)
    {
        $this->id = $userData['id'];
        $this->facebookId = $userData['facebook_id'];
        $this->userName = $userData['userName'];
        $this->userEmail = $userData['userEmail'];
        $this->userImage = $userData['userImage'];
        $this->isActive = $userData['is_active'];

        return $this;
    }


}

class Token
{
    private $id;
    private $userId;
    private $token;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function tokenArray(array $tokenData)
    {
        $this->id = $tokenData['id'];
        $this->userId = $tokenData['user_id'];
        $this->token = $tokenData['token'];

        return $this;
    }
}


class UserDB
{

private $pdo;

    public function __construct(\PDO $PDO)
    {
        $this->pdo = $PDO;
    }

    public function saveData (array $userData)
    {
        if (isset($userData['id'])){
            $sqlquery = "INSERT INTO users (`facebook_id`,`name`,`email`,`image`,`is_active`) VALUES (:facebook_id, :userName, :userEmail, :userImage, :is_active)";
            $stmt = $this->pdo->prepare($sqlquery);
        } else {
          $sqlquery = "UPDATE users SET `facebook_id` = :facebook_id, `name` = :userName, `email` = :userEmail, `image` = :userImage, `is_active` = :is_active WHERE `id` = :id";
          $stmt = $this->pdo->prepare($sqlquery);
          $stmt->bindValue(":id", $userData['id']);
        }

        $stmt->bindValue(":facebook_id", "{$userData['facebook_id']}");
        $stmt->bindValue(":name", "{$userData['userName']}");
        $stmt->bindValue(":email", "{$userData['userEmail']}");
        $stmt->bindValue(":image", "{$userData['userImage']}");
        $stmt->bindValue(":is_active", $userData['is_active']);
        $stmt->execute();

        $user = new User();
        $user->userDataArray($userData);

        return $user;

    }

    public function saveTokenData(array $tokenData) {
        $sqlquery = "INSERT INTO access_token (`user_id`, `token`) VALUES (:user_id, :token)";
        $stmt = $this->pdo->prepare($sqlquery);

        $stmt->bindValue(":user_id", $tokenData['user_id']);
        $stmt->bindValue(":token", "{$tokenData['token']}");
        $stmt->execute();

        $data['id'] = $this->pdo->lastInsertId();

        $accToken = new Token();
        $accToken->tokenArray($tokenData);

        return $accToken;
    }

}