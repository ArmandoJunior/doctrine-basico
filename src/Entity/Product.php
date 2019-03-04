<?php
/**
 * Created by PhpStorm.
 * User: arman
 * Date: 03/11/2018
 * Time: 14:47
 */
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Product
 * @Entity
 * @Table(name="products")
 */
class Product
{
    /**
     * @var integer
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", length=150, unique=true, nullable=false)
     */
    private $name;

    /**
     * @var integer
     * @Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    private $amount;

    /**
     * @var float
     * @Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var string
     * @Column(type="text")
     */
    private $description;

    /**
     * @var
     * @Column(type="integer", options={"default":0})
     */
    private $spotlight;

    /**
     * @ManyToMany(targetEntity="App\Entity\Category")
     */
    private $categories;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category)
    {
        $this->categories->add($category);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Product
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpotlight()
    {
        return $this->spotlight;
    }

    /**
     * @param mixed $spotlight
     * @return Product
     */
    public function setSpotlight($spotlight)
    {
        $this->spotlight = $spotlight;
        return $this;
    }





}