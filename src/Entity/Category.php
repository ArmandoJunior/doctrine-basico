<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 28/10/2018
 * Time: 22:49
 */

namespace App\Entity;

/**
 * Class Category
 * @package App\Entity
 * @Entity
 * @Table(name="categories")
 */
class Category
{
    /**
     * @var
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var
     * @Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


}